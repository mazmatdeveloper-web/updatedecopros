<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Models\Zipcode;
use App\Models\Addon;
use App\Models\Service;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.dashboard.index');
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
            'addon_name' => 'required|string|max:255',
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
    
}
