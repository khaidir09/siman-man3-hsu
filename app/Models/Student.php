<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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

    public function lateArrival()
    {
        return $this->hasMany(LateArrival::class, 'student_id', 'id');
    }

    public function counseling()
    {
        return $this->hasMany(CounselingGuidance::class, 'student_id', 'id');
    }
}
