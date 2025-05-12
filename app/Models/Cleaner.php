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
}
