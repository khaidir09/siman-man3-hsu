<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSchedule extends Model
{
    protected $guarded = [];

    public function startTimeSlot()
    {
        return $this->belongsTo(TimeSlot::class, 'time_slot_id_mulai');
    }

    /**
     * Relasi ke slot waktu selesai.
     */
    public function endTimeSlot()
    {
        return $this->belongsTo(TimeSlot::class, 'time_slot_id_selesai');
    }

    /**
     * Relasi ke tahun ajaran.
     */
    public function academicPeriod()
    {
        return $this->belongsTo(AcademicPeriod::class, 'academic_period_id');
    }
}
