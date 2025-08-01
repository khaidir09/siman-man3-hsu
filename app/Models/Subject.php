<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $guarded = [];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function reportCardDetails()
    {
        return $this->hasMany(ReportCardDetail::class);
    }

    public function learningObjectives()
    {
        return $this->hasMany(LearningObjective::class);
    }
}
