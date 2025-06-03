<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BedAreaSqft extends Model
{
    protected $table = 'beds_area_sqfts';
    protected $fillable = [
        'cleaner_id',
        'no_of_sqft',
        'price',
        'beds'
    ];

    public function cleaner()
    {
        return $this->belongsTo(Cleaner::class);
    }
}
