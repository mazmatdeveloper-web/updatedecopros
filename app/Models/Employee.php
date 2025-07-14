<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'email',
        'user_id',
        'phone',
        'profile_picture',
        'bio',
    ];
    
    public function todayAvailability()
    {
        return $this->hasOne(AvailableDate::class)
            ->where('dates', now()->toDateString());
    }
    
    public function availableDates()
    {
        return $this->hasMany(AvailableDate::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function recurringAvailabilities()
    {
        return $this->hasMany(RecurringAvailability::class);
    }
    public function timeSlots()
    {
        return $this->hasMany(AvailableTimeSlot::class);
    }
    
    public function services()
    {
        return $this->belongsToMany(Service::class, 'employee_service');
    }
}
