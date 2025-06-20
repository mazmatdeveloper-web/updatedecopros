<?php

namespace App\Http\Controllers;

use App\Models\AppointmentSnapshot;
use App\Models\Appointment;
use App\Models\Addon;
use App\Mail\AppointmentBookedMail;
use App\Mail\CleanerBookingMail;
use App\Mail\AdminBookingMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

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

        // Create appointment
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
}
