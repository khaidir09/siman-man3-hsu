<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningObjective extends Model
{
    protected $guarded = [];

    public function learning()
    {
        return $this->belongsTo(Learning::class);
    }
}
