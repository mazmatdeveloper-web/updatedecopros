<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Models\Zipcode;

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
    
}
