<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cleaner;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class CleanerController extends Controller
{
    public function show(Cleaner $cleaner)
    {
        // Load both specific date availability and recurring availability
        $cleaner->load([
            'availableDates.timeSlots',
            'recurringAvailabilities'
        ]);
    
        // Step 1: Build a map of specific date slots and intervals
        $availableSlotData = [];
        foreach ($cleaner->availableDates as $date) {
            foreach ($date->timeSlots as $slot) {
                // For each time slot, append the interval if available
                $slot->hourly_segments = $this->generateHourlySlots($slot->start_time, $slot->end_time, $slot->interval);
            }
            // Store the interval as well for each date
            $availableSlotData[$date->dates] = [
                'time_slots' => $date->timeSlots,
                'interval' => $date->interval ?? 60, // Default to 60 minutes if interval is not set
            ];
        }
    
        // Step 2: Appointments for this cleaner
        $appointments = Appointment::where('cleaner_id', $cleaner->id)
            ->get()
            ->map(function ($appointment) {
                return [
                    'date' => $appointment->appointment_date,
                    'start_time' => date('H:i:s', strtotime($appointment->start_time)),
                    'end_time' => date('H:i:s', strtotime($appointment->end_time)),
                ];
            });
    
        // Step 3: Prepare recurring availability grouped by weekday
        $recurringByDay = $cleaner->recurringAvailabilities->groupBy('day_of_week');
    
        return view('cleaners.show', compact('cleaner', 'appointments', 'recurringByDay', 'availableSlotData'));
    }

    private function generateHourlySlots($startTime, $endTime, $intervalMinutes)
    {
        $start = Carbon::parse($startTime);
        $end = Carbon::parse($endTime);
        $interval = $intervalMinutes ?: 60; // Default to 60 minutes if no interval is provided
        $slots = [];

        while ($start->copy()->addMinutes($interval) <= $end) {
            $slots[] = [
                'start_time' => $start->format('H:i'),
                'end_time' => $start->copy()->addMinutes($interval)->format('H:i'),
            ];
            $start->addMinutes($interval);
        }

        return $slots;
    }

    public function bookAppointment(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'cleaner_id' => 'required|exists:cleaners,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        // Create the appointment if validation passes
        $appointment = Appointment::create([
            'cleaner_id' => $validated['cleaner_id'],
            'appointment_date' => $validated['appointment_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ]);

        // Redirect or show a success message
        return redirect()->back()->with('success', 'Appointment booked successfully!');
    }


    /* Admin Controllers */

    public function show_cleaners(Request $request)
    {
        $cleaners = Cleaner::all();
        return view('admin.cleaners.all-cleaners', compact('cleaners'));
    }

    public function add_cleaner()
    {
        return view('admin.cleaners.add-cleaner');
    }

    public function add_cleaner_availability()
    {
        $cleaners = Cleaner::all();
        return view('admin.cleaners.add-availability', compact('cleaners'));
    }

    public function insert_cleaner(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'nullable',
            'bio' => 'nullable',
            'price' => 'required|numeric',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'cleaner',
        ]);
    
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('cleaners', 'public');
        }

        Cleaner::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'bio' => $request->bio,
            'price' => $request->price,
            'profile_picture' => $profilePicturePath,
        ]);
    
        Alert::toast('Cleaner Added Successfully!', 'success')
        ->position('top-end')
        ->timerProgressBar()
        ->autoClose(500000);
        return redirect()->back()->withErrors($validator)->withInput();;
    }


    // cleaner profile

    public function cleanerProfile($id)
    {
        $cleaner = Cleaner::with(['bath_area_sqfts','bed_area_sqfts','service'])->findOrFail($id);
        return view('admin.cleaners.single_cleaner.profile', compact('cleaner'));
    }
}
