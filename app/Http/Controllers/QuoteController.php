<?php

namespace App\Http\Controllers;

use App\Models\Zipcode;
use App\Models\Service;
use App\Models\AvailableDate;
use App\Models\Cleaner;
use App\Models\Appointment;
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
        $quoteData = [
            'address' => $request->address,
            'service_duration' => $request->service_duration,
            'service_type' => $request->service_type,
            'pets' => $request->pets,
            'beds' => $request->beds,
            'baths' => $request->baths,
            'sq_ft' => $request->sq_ft
        ];

        $selectedDate = $request->input('date') ?? Carbon::today()->toDateString();
        $dayName = Carbon::parse($selectedDate)->format('l');
    
        // Fetch all cleaners with their availability
        $cleaners = Cleaner::with([
            'availableDates' => function ($q) use ($selectedDate) {
                $q->where('dates', $selectedDate)->with('timeSlots');
            },
            'recurringAvailabilities' => function ($q) use ($dayName) {
                $q->where('day_of_week', $dayName);
            }
        ])->get();
    
        foreach ($cleaners as $cleaner) {
            $slots = [];
    
            $bookedSlots = Appointment::where('cleaner_id', $cleaner->id)
                ->where('appointment_date', $selectedDate)
                ->pluck('start_time')
                ->map(fn($time) => Carbon::parse($time)->format('H:i'))
                ->toArray();
    
            $availabilityUsed = false;
    
            if ($cleaner->availableDates->isNotEmpty()) {
                $availability = $cleaner->availableDates->first();
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
    
            if (!$availabilityUsed && $cleaner->recurringAvailabilities->isNotEmpty()) {
                foreach ($cleaner->recurringAvailabilities as $recurring) {
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
    
            $cleaner->available_slots = $slots;
        }
    
        if ($request->ajax()) {
            $html = view('frontend.partials.cleaners', compact('cleaners'))->render();
            return response()->json(['html' => $html]);
        }

        $addons = Addon::all();
    
        return view('frontend.quote-extended', compact('cleaners', 'selectedDate','quoteData', 'addons'));
    }
    
    private function generateTimeSlots($start, $end, $interval)
    {
        $slots = [];
        $startTime = Carbon::parse($start);
        $endTime = Carbon::parse($end);
    
        while ($startTime->lt($endTime)) {
            $slotStart = $startTime->format('h:i');
            $slotEnd = $startTime->copy()->addMinutes($interval)->format('h:i');
    
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

    
        $cleaners = Cleaner::with(['bed_area_sqfts', 'bath_area_sqfts', 'service'])->get();
    
        $response = [];
    
        foreach ($cleaners as $cleaner) {
            $basePrice = 0;
    
            // Parse sqft range
            [$minSqft, $maxSqft] = explode('-', str_replace(' ', '', $filters['area']));
    
            // Get bed price (or 0 if not found)
            $bedPriceModel = $cleaner->bed_area_sqfts
                ->where('beds', $filters['beds'])
                ->first(function ($item) use ($minSqft, $maxSqft) {
                    return $item->no_of_sqft >= $minSqft && $item->no_of_sqft <= $maxSqft;
                });
            $bedPrice = $bedPriceModel->price ?? 0;
    
            // Get bath price (or 0 if not found)
            $bathPriceModel = $cleaner->bath_area_sqfts
                ->where('baths', $filters['baths'])
                ->first(function ($item) use ($minSqft, $maxSqft) {
                    return $item->no_of_sqft >= $minSqft && $item->no_of_sqft <= $maxSqft;
                });
            $bathPrice = $bathPriceModel->price ?? 0;
    
            // Get service price (or 0 if not found)
            $servicePriceModel = $cleaner->service
                ->where('service_name', $filters['service_type'])
                ->first();
            $servicePrice = $servicePriceModel->price ?? 0;
    
            // Pet charge
            // $petCharge = ($filters['pets'] === 'yes_pets') ? 10 : 0;
                
            $selectedAddonIds = $filters['addons'] ?? [];
            $addons = Addon::whereIn('id', $selectedAddonIds)->get();
            $addonTotalPrice = $addons->sum('price');
            // Total base price
            $basePrice = $bedPrice + $bathPrice + $servicePrice + $addonTotalPrice;;
    
            // Discount logic
            $discounts = [
                'one_time' => 0,
                'monthly' => 0.10,
                'biweekly' => 0.15,
                'weekly' => 0.20,
            ];
            $discount = $discounts[$filters['service_duration']] ?? 0;
            $finalPrice = $basePrice * (1 - $discount);
    
            $response[] = [
                'cleaner_id' => $cleaner->id,
                'cleaner_name' => $cleaner->name,
                'price' => number_format($finalPrice, 0),
            ];
        }
    
        return response()->json($response);
    }

    public function quote_checkout(Request $request)
    {
        $cleanerId = $request->query('cleaner');
        $slot = $request->query('slot');
        $beds = $request->query('beds');
        $baths = $request->query('baths');
        $service = $request->query('service');
        $pets = $request->query('pets');
        $frequency = $request->query('frequency');
        $selectedDate = $request->query('selecteddate');
        $area = $request->query('area');
        $addons = $request->query('addons', []); 


        $cleaner = Cleaner::with(['bed_area_sqfts', 'bath_area_sqfts', 'service'])
        ->findOrFail($cleanerId);

        // Get bed price
        $bedPriceModel = $cleaner->bed_area_sqfts
            ->where('beds', $beds)
            ->where('no_of_sqft', $area)
            ->first();
        $bedPrice = $bedPriceModel->price ?? 0;
        $area_sqft = $bedPriceModel->no_of_sqft ?? 'N/A';

        // Get bath price
        $bathPriceModel = $cleaner->bath_area_sqfts
            ->where('baths', $baths)
            ->first();
        $bathPrice = $bathPriceModel->price ?? 0;

        // Get service price
        $servicePriceModel = $cleaner->service
            ->where('service_name', $service)
            ->first();
        $servicePrice = $servicePriceModel->price ?? 0;

        $selectedAddons = Addon::whereIn('id', $addons)->get();

        // Optional: Calculate addon total
        $addonTotal = $selectedAddons->sum('price');

        // Optional pet fee
        $petCharge = ($pets === 'yes_pets') ? 10 : 0;

        // Total price
        $totalPrice = $bedPrice + $bathPrice + $servicePrice + $addonTotal;

        $discounts = [
            'one_time' => 0,
            'weekly' => 0.20,
            'biweekly' => 0.15,
            'monthly' => 0.10,
        ];

        $discountedPrices = [];
        foreach ($discounts as $key => $discount) {
            $discountedPrices[$key] = $totalPrice - ($totalPrice * $discount);
        }

        $discountAmounts = [];
        foreach ($discounts as $key => $discountRate) {
            $discountAmounts[$key] = $totalPrice * $discountRate;
        }


        // Make sure to pass base price too
        $oneTimePrice = $totalPrice;

        return view('frontend.quote-checkout', compact(
            'cleaner',
            'slot',
            'selectedDate',
            'beds',
            'bedPriceModel',
            'bathPriceModel',
            'servicePriceModel',
            'baths',
            'area_sqft',
            'service',
            'pets',
            'bedPrice',
            'bathPrice',
            'servicePrice',
            'totalPrice',
            'oneTimePrice',
            'discountedPrices',
            'discountAmounts',
            'frequency',
            'selectedAddons'
        ));
        
            
        }
    
 

}
