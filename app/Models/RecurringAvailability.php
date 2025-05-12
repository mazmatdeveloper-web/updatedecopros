<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecurringAvailability extends Model
{
    protected $fillable = ['cleaner_id', 'day_of_week', 'start_time', 'end_time','interval'];

    public function cleaner()
    {
        return $this->belongsTo(Cleaner::class);
    }
}
