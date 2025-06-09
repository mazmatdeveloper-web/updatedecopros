<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable =[
        'cleaner_id',
        'customer_id',
        'appointment_date',
        'start_time',
        'end_time',
        'beds_area_sqft_id',
        'baths_area_sqft_id',
        'service_id',
        'addon_ids',
        'discount_label',
        'discount_price',
        'total_price',
        'status',
        'address',
        'additional_notes'
        ];
    public function cleaner()
    {
        return $this->belongsTo(Cleaner::class);
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
