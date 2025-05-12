<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableTimeSlot extends Model
{
    protected $fillable = [
        'available_date_id',
        'start_time',
        'end_time',
        'interval',
        'is_booked',
    ];
    
    public function availableDate()
{
    return $this->belongsTo(AvailableDate::class);
}
}
