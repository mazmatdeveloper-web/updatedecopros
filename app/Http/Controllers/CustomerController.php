<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Appointment;
use App\Models\Addon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index(){
        return view('customer.dashboard.index');
    }
    
    public function my_appointments()
    {
        $appointments = Appointment::with(['service', 'cleaner'])
                        ->where('customer_id',auth()->user()->id)
                        ->get();
    
        $appointments->transform(function ($appointment) {
            return [
                'id' => $appointment->id,
                'service_name' => $appointment->service->service_name ?? 'N/A',
                'status' => $appointment->status,
                'cleaner_name' => $appointment->cleaner->name ?? 'N/A',
                'date' => Carbon::parse($appointment->appointment_date)->format('F j, Y'),
                'time' => Carbon::parse($appointment->start_time)->format('H:i') . ' - ' . Carbon::parse($appointment->end_time)->format('H:i'),
                'addons' => $this->getAddonNames($appointment->addon_ids),
                'discount_label' => $appointment->discount_label ?? '-',
                'discount_price' => number_format($appointment->discount_price, 2),
                'total_price' => number_format($appointment->total_price, 2),
                'booked_at' => $appointment->created_at->format('Y-m-d H:i'),
            ];
        });
    
        return view('customer.appointments.index', compact('appointments'));
    }
    
    private function getAddonNames($addonIds)
    {
        $ids = json_decode($addonIds, true);
    
        if (!is_array($ids) || empty($ids)) {
            return [];
        }
    
        return Addon::whereIn('id', $ids)->pluck('addon_name')->toArray();
    }
    

    public function manual_login(Request $request)
    {
       // Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Attempt login
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->back(); // Redirect to your desired route
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput();
    }

    public function manual_register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone' => 'required|string|max:255|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'customer'
        ]);

        // Automatically log in the user after registration
        Auth::login($user);

        // Redirect to intended page or dashboard
        return back();
    
    }
}
