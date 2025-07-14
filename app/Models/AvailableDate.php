<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableDate extends Model
{
    protected $fillable =[
        'employee_id',
        'dates'
    ];
    public function cleaner()
    {
        return $this->belongsTo(Employee::class);
    }

    public function timeSlots()
    {
        return $this->hasMany(AvailableTimeSlot::class,'available_date_id');
    }
}
