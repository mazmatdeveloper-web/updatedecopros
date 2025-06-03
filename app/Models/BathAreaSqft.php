<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BathAreaSqft extends Model
{
    protected $table = 'baths_area_sqfts';
    protected $fillable = [
        'cleaner_id',
        'no_of_sqft',
        'price',
        'baths',
    ];

    public function cleaner()
    {
        return $this->belongsTo(Cleaner::class);
    }
}
