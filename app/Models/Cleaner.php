<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cleaner extends Model
{
    protected $fillable = [
        'name',
        'email',
        'user_id',
        'phone',
        'profile_picture',
        'bio',
        'price'
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

    //filters relations   
    
    public function bed_area_sqfts()
    {
        return $this->hasMany(BedAreaSqft::class);
    }

    public function bath_area_sqfts()
    {
        return $this->hasMany(BathAreaSqft::class);
    }
    
    public function service()
    {
        return $this->hasMany(Service::class);
    }
}
