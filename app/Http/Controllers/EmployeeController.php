<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Service;
use App\Models\BedAreaSqft;
use App\Models\BathAreaSqft;
use App\Models\AvailableDate;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;



class EmployeeController extends Controller
{
    public function show(Employee $employee)
    {
        $employee->load([
            'availableDates.timeSlots',
            'recurringAvailabilities'
        ]);
    
        $availableSlotData = [];
        foreach ($employee->availableDates as $date) {
            foreach ($date->timeSlots as $slot) {
                $slot->hourly_segments = $this->generateHourlySlots($slot->start_time, $slot->end_time, $slot->interval);
            }
           
            $availableSlotData[$date->dates] = [
                'time_slots' => $date->timeSlots,
                'interval' => $date->interval ?? 60, 
            ];
        }
    
        $appointments = Appointment::where('employee_id', $employee->id)
            ->get()
            ->map(function ($appointment) {
                return [
                    'date' => $appointment->appointment_date,
                    'start_time' => date('H:i:s', strtotime($appointment->start_time)),
                    'end_time' => date('H:i:s', strtotime($appointment->end_time)),
                ];
            });
    

        $recurringByDay = $employee->recurringAvailabilities->groupBy('day_of_week');
    
        return view('Employees.show', compact('Employee', 'appointments', 'recurringByDay', 'availableSlotData'));
    }

    private function generateHourlySlots($startTime, $endTime, $intervalMinutes)
    {
        $start = Carbon::parse($startTime);
        $end = Carbon::parse($endTime);
        $interval = $intervalMinutes ?: 60;
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
            'employee_id' => 'required|exists:Employees,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        // Create the appointment if validation passes
        $appointment = Appointment::create([
            'employee_id' => $validated['employee_id'],
            'appointment_date' => $validated['appointment_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ]);

        // Redirect or show a success message
        return redirect()->back()->with('success', 'Appointment booked successfully!');
    }


    /* Admin Controllers */

    public function show_employees(Request $request)
    {
        $employees = Employee::all();
        $services = Service::all();
        return view('admin.employees.all-employees', compact(['employees','services']));
    }

    public function add_Employee()
    {
        return view('admin.Employees.add-Employee');
    }

    public function add_Employee_availability()
    {
        $employees = Employee::all();
        return view('admin.employees.add-availability', compact('employees'));
    }

    public function insert_employee(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'nullable',
            'bio' => 'nullable',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'services' => 'required|array',
        ]);
    
        // Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'Employee',
        ]);
    
