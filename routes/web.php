<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FiltersController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UpdatedController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\API\APIController;
use App\Http\Controllers\StripeController;

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

Route::get('/availability/create', [AvailabilityController::class, 'create'])->name('availability.create');
Route::post('/availability/store', [AvailabilityController::class, 'store'])->name('availability.store');

Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');

Route::post('/book-appointment', [EmployeeController::class, 'bookAppointment'])->name('book.appointment');

Route::get('add-employee',[EmployeeController::class,'add_employee'])->name('add.employee');
Route::post('insert-employee', [EmployeeController::class, 'insert_employee'])->name('insert.employee');
Route::get('add-employee-availability',[EmployeeController::class,'add_employee_availability'])->name('add.employee.availability');
Route::get('add-zipcode',[AdminController::class,'zipcode'])->name('add.zipcode');
Route::post('insert-zipcode',[AdminController::class,'insert_zipcode'])->name('insert.zipcode');
Route::get('delete-zipcode/{id}',[AdminController::class,'delete_zipcode'])->name('delete.zipcode');
Route::get('edit-zipcode/{id}',[AdminController::class,'edit_zipcode'])->name('edit.zipcode');
Route::post('update-zipcode/{id}', [AdminController::class, 'update_zipcode'])->name('update.zipcode');
Route::get('services',[AdminController::class,'show_service'])->name('all.services');

Route::get('employees',[EmployeeController::class,'show_employees'])->name('all.employees');

// Admin Employee Services
Route::get('edit-service/{id}',[EmployeeController::class,'edit_service'])->name('edit.service');
Route::post('/update-services/{id}', [EmployeeController::class, 'update_service'])->name('update.services');
Route::delete('employees/{employee}/services/{service}', [EmployeeController::class, 'delete_service'])
    ->name('employee.delete.service');
Route::post('employees/attach-services', [EmployeeController::class, 'attach_services'])->name('employee.attach.services');

// employee Availible Dates
Route::get('edit-availible-date/{id}',[EmployeeController::class,'edit_employee_availible_dates'])->name('edit.availible.dates');
Route::post('/update-availible/date/{id}', [EmployeeController::class, 'updateAvailability'])->name('update.availinle.date');

Route::get('quote', [QuoteController::class, 'quote_page'])->name('quote');

Route::get('booking', [BookingController::class, 'booking'])->name('booking');
Route::post('check-zipcode', [QuoteController::class, 'quote'])->name('check.zipcode');

// Route::post('quote-extended', [QuoteController::class, 'quote_extended'])->name('quote.extended');
Route::match(['get', 'post'], '/quote-extended', [QuoteController::class, 'quote_extended'])->name('quote.extended');
Route::post('calculate-prices', [QuoteController::class, 'calculatePrices'])->name('calculate.prices');
Route::post('check-employee-service',[EmployeeController::class, 'check_service'])->name('check.employee.service');
Route::get('checkout', [QuoteController::class, 'quote_checkout'])->name('quote.checkout');
Route::get('thank-you',[AppointmentController::class,'thank_you'])->name('quote.thankyou');


// Admin Service Module
Route::get('services',[AdminController::class,'all_services'])->name('all.services');
Route::post('insert-service',[AdminController::class,'insert_service'])->name('insert.service');
Route::delete('delete-service/{id}',[AdminController::class,'delete_service'])->name('delete.service');


// employee Profile
Route::get('employees/{id}/profile', [EmployeeController::class, 'employeeProfile'])->name('employees.profile');
Route::get('employees/delete/{id}', [EmployeeController::class, 'delete_employee'])->name('employees.delete');
Route::get('employees/edit/{id}', [EmployeeController::class, 'edit_employee'])->name('employees.edit');
Route::post('employees/update', [EmployeeController::class, 'update_employee'])->name('employees.update');

// addons

Route::get('addons',[AdminController::class,'add_on'])->name('addons');
Route::post('insert-addon',[AdminController::class,'insert_addon'])->name('insert.addon');
Route::get('delete-addon/{id}',[AdminController::class,'delete_addon'])->name('delete.addon');
Route::get('edit-addon/{id}',[AdminController::class,'edit_addon'])->name('edit.addon');
Route::post('update-addon/{id}', [AdminController::class, 'update_addon'])->name('update.addon');

Route::get('appointments',[AdminController::class,'all_appointments'])->name('appointments');
Route::get('/edit/appointment/{id}', [AppointmentController::class , 'edit_appointment'])->name('edit.appointment');
Route::get('/admin/employee-slots', [AppointmentController::class, 'getemployeeslots'])->name('admin.get.employee.slots');
Route::delete('/appointments/{id}', [AppointmentController::class, 'delete_appointment'])->name('delete.appointment');
Route::put('update/availability/{id}',[AppointmentController::class , 'updateAvailability'])->name('update.availability');

Route::post('/manual-login', [CustomerController::class, 'manual_login'])->name('manual.login');
Route::post('/manual-register', [CustomerController::class, 'manual_register'])->name('manual.register');
Route::post('book-appointment',[AppointmentController::class, 'book_appointment'])->name('book.appointment');

// Timeslots Routes

Route::post('/recurring-availability/update', [AvailabilityController::class, 'recurring_availability_update'])->name('recurring-availability.update');

// customer routes for admin

Route::get('customers',[AdminController::class,'show_customers'])->name('all.customers');
Route::get('edit/customer/{id}', [AdminController::class , 'edit_customer'])->name('admin.edit.customer');
Route::post('update/customer/{id}',[AdminController::class , 'update_customer'])->name('update.customer');
Route::get('customer/{id}',[AdminController::class , 'show_single_profile'])->name('customer.single');


Route::middleware(['auth', 'customer'])->prefix('customer')->group(function () {
    Route::get('dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');
    Route::get('my-appointments', [CustomerController::class, 'my_appointments'])->name('customer.myappointments');
    Route::get('/edit/appointment/{id}', [AppointmentController::class , 'edit_customer_appointment'])->name('edit.customer.appointment');
    Route::put('update/customer/appointment/{id}',[AppointmentController::class , 'update_customer_appointment'])->name('update.customer.appoinmtent');

});

Route::get('updated',function(){
    return view('frontend.updated');
});

Route::get('/payment', [StripeController::class, 'showForm']);
Route::post('/payment', [AppointmentController::class, 'book_appointment'])->name('book.appointment');



// updated frontend

Route::get('updated-booking',[UpdatedController::class, 'booking'])->name('updated.booking');
Route::post('updated-quote-extended', [UpdatedController::class, 'booking_extended'])->name('updated.booking.extended');
