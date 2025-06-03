<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaSqft extends Model
{
    protected $fillable = [
        'cleaner_id',
        'no_of_sqft',
        'price',
        'bed',
        'bath'
    ];

    public function cleaner()
    {
        return $this->belongsTo(Cleaner::class);
    }
}
