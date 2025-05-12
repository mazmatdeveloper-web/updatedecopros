<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable =[
        'cleaner_id',
        'appointment_date',
        'start_time',
        'end_time'
    ];
    public function cleaner()
{
    return $this->belongsTo(Cleaner::class);
}
}
