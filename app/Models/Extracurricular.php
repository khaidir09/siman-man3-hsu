<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
    protected $guarded = [];

    public function pembina()
    {
        return $this->belongsTo(User::class, 'pembina_id', 'id');
    }

    public function academicPeriod()
    {
        return $this->belongsTo(AcademicPeriod::class, 'tahun_ajaran_id', 'id');
    }

    public function extracurricularStudents()
    {
        return $this->hasMany(ExtracurricularStudent::class, 'extracurricular_id', 'id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'extracurricular_students', 'extracurricular_id', 'student_id');
    }

    public function achievements()
    {
        return $this->hasMany(ExtracurricularAchievement::class, 'extracurricular_id', 'id');
    }
}
