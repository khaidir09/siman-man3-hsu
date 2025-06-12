<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtracurricularAchievement extends Model
{
    protected $guarded = [];

    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class, 'extracurricular_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
