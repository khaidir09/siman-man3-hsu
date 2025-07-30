<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = [];

    public function learning()
    {
        return $this->belongsTo(Learning::class);
    }
    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }
}
