<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\CleanerController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');

Route::get('/availability/create', [AvailabilityController::class, 'create'])->name('availability.create');
Route::post('/availability/store', [AvailabilityController::class, 'store'])->name('availability.store');

Route::get('/cleaners/{cleaner}', [CleanerController::class, 'show'])->name('cleaners.show');

Route::post('/book-appointment', [CleanerController::class, 'bookAppointment'])->name('book.appointment');

Route::get('add-cleaner',[CleanerController::class,'add_cleaner'])->name('add.cleaner');
Route::post('insert-cleaner', [CleanerController::class, 'insert_cleaner'])->name('insert.cleaner');
Route::get('add-cleaner-availability',[CleanerController::class,'add_cleaner_availability'])->name('add.cleaner.availability');