<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable =[
        'service_name',
        'price',
        'description',
        'service_image'
    ];
    
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_service');
    }
}
