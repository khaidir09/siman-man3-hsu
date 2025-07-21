<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LateArrival extends Model
{
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