        // Handle profile picture
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('employees', 'public');
        }
    
        // Create Employee
        $employee = Employee::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'bio' => $request->bio,
            'profile_picture' => $profilePicturePath,
        ]);
    
        // Attach services (many-to-many)
        $employee->services()->attach($request->services); // ✅ attach selected services
    
        // Success alert
        Alert::toast('Employee Added Successfully!', 'success')
            ->position('top-end')
            ->timerProgressBar()
            ->autoClose(5000);
    
        return redirect()->back();
    }


    // Employee profile

    public function employeeProfile($id)
    {
        $employee = Employee::with(['services','availableDates.timeSlots','recurringAvailabilities'])->findOrFail($id);
        $services = Service::all();
        return view('admin.employees.single_employee.profile', compact(['employee','services']));
    }

    public function delete_Employee($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        
        Alert::toast('Employee Deleted Successfully!', 'success')
            ->position('top-end')
            ->timerProgressBar()
            ->autoClose(5000);
        
        return redirect()->back();
    }

    public function edit_Employee($id)
    {
        $employee = Employee::findOrFail($id);
        return view('admin.employees.single_employee.profile', compact('employee'));
    }

    public function update_employee(Request $request)
    {
        
        $request->validate([
            'employee_id' => 'required|exists:Employees,id',
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:employees,email,' . $request->employee_id,
            'phone'      => 'nullable|string',
            'bio'        => 'nullable|string',
            'password'   => 'nullable|string|min:6',
            'profile_picture' => 'nullable|image|max:2048', // 2MB max
        ]);
    
        $employee = Employee::findOrFail($request->employee_id);
        $employee->name  = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->bio   = $request->bio;
    
        if ($request->filled('password')) {
            $employee->password = Hash::make($request->password);
        }
    
        if ($request->hasFile('profile_picture')) {
            // Delete old image if exists
            if ($employee->profile_picture && Storage::exists('public/' . $employee->profile_picture)) {
                Storage::delete('public/' . $employee->profile_picture);
            }
    
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $employee->profile_picture = $path;
        }
    
        $employee->save();
        
        Alert::toast('Profile Updated Successfully!', 'success')
        ->position('top-end')
        ->timerProgressBar()
        ->autoClose(5000);

        return back();
    }

    public function edit_service($id)
    {
    
    $employee = Employee::with('services')->findOrFail($id);
    return view('admin.Employees.single_Employee.profile', compact('Employee'));

    }

    public function update_service(Request $request, $id)
    {
        // Validate the request data
        $validated = $request->validate([
            'service_name' => [
                'required',
                'string',
                Rule::unique('services', 'service_name')->ignore($id),
            ],
            'service_price' => 'required|numeric|min:0'
        ]);

        try {
            // Find the service record
            $service = Service::findOrFail($id);

            // Update the record
            $service->update([
                'service_name' => $validated['service_name'],
                'price' => $validated['service_price'],
            ]);

            // Success notification
            Alert::toast('Service updated successfully!', 'success')
                ->position('top-end')
                ->timerProgressBar()
                ->autoClose(5000);

            return redirect()->back()->with('success', 'Service updated successfully');

        } catch (\Exception $e) {
            Alert::toast('Error updating service!', 'error')
                ->position('top-end')
                ->timerProgressBar()
                ->autoClose(5000);

            return redirect()->back()->with('error', 'Error updating service');
        }
    }

    public function delete_service(Employee $employee, Service $service)
    {
        $employee->services()->detach($service->id);
        
        Alert::toast('Service Deleted Successfully!', 'success')
            ->position('top-end')
            ->timerProgressBar()
            ->autoClose(5000);
        
        return redirect()->back();
    }

    public function attach_services(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'services' => 'nullable|array',
            'services.*' => 'exists:services,id',
        ]);

        $employee = Employee::findOrFail($request->employee_id);
        $employee->services()->sync($request->services); // sync will replace existing with selected

        return back()->with('success', 'Services updated successfully.');
    }


    public function edit_Employee_availible_dates($id)
    {

    $employee = Employee::where('available_dates')->findOrFail(id);
    return view('admin.Employees.single_Employee.profile', compact('Employee'));

    }

    public function updateAvailability(Request $request, $id)
    {
        try {
            $request->validate([
                'availible_date' => 'required|date',
                'availible_start_time' => 'required',
                'availible_end_time' => 'required',
                'availible_interval' => 'required|integer',
                'is_disabled' => 'required|in:0,1'
            ]);

            $availableDate = AvailableDate::findOrFail($id);

            $availableDate->update([
                'dates' => $request->availible_date,
                'is_disabled' => $request->is_disabled,
            ]);

            $slot = $availableDate->timeSlots()->first();
            if ($slot) {
                $slot->update([
                    'start_time' => $request->availible_start_time,
                    'end_time' => $request->availible_end_time,
                    'interval' => $request->availible_interval, 

                ]);
            }

            Alert::toast('Availability updated successfully!', 'success')
                ->position('top-end')
                ->timerProgressBar()
                ->autoClose(5000);

            return redirect()->back();

        } catch (\Exception $e) {
            Alert::toast('Error updating availability!', 'error')
                ->position('top-end')
                ->timerProgressBar()
                ->autoClose(5000);

            return redirect()->back();
        }
    }

    public function check_service(Request $request)
    {
        $employeeId = $request->input('employee_id');
        $serviceType = $request->input('service_type');
        
        return response()->json(['exists' => true]);
    }

}
