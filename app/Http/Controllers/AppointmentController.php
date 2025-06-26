<?php

namespace App\Http\Controllers;

use App\Models\AppointmentSnapshot;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Appointment;
use App\Models\Addon;
use App\Models\User;
use App\Models\AvailableDate;
use App\Models\RecurringAvailability;
use App\Models\Cleaner;
use App\Mail\AppointmentBookedMail;
use App\Mail\CleanerBookingMail;
use App\Mail\CleanerAppointmentUpdate;
use App\Mail\AdminBookingMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{

   

    public function book_appointment(Request $request)
    {

        $data = $request->validate([
            'cleaner_id' => 'required|exists:users,id',
            'customer_id' => 'required|exists:users,id',
            'start_time' => 'required',
            'end_time' => 'required',
            'appointment_date' => 'required',
            'beds_area_sqft_id' => 'nullable|exists:beds_area_sqfts,id',
            'no_of_baths' => 'nullable',
            'service_id' => 'nullable|exists:services,id',
            'discount_label' => 'nullable|string|max:255',
            'discount_price' => 'nullable|numeric',
            'total_price' => 'required|numeric',
            'addon_ids' => 'nullable|string',
            'address' => 'nullable|string',
            'additional_notes' => 'nullable|string'
        ]);

        $currentDate = Carbon::now()->format('Y-m-d');
    
        // Prevent duplicate appointments
        $existing = Appointment::where([
            'appointment_date' => $data['appointment_date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'cleaner_id' => $data['cleaner_id'],
            'customer_id' => $data['customer_id'],
        ])->first();

        if ($existing) {
            return view('frontend.thankyou', ['appointment' => $existing])
                ->with('message', 'Appointment already booked.');
        }
        
        $amountInCents = (int) round($data['total_price'] * 100);


        Stripe::setApiKey('sk_test_51Nlc9SKqDITcCiJxEId17iPPzMWCJcV74TAoHilSOE12fL5xCu09YzB6KEk4lnWS0HKJLEJgPm5pBj5amMSx1q9400MyRCAZeW');

        try {
            $charge = Charge::create([
                'amount' => $amountInCents,
                'currency' => 'usd',
                'description' => 'EcoProz Appointment Payment',
                'source' => $request->stripeToken,
            ]);
        } catch (\Exception $e) {
            Log::error('Stripe Payment Failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Payment failed: ' . $e->getMessage());
        }

        $appointment = Appointment::create([
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'appointment_date' => $data['appointment_date'],
            'cleaner_id' => $data['cleaner_id'],
            'customer_id' => $data['customer_id'],
            'beds_area_sqft_id' => $data['beds_area_sqft_id'],
            'no_of_baths' => $data['no_of_baths'],
            'service_id' => $data['service_id'] ?? 14,
            'discount_label' => $data['discount_label'],
            'discount_price' => $data['discount_price'] ?? 0,
            'total_price' => $data['total_price'],
            'addon_ids' => $data['addon_ids'],
            'status' => 'pending',
            'address' => $data['address'],
            'additional_notes' => $data['additional_notes']
        ]);

        $appointment->load(['cleaner', 'customer', 'service', 'bedsArea']);

        // Attach addons
        $addonIds = json_decode($appointment->addon_ids, true) ?? [];
        $addons = Addon::whereIn('id', $addonIds)->get();
        $appointment->addons = $addons;

        // Send emails only once
        Mail::to($appointment->customer->email)->send(new AppointmentBookedMail($appointment));
        Mail::to($appointment->cleaner->email)->send(new CleanerBookingMail($appointment));
        Mail::to('admin@example.com')->send(new AdminBookingMail($appointment));

        return view('frontend.thankyou', compact('appointment'));

    }

    public function getCleanerSlots(Request $request)
    {
        $request->validate([
            'cleaner_id' => 'required|exists:users,id',
            'date' => 'required|date'
        ]);
    
        $cleanerId = $request->cleaner_id;
        $date = Carbon::parse($request->date);
        $dayOfWeek = $date->format('l'); // e.g. 'Monday'
        $dateStr = $date->format('Y-m-d');
    
        // Get all appointments for that cleaner on the selected date
        $bookedAppointments = Appointment::where('cleaner_id', $cleanerId)
            ->where('appointment_date', $dateStr)
            ->get(['start_time', 'end_time']);
    
        $bookedSlots = [];
        foreach ($bookedAppointments as $appt) {
            $bookedSlots[] = [
                'start_time' => Carbon::parse($appt->start_time)->format('H:i'),
                'end_time' => Carbon::parse($appt->end_time)->format('H:i'),
            ];
        }
    
        // Helper function to check overlap
        function overlaps($slotStart, $slotEnd, $bookedSlots)
        {
            foreach ($bookedSlots as $booked) {
                if (
                    ($slotStart < $booked['end_time']) &&
                    ($slotEnd > $booked['start_time'])
                ) {
                    return true;
                }
            }
            return false;
        }
    
        $availableSlots = [];
    
        // 1. Try specific date availability
        $availableDate = AvailableDate::where('cleaner_id', $cleanerId)
            ->where('dates', $dateStr)
            ->where('is_disabled', 0)
            ->first();
    
        if ($availableDate && !empty($availableDate->slots)) {
            $slots = json_decode($availableDate->slots, true);
            foreach ($slots as $slot) {
                if (!overlaps($slot['start_time'], $slot['end_time'], $bookedSlots)) {
                    $availableSlots[] = $slot;
                }
            }
        } else {
            // 2. Fallback to recurring availability
            $recurring = RecurringAvailability::where('cleaner_id', $cleanerId)
                ->where('day_of_week', $dayOfWeek)
                ->where('is_active', 1)
                ->get();
    
            foreach ($recurring as $rec) {
                $start = Carbon::parse($rec->start_time);
                $end = Carbon::parse($rec->end_time);
                $interval = $rec->interval; // in minutes
    
                while ($start->copy()->addMinutes($interval) <= $end) {
                    $slotStart = $start->format('H:i');
                    $slotEnd = $start->copy()->addMinutes($interval)->format('H:i');
    
                    if (!overlaps($slotStart, $slotEnd, $bookedSlots)) {
                        $availableSlots[] = [
                            'start_time' => $slotStart,
                            'end_time' => $slotEnd,
                        ];
                    }
    
                    $start->addMinutes($interval);
                }
            }
        }
    
        return response()->json(['slots' => $availableSlots]);
    }

    public function edit_appointment($id)
    {
        $appointments = Appointment::findOrFail($id); 
        $cleanerIds = Cleaner::distinct()->pluck('id')->toArray();
        $cleaners = Cleaner::get();

        return view('admin.appointments.edit', compact('appointments', 'cleaners'));
    }


    public function updateAvailability(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'cleaner' => 'required|exists:cleaners,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required|string',
            'address' => 'required',
            'price' => 'nullable|numeric',
        ]);
    
        $appointment = Appointment::findOrFail($id);
    
        // Parse selected slot (e.g., "10:00 - 11:00")
        [$startTime, $endTime] = explode(' - ', $request->start_time);
    
        $appointment->status = $request->status;
        $appointment->cleaner_id = $request->cleaner;
        $appointment->address = $request->address;
        $appointment->appointment_date = $request->appointment_date;
        $appointment->start_time = Carbon::createFromFormat('H:i', trim($startTime))->format('H:i:s');
        $appointment->end_time = Carbon::createFromFormat('H:i', trim($endTime))->format('H:i:s');
        $appointment->total_price = $request->price;
    
        $appointment->save();

        Alert::toast('Appointment Updated successfully!', 'success')
                ->position('top-end')
                ->timerProgressBar()
                ->autoClose(5000);
        Mail::to($appointment->cleaner->email)->send(new CleanerAppointmentUpdate($appointment));

            return redirect()->back();
        
    }

    public function delete_appointment($id)
    {

    $appointment = Appointment::findOrFail($id);
    $appointment->delete();
    Alert::toast('Appointment Deleted successfully!', 'success')
                ->position('top-end')
                ->timerProgressBar()
                ->autoClose(5000);

            return redirect()->back();
    }

    public function edit_customer_appointment($id)
    {
        $appointments = Appointment::findOrFail($id); 
        $cleanerIds = Cleaner::distinct()->pluck('id')->toArray();
        $cleaners = Cleaner::get();

        return view('customer.appointments.edit', compact('appointments', 'cleaners'));   
    }
    public function update_customer_appointment(Request $request)
    {
        $request->validate([
            'cleaner' => 'required|exists:cleaners,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required|string',
        ]);
    
        $appointment = Appointment::findOrFail($request->appointment_id);
    
        // Parse selected slot (e.g., "10:00 - 11:00")
        [$startTime, $endTime] = explode(' - ', $request->start_time);
    
        $appointment->cleaner_id = $request->cleaner;
        $appointment->appointment_date = $request->appointment_date;
        $appointment->start_time = Carbon::createFromFormat('H:i', trim($startTime))->format('H:i:s');
        $appointment->end_time = Carbon::createFromFormat('H:i', trim($endTime))->format('H:i:s');
    
        $appointment->save();

        Alert::toast('Appointment Updated successfully!', 'success')
                ->position('top-end')
                ->timerProgressBar()
                ->autoClose(5000);

            return redirect()->back();
    }
}
