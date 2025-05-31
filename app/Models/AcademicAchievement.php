<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicAchievement extends Model
{
    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo(Room::class, 'rooms_id', 'id');
    }

    public function period()
    {
        return $this->belongsTo(AcademicPeriod::class, 'academic_periods_id', 'id');
    }
}
