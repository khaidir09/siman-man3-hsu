<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $guarded = [];

    public function learning()
    {
        return $this->belongsTo(Learning::class);
    }

    public function scores()
    {
        return $this->hasMany(ExamScore::class);
    }
}
