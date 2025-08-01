<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Learning extends Model
{
    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function academicPeriod()
    {
        return $this->belongsTo(AcademicPeriod::class, 'academic_period_id', 'id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'learning_id', 'id');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    // app/Models/Learning.php
    public function learningObjectives()
    {
        return $this->hasMany(LearningObjective::class);
    }
}
