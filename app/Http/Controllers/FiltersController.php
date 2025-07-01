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
            'no_of_sqft' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'beds' => 'required|numeric|min:1',
            
        ]);
    
        BedAreaSqft::create([
            'cleaner_id' => $request->cleaner_id,
            'no_of_sqft' => $request->no_of_sqft,
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
            'noofbathroom'=> 'required|numeric',
            'price' => 'required|numeric|min:0',
        ]);
    
        $exists = BathAreaSqft::where('cleaner_id', $request->cleaner_id)
                                ->where('baths', $request->noofbathroom)
                                ->exists();
    
        if ($exists) {
            Alert::toast('Bathroom price already set for this cleaner!', 'error')
                ->position('top-end')
                ->timerProgressBar()
                ->autoClose(5000);
            return redirect()->back();
        }
    
        BathAreaSqft::create([
            'cleaner_id' => $request->cleaner_id,
            'price' => $request->price,
            'baths' => $request->noofbathroom,   
        ]);
    
        Alert::toast('Bathroom Added Successfully!', 'success')
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

    // update functions for filters

    public function update_bed_area_sqft_options(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:beds_area_sqfts,id',
            'edit_no_of_sqft' => 'required',
            'beds' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $bedroom = BedAreaSqft::findOrFail($request->id);
        $bedroom->update([
            'no_of_sqft' => $request->edit_no_of_sqft,
            'beds' => $request->beds,
            'price' => $request->price,
        ]);

        Alert::toast('Bedroom Price Updated!', 'success')->autoClose(5000);
        return redirect()->back();
    }

    public function delete_bedrooms($id)
    {
        $bedroom = BedAreaSqft::findOrFail($id);
        $bedroom->delete();

        Alert::toast('Bedroom pricing deleted successfully!', 'success')
            ->position('top-end')
            ->timerProgressBar()
            ->autoClose(3000);

        return redirect()->back();
    }

    public function update_bathroom_price(Request $request, $id)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        $bathroom = BathAreaSqft::findOrFail($id);
        $bathroom->update([
            'price' => $request->price,
        ]);

        Alert::toast('Bathroom price updated successfully!', 'success')
            ->position('top-end')
            ->timerProgressBar()
            ->autoClose(2000);

        return redirect()->back();
    }
    

    public function update_service(Request $request, $id)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $service = Service::findOrFail($id);
        $service->update([
            'service_name' => $request->service_name,
            'price' => $request->price,
        ]);

        Alert::toast('Service updated successfully!', 'success')
            ->position('top-end')
            ->timerProgressBar()
            ->autoClose(3000);

        return redirect()->back();
    }
    
    public function delete_service($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        Alert::toast('Service deleted successfully!', 'success')
            ->position('top-end')
            ->timerProgressBar()
            ->autoClose(3000);

        return redirect()->back();
    }

}
