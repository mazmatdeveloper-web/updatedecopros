<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\CleanerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\FiltersController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AppointmentController;

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

// Beds Sqft

Route::get('edit-beds/{id}',[CleanerController::class,'edit_beds'])->name('edit.beds');
Route::post('/update-beds/{id}', [CleanerController::class, 'updateBeds'])->name('update.beds');
Route::delete('/delete_beds/{id}',[CleanerController::class,'delete_beds'])->name('delete.beds');


// Bathroom Sqft

Route::get('edit-bathroom/{id}',[CleanerController::class,'edit_bathroom'])->name('edit.bathroom');
Route::post('/update-baths/{id}', [CleanerController::class, 'updatebaths'])->name('update.bathroom');
Route::delete('delete_baths/{id}',[CleanerController::class,'delete_baths'])->name('delete.baths');

// Services
Route::get('edit-service/{id}',[CleanerController::class,'edit_service'])->name('edit.service');
Route::post('/update-services/{id}', [CleanerController::class, 'update_service'])->name('update.services');
Route::delete('delete-services/{id}',[CleanerController::class,'delete_service'])->name('delete.service');

// Cleaner Availible Dates
Route::get('edit-availible-date/{id}',[CleanerController::class,'edit_cleaner_availible_dates'])->name('edit.availible.dates');
Route::post('/update-availible/date/{id}', [CleanerController::class, 'updateAvailability'])->name('update.availinle.date');

Route::get('quote', [QuoteController::class, 'quote_page'])->name('quote');
Route::post('check-zipcode', [QuoteController::class, 'quote'])->name('check.zipcode');

Route::get('quote-extended', [QuoteController::class, 'quote_extended'])->name('quote.extended');
Route::post('calculate-prices', [QuoteController::class, 'calculatePrices'])->name('calculate.prices');
Route::post('check-cleaner-service',[CleanerController::class, 'check_service'])->name('check.cleaner.service');
Route::get('checkout', [QuoteController::class, 'quote_checkout'])->name('quote.checkout');
Route::get('thank-you',[AppointmentController::class,'thank_you'])->name('quote.thankyou');


// Bed Routes
Route::get('beds',[FiltersController::class,'show_beds'])->name('all.beds');
Route::post('insert-bed-options',[FiltersController::class,'insert_bed_options'])->name('insert.bed.options');
Route::post('insert-bath-options',[FiltersController::class,'insert_bath_options'])->name('insert.bath.options');
Route::post('insert-bed-area-sqft-options',[FiltersController::class,'insert_bed_area_sqft_options'])->name('insert.bed.areasqft.options');
Route::post('insert-bath-area-sqft-options',[FiltersController::class,'insert_bath_area_sqft_options'])->name('insert.bath.areasqft.options');
Route::post('insert-service',[FiltersController::class,'insert_service'])->name('insert.service');

// Update Bedroom Sqft Option
Route::post('/bed-area-sqft/update/{id}', [FiltersController::class, 'update_bed_area_sqft_options'])->name('update.bed.areasqft.options');
Route::delete('/bed-area-sqft/delete/{id}', [FiltersController::class, 'delete_bedrooms'])->name('delete.bed.areasqft.options');
Route::post('/bathroom-price/update/{id}', [FiltersController::class, 'update_bathroom_price'])->name('update.bathroom.price');
Route::post('/services/update/{id}', [FiltersController::class, 'update_service'])->name('update.service');
Route::delete('/service/delete/{id}', [FiltersController::class, 'delete_service'])->name('delete.service');


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

Route::get('appointments',[AdminController::class,'all_appointments'])->name('appointments');


Route::post('/manual-login', [CustomerController::class, 'manual_login'])->name('manual.login');
Route::post('/manual-register', [CustomerController::class, 'manual_register'])->name('manual.register');
Route::post('book-appointment',[AppointmentController::class, 'book_appointment'])->name('book.appointment');

// Timeslots Routes

Route::post('/recurring-availability/update', [AvailabilityController::class, 'recurring_availability_update'])->name('recurring-availability.update');

Route::middleware(['auth', 'customer'])->prefix('customer')->group(function () {
    Route::get('dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');
    Route::get('my-appointments', [CustomerController::class, 'my_appointments'])->name('customer.myappointments');
});

Route::get('updated',function(){
    return view('frontend.updated');
});