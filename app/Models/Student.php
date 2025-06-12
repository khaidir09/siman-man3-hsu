<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function extracurriculars()
    {
        return $this->belongsToMany(Extracurricular::class, 'extracurricular_student')
            ->withPivot('jabatan', 'nilai', 'tanggal_bergabung')
            ->withTimestamps();
    }

    public function achievements()
    {
        return $this->hasMany(ExtracurricularAchievement::class, 'student_id', 'id');
    }
}
