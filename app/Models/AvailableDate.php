<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableDate extends Model
{
    protected $fillable =[
        'cleaner_id',
        'dates'
    ];
    public function cleaner()
{
    return $this->belongsTo(Cleaner::class);
}

public function timeSlots()
{
    return $this->hasMany(AvailableTimeSlot::class);
}
}
