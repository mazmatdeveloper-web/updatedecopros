<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Models\Zipcode;
use App\Models\Addon;
use App\Models\Cleaner;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Service;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $totalCleaner  = Cleaner::count();
        $Totalappointments = Appointment::count();
        $totalRevenue  = Appointment::sum('total_price');
        $pendingCount = Appointment::where('status', 'pending')->count();
        $toalcustomer = User::where('role', 'customer')->count();
         $appointments = Appointment::where('created_at', '>=', now()->subDays(7))
        ->orderByDesc('appointment_date')
        ->get();

        return view('admin.dashboard.index' , compact('totalCleaner','Totalappointments','totalRevenue','pendingCount','toalcustomer','appointments'));
    }

    public function zipcode()
    {
        $zipcodes = Zipcode::latest()->get();
        return view('admin.zipcode.add-zipcode',compact('zipcodes'));
    }

    public function insert_zipcode(Request $request)
    {
        $request->validate([
            'codes' => 'required|unique:zipcodes,codes|regex:/^\d{5}$/'
        ]);

        Zipcode::create([
            'codes' => $request->codes
        ]);

        Alert::toast('Zipcode Added Successfully!', 'success')
        ->position('top-end')
        ->timerProgressBar()
        ->autoClose(500000);
        return redirect()->back();
    }

    public function delete_zipcode($id)
    {
        $zipcode = Zipcode::findOrFail($id);
        $zipcode->delete();

        Alert::toast('Zipcode Deleted Successfully!', 'success')
        ->position('top-end')
        ->timerProgressBar()
        ->autoClose(5000);
        return redirect()->back();
    }

    public function edit_zipcode($id)
    {
        $zipcode = Zipcode::findOrFail($id);
        return view('admin.zipcode.add-zipcode', compact('zipcode'));
    }

    public function update_zipcode(Request $request, $id)
    {
        $request->validate([
            'codes' => 'required|unique:zipcodes,codes,'.$id.'|regex:/^\d{5}$/'
        ]);

        $zipcode = Zipcode::findOrFail($id);
        $zipcode->update([
            'codes' => $request->codes
        ]);

        Alert::toast('Zipcode Updated Successfully!', 'success')
        ->position('top-end')
        ->timerProgressBar()
        ->autoClose(5000);
        return redirect()->route('add.zipcode');
    }

    public function show_service()
    {
        $services = Service::latest()->get();
        return view('admin.services.all-services',compact('services'));
    }

    public function insert_service(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable',
        ]);

        Service::create([
            'service_name' => $request->service_name,
            'price' => $request->price,
            'description' => $request->description
        ]);

        Alert::toast('Service Added Successfully!', 'success')
        ->position('top-end')
        ->timerProgressBar()
        ->autoClose(500000);
        return redirect()->back();
    }

    public function add_on()
    {
        $addons = Addon::all();
        return view('admin.addons.index', compact('addons'));
    }

    public function insert_addon(Request $request)
    {
        $request->validate([
            'addon_name' => 'required|unique:addons|string|max:255',
            'price' => 'required|numeric',
        ]);

        Addon::create([
            'addon_name' => $request->addon_name,
            'price' => $request->price,
        ]);

        Alert::toast('Addon Added Successfully!', 'success')
        ->position('top-end')
        ->timerProgressBar()
        ->autoClose(3000);
        return redirect()->back();   
    }

    public function edit_addon($id)
    {
        $addon = Addon::findOrFail($id);
        return view('admin.addons.index', compact('addon'));
    }

    public function update_addon(Request $request, $id)
    {
        $request->validate([
            'addon_name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $addon = Addon::findOrFail($id);
        $addon->update([
            'addon_name' => $request->addon_name,
            'price' => $request->price,
        ]);

        Alert::toast('Addon Updated Successfully!', 'success')
        ->position('top-end')
        ->timerProgressBar()
        ->autoClose(3000);
        return redirect()->route('addons');
    }

    public function delete_addon($id)
    {
        $addon = Addon::findOrFail($id);
        $addon->delete();

        Alert::toast('Addon Deleted Successfully!', 'success')
        ->position('top-end')
        ->timerProgressBar()
        ->autoClose(3000);
        return redirect()->back();
    }

    public function all_appointments(Request $request)
    {
        $query = Appointment::with(['service', 'cleaner']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
    
            $query->whereHas('service', function($q) use ($search) {
                $q->where('service_name', 'like', "%$search%");
            })->orWhereHas('cleaner', function($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })->orWhere('status', 'like', "%$search%")
              ->orWhereDate('appointment_date', $search);
        }
    
        $appointments = $query->orderBy('appointment_date', 'desc')->paginate(2);
    
        return view('admin.appointments.index', compact('appointments'));
    }
    
}
