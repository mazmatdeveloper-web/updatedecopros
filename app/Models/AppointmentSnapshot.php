<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentSnapshot extends Model
{
    protected $fillable = [
        'appointment_id',
        'appointment_date',
        'cleaner_id',
        'customer_id',
        'start_time',
        'end_time',
        'addons',
        'service_name',
        'service_price'
    ];
}
