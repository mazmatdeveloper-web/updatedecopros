<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BedAreaSqft;
use App\Models\BathAreaSqft;
use App\Models\Service;
use App\Models\Cleaner;
use RealRashid\SweetAlert\Facades\Alert;


class FiltersController extends Controller
{
    public function show_beds()
    {
        $cleaners = Cleaner::all();
        $beds = Bed::with('cleaner')->get();
        return view('admin.filters.beds',compact(['cleaners','beds']));
    }

    public function insert_bed_area_sqft_options(Request $request)
    {
        $request->validate([
            'cleaner_id' => 'required|exists:cleaners,id',
            'from' => 'required|string|max:255',
            'to' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'beds' => 'required|numeric|min:1',
            
        ]);
    
        BedAreaSqft::create([
            'cleaner_id' => $request->cleaner_id,
            'no_of_sqft' => $request->from." - ".$request->to,
            'price' => $request->price,
            'beds' => $request->beds,
        ]);
        
        Alert::toast('Bedrooms Area Sqft Options Added Successfully!', 'success')
        ->position('top-end')
        ->timerProgressBar()
        ->autoClose(5000);
        return redirect()->back();
    }

    public function insert_bath_area_sqft_options(Request $request)
    {
        $request->validate([
            'cleaner_id' => 'required|exists:cleaners,id',
            'from' => 'required|string|max:255',
            'to' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'baths' => 'required|numeric|min:1',
            
        ]);
    
        BathAreaSqft::create([
            'cleaner_id' => $request->cleaner_id,
            'no_of_sqft' => $request->from." - ".$request->to,
            'price' => $request->price,
            'baths' => $request->baths,
        ]);
        
        Alert::toast('Bedrooms Area Sqft Options Added Successfully!', 'success')
        ->position('top-end')
        ->timerProgressBar()
        ->autoClose(5000);
        return redirect()->back();
    }

    public function insert_service(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable',
        ]);

        Service::create([
            'cleaner_id' => $request->cleaner_id,
            'service_name' => $request->service_name,
            'price' => $request->price,
        ]);

        Alert::toast('Service Added Successfully!', 'success')
        ->position('top-end')
        ->timerProgressBar()
        ->autoClose(500000);
        return redirect()->back();
    }
}
