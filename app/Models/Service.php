<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable =[
        'service_name',
        'price',
        'description',
        'cleaner_id'
    ];
    
    public function cleaner()
    {
        return $this->belongsTo(Cleaner::class);
    }
}
