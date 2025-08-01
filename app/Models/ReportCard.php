<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportCard extends Model
{
    protected $guarded = ['id'];

    /**
     * Relasi: Satu rapor dimiliki oleh satu siswa.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relasi: Satu rapor dimiliki oleh satu kelas.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Relasi: Satu rapor dimiliki oleh satu periode ajaran.
     */
    public function academicPeriod()
    {
        return $this->belongsTo(AcademicPeriod::class);
    }

    /**
     * Relasi: Satu rapor divalidasi oleh satu wali kelas.
     */
    public function homeroomTeacher()
    {
        return $this->belongsTo(User::class, 'homeroom_teacher_id');
    }

    /**
     * Relasi: Satu rapor memiliki banyak detail nilai.
     */
    public function details()
    {
        return $this->hasMany(ReportCardDetail::class);
    }
}
