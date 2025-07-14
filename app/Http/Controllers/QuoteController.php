<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Zipcode;
use App\Models\Service;
use App\Models\AvailableDate;
use App\Models\Appointment;
use App\Models\Employee;
use App\Models\BedAreaSqft;
use App\Models\Addon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function quote(Request $request)
    {     
    
    $zip = $request->input('zipcode');
    $exists = Zipcode::where('codes', $zip)->exists();

    return response()->json(['exists' => $exists]);
    }

    public function quote_page()
    {
        return view('frontend.quote');
    }

    
    public function quote_extended(Request $request)
    {
        $isPost = $request->isMethod('post');

        // Try to pull from POST or fallback to session if coming from GET or AJAX
        $address = $isPost ? $request->input('address') : session('booking.address');
        $serviceIds = $isPost ? $request->input('service_type', []) : session('booking.services', []);

        if ($isPost) {
            $request->validate([
                'address' => 'required|string|max:255',
                'service_type' => 'required|array|min:1',
            ]);

            // Store in session
            session([
                'booking.address' => $address,
                'booking.services' => $serviceIds,
            ]);
        }

        // Fallback: If GET is missing data, redirect back or show error
        if (!$address || empty($serviceIds)) {
            return redirect()->route('booking')->withErrors(['error' => 'Missing required booking data.']);
        }

        // Selected date from GET or default to today
        $selectedDate = $request->input('date') ?? Carbon::today()->toDateString();
        $dayName = Carbon::parse($selectedDate)->format('l');

        // Load employees with availability
        $employees = Employee::whereHas('services', function ($q) use ($serviceIds) {
            $q->whereIn('services.id', $serviceIds);
        })
        ->with([
            'availableDates' => function ($q) use ($selectedDate) {
                $q->where('dates', $selectedDate)->with('timeSlots');
            },
            'recurringAvailabilities' => function ($q) use ($dayName) {
                $q->where('day_of_week', $dayName);
            }
        ])
        ->get();

        foreach ($employees as $employee) {
            $slots = [];

            $bookedSlots = Appointment::where('employee_id', $employee->id)
                ->where('appointment_date', $selectedDate)
                ->pluck('start_time')
                ->map(fn($time) => Carbon::parse($time)->format('H:i'))
                ->toArray();

            $availabilityUsed = false;

            if ($employee->availableDates->isNotEmpty()) {
                $availability = $employee->availableDates->first();
                foreach ($availability->timeSlots as $timeSlot) {
                    $interval = $timeSlot->interval ?? 60;
                    $generatedSlots = $this->generateTimeSlots($timeSlot->start_time, $timeSlot->end_time, $interval);

                    foreach ($generatedSlots as $slot) {
                        [$start] = explode(' - ', $slot);
                        if (!in_array($start, $bookedSlots)) {
                            $slots[] = $slot;
                        }
                    }
                }
                $availabilityUsed = true;
            }

            if (!$availabilityUsed && $employee->recurringAvailabilities->isNotEmpty()) {
                foreach ($employee->recurringAvailabilities as $recurring) {
                    $interval = $recurring->interval ?? 60;
                    $generatedSlots = $this->generateTimeSlots($recurring->start_time, $recurring->end_time, $interval);

                    foreach ($generatedSlots as $slot) {
                        [$start] = explode(' - ', $slot);
                        if (!in_array($start, $bookedSlots)) {
                            $slots[] = $slot;
                        }
                    }
                }
            }

            $employee->available_slots = $slots;
        }

        if ($request->ajax()) {
            $html = view('frontend.partials.employees', compact('employees'))->render();
            return response()->json(['html' => $html]);
        }

        $addons = Addon::all();
        $services = Service::all();

        $quoteData = [
            'address' => $address,
            'service_type' => $serviceIds,
        ];

        return view('frontend.quote-extended', compact(
            'employees',
            'services',
            'serviceIds',
            'selectedDate',
            'quoteData',
            'addons'
        ));
    }

    
    private function generateTimeSlots($start, $end, $interval)
    {
        $slots = [];
        $startTime = Carbon::parse($start);
        $endTime = Carbon::parse($end);
    
        while ($startTime->lt($endTime)) {
            $slotStart = $startTime->format('H:i');
            $slotEnd = $startTime->copy()->addMinutes($interval)->format('H:i');
    
            if ($startTime->copy()->addMinutes($interval)->lte($endTime)) {
                $slots[] = $slotStart . ' - ' . $slotEnd;
            }
    
            $startTime->addMinutes($interval);
        }
    
        return $slots;
    }


    public function calculatePrices(Request $request)
    {
        $filters = $request->all();

        // Get selected service IDs
        $selectedServiceIds = $filters['service_type'] ?? [];
        
        // Get all employees with related services
        $employees = Employee::with(['services'])->get();
        
        // Get selected addons
        $selectedAddonIds = $filters['addons'] ?? [];
        $addons = Addon::whereIn('id', $selectedAddonIds)->get();
        $addonTotalPrice = $addons->sum('price');
        
        $response = [];
        
        foreach ($employees as $employee) {
            $servicePriceTotal = 0;
            $selectedServiceNames = [];
        
            $employeeSelectedServices = $employee->services->whereIn('id', $selectedServiceIds);
        
            foreach ($employeeSelectedServices as $service) {
                $servicePriceTotal += $service->price;
                $selectedServiceNames[] = $service->service_name;
            }
        
            // Remove duplicates and empty values
            $selectedServiceNames = array_unique(array_filter($selectedServiceNames));

        
        
            $basePrice = $servicePriceTotal + $addonTotalPrice;
        
            $response[] = [
                'employee_id' => $employee->id,
                'employee_name' => $employee->name,
                'price' => number_format($basePrice, 0),
                'servicePrice' => $servicePriceTotal,
                'addons' => $addons,
                'service_names' => $selectedServiceNames
            ];
        }

        return response()->json($response);
    }


    public function quote_checkout(Request $request)
    {
        
        $employeeId = $request->query('employee');
        $slot = $request->query('slot');
        $serviceIds = $request->query('services', []); 
        $selectedDate = $request->query('selecteddate');
        $addons = $request->query('addons', []); 


        // Load employee with services
        $employee = Employee::findOrFail($employeeId);

        // Get selected services (filtering from employee's available services)
        $selectedServices = Service::whereIn('id', $serviceIds)->get();

        // Calculate service total price
        $servicePrice = $selectedServices->sum('price');

        // Get selected addons
        $selectedAddons = Addon::whereIn('id', $addons)->get();
        $addonTotal = $selectedAddons->sum('price');

        // Calculate final prices
        $totalPrice = $servicePrice + $addonTotal;
        $oneTimePrice = $totalPrice;

        session([
            'booking.addons' => $request->input('addons', []),
            'booking.selected_date' => $selectedDate,
        ]);

        return view('frontend.quote-checkout', compact(
            'employee',
            'slot',
            'selectedDate',
            'selectedServices',  // Pass all selected service models
            'servicePrice',
            'totalPrice',
            'oneTimePrice',
            'selectedAddons',
            'serviceIds'
        ));
        
            
    }
    
 

}
