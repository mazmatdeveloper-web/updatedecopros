<?php

namespace App\Http\Controllers;

use App\Models\Cleaner;

use Illuminate\Http\Request;

class APIController extends Controller
{

public function index()
{
    $cleaners = Cleaner::all();
        return response()->json($cleaners, 201);
}

}