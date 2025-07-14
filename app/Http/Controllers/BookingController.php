<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function booking()
    {
        $services = Service::all();
        return view('frontend.booking', compact('services'));
    }
}
