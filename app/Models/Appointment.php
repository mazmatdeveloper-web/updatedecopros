<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable =[
        'employee_id',
        'customer_id',
        'appointment_date',
        'start_time',
        'end_time',
        'beds_area_sqft_id',
        'no_of_baths',
        'service_id',
        'addon_ids',
        'discount_label',
        'discount_price',
        'total_price',
        'status',
        'address',
        'additional_notes',
        'reminder_sent'
        ];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function customer()
    {
        return $this->belongsTo(User::class);
    }
   
}
