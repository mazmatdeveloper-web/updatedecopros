<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\AvailableDate;
use App\Models\RecurringAvailability;
use App\Models\AvailableTimeSlot;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function create()
    {
        $employees = Employee::all();
        return view('create', compact('employees'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'employee_id' => 'required|exists:Employees,id',
                
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

            $EmployeeId = $request->employee_id;

            // Save recurring slots
            if ($request->filled('recurring')) {
                foreach ($request->recurring as $rule) {
                    if (!empty($rule['day']) && !empty($rule['start_time']) && !empty($rule['end_time'])) {
                        RecurringAvailability::create([
                            'employee_id' => $EmployeeId,
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
                            'employee_id' => $EmployeeId,
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

    public function recurring_availability_update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:recurring_availabilities,id',
            'start_time' => 'required',
            'end_time' => 'required',
            'interval' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        RecurringAvailability::where('id', $request->id)->update([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'interval' => $request->interval,
            'is_active' => $request->is_active,
        ]);

        return back()->with('success', 'Availability updated successfully.');
    }
}
