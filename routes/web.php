<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\CleanerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\FiltersController;
use App\Http\Controllers\CustomerController;

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

Route::get('/availability/create', [AvailabilityController::class, 'create'])->name('availability.create');
Route::post('/availability/store', [AvailabilityController::class, 'store'])->name('availability.store');

Route::get('/cleaners/{cleaner}', [CleanerController::class, 'show'])->name('cleaners.show');

Route::post('/book-appointment', [CleanerController::class, 'bookAppointment'])->name('book.appointment');

Route::get('add-cleaner',[CleanerController::class,'add_cleaner'])->name('add.cleaner');
Route::post('insert-cleaner', [CleanerController::class, 'insert_cleaner'])->name('insert.cleaner');
Route::get('add-cleaner-availability',[CleanerController::class,'add_cleaner_availability'])->name('add.cleaner.availability');
Route::get('add-zipcode',[AdminController::class,'zipcode'])->name('add.zipcode');
Route::post('insert-zipcode',[AdminController::class,'insert_zipcode'])->name('insert.zipcode');
Route::get('delete-zipcode/{id}',[AdminController::class,'delete_zipcode'])->name('delete.zipcode');
Route::get('edit-zipcode/{id}',[AdminController::class,'edit_zipcode'])->name('edit.zipcode');
Route::post('update-zipcode/{id}', [AdminController::class, 'update_zipcode'])->name('update.zipcode');
Route::get('services',[AdminController::class,'show_service'])->name('all.services');

Route::get('cleaners',[CleanerController::class,'show_cleaners'])->name('all.cleaners');

Route::get('quote', [QuoteController::class, 'quote_page'])->name('quote');
Route::post('check-zipcode', [QuoteController::class, 'quote'])->name('check.zipcode');

Route::get('quote-extended', [QuoteController::class, 'quote_extended'])->name('quote.extended');
Route::post('calculate-prices', [QuoteController::class, 'calculatePrices'])->name('calculate.prices');
Route::get('checkout', [QuoteController::class, 'quote_checkout'])->name('quote.checkout');



// Bed Routes
Route::get('beds',[FiltersController::class,'show_beds'])->name('all.beds');
Route::post('insert-bed-options',[FiltersController::class,'insert_bed_options'])->name('insert.bed.options');
Route::post('insert-bath-options',[FiltersController::class,'insert_bath_options'])->name('insert.bath.options');
Route::post('insert-bed-area-sqft-options',[FiltersController::class,'insert_bed_area_sqft_options'])->name('insert.bed.areasqft.options');
Route::post('insert-bath-area-sqft-options',[FiltersController::class,'insert_bath_area_sqft_options'])->name('insert.bath.areasqft.options');
Route::post('insert-service',[FiltersController::class,'insert_service'])->name('insert.service');

// Cleaner Profile
Route::get('cleaners/{id}/profile', [CleanerController::class, 'cleanerProfile'])->name('cleaners.profile');
Route::get('cleaners/delete/{id}', [CleanerController::class, 'delete_cleaner'])->name('cleaners.delete');
Route::get('cleaners/edit/{id}', [CleanerController::class, 'edit_cleaner'])->name('cleaners.edit');
Route::post('cleaners/update', [CleanerController::class, 'update_cleaner'])->name('cleaners.update');

// addons

Route::get('addons',[AdminController::class,'add_on'])->name('addons');
Route::post('insert-addon',[AdminController::class,'insert_addon'])->name('insert.addon');
Route::get('delete-addon/{id}',[AdminController::class,'delete_addon'])->name('delete.addon');
Route::get('edit-addon/{id}',[AdminController::class,'edit_addon'])->name('edit.addon');
Route::post('update-addon/{id}', [AdminController::class, 'update_addon'])->name('update.addon');

Route::post('/manual-login', [CustomerController::class, 'manual_login'])->name('manual.login');

