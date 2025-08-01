<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportCardDetail extends Model
{
    protected $guarded = [];

    public function learning()
    {
        return $this->belongsTo(Learning::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function reportCard()
    {
        return $this->belongsTo(ReportCard::class);
    }

    public function learningObjectives()
    {
        return $this->belongsToMany(
            LearningObjective::class,
            'detail_learning_objective' // Nama tabel pivot
        );
    }
}
