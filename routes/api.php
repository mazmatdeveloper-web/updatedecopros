<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\APIController;

Route::get('/cleaners', [APIController::class, 'index']);
// Route::get('/api/test', function() {
//     return response()->json(['status' => 'working']);
// });