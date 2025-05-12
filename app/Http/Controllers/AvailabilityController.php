<?php

namespace App\Http\Controllers;

use App\Models\Cleaner;
use App\Models\AvailableDate;
use App\Models\RecurringAvailability;
use App\Models\AvailableTimeSlot;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function create()
    {
        $cleaners = Cleaner::all();
        return view('create', compact('cleaners'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'cleaner_id' => 'required|exists:cleaners,id',
                
                'recurring' => 'nullable|array',
                'recurring.*.day' => 'nullable|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
                'recurring.*.start_time' => 'nullable|date_format:H:i',
                'recurring.*.end_time' => 'nullable|date_format:H:i|after:recurring.*.start_time',
                'recurring.*.interval' => 'nullable|integer|min:1',

                'specific' => 'nullable|array',
                'specific.*.date' => 'nullable|date',
                'specific.*.time_slots' => 'nullable|array',
                'specific.*.time_slots.*.start_time' => 'nullable|date_format:H:i',
                'specific.*.time_slots.*.end_time' => 'nullable|date_format:H:i|after:specific.*.time_slots.*.start_time',
                'specific.*.time_slots.*.interval' => 'nullable|integer|min:1',
            ]);

            $cleanerId = $request->cleaner_id;

            // Save recurring slots
            if ($request->filled('recurring')) {
                foreach ($request->recurring as $rule) {
                    if (!empty($rule['day']) && !empty($rule['start_time']) && !empty($rule['end_time'])) {
                        RecurringAvailability::create([
                            'cleaner_id' => $cleanerId,
                            'day_of_week' => $rule['day'],
                            'start_time' => $rule['start_time'],
                            'end_time' => $rule['end_time'],
                            'interval' => $rule['interval'] ?? 60,
                        ]);
                    }
                }
            }

            // Save specific slots
            if ($request->filled('specific')) {
                foreach ($request->specific as $dateEntry) {
                    if (!empty($dateEntry['date']) && !empty($dateEntry['time_slots'])) {
                        $availableDate = AvailableDate::firstOrCreate([
                            'cleaner_id' => $cleanerId,
                            'dates' => $dateEntry['date'],
                        ]);

                        foreach ($dateEntry['time_slots'] as $slot) {
                            if (!empty($slot['start_time']) && !empty($slot['end_time'])) {
                                $availableDate->timeSlots()->create([
                                    'start_time' => $slot['start_time'],
                                    'end_time' => $slot['end_time'],
                                    'interval' => $slot['interval'] ?? 60,
                                ]);
                            }
                        }
                    }
                }
            }

            return redirect()->route('availability.create')->with('success', 'Availability added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
