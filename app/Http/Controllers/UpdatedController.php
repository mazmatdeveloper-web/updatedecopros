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

class UpdatedController extends Controller
{
    public function booking()
    {
        $services = Service::all();
        return view('updated-frontend.booking',compact('services'));
    }

    public function booking_extended(Request $request)
    {
        if (!session()->has('book.address') || !session()->has('book.service_type')) {
            $request->validate([
                'address' => 'required|string|max:255',
                'service_type' => 'required|array|min:1',
            ]);
    
            // Store in session
            session([
                'book.address' => $request->address,
                'book.service_type' => $request->service_type,
            ]);
        }
    
        $selectedDate = $request->input('date') ?? Carbon::today()->toDateString();
        $dayName = Carbon::parse($selectedDate)->format('l');

        $booking = [
            'address' => session('book.address'),
            'service_type' => session('book.service_type'),
        ];

        $serviceIds = session('book.service_type', []); // This should be an array of service IDs
        $services = Service::all();

        $addons = Addon::all();

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

        return view('updated-frontend.booking-extended',compact(['booking','services','addons','serviceIds','selectedDate','employees']));
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
}
