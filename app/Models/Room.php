<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = [];

    public function major()
    {
        return $this->belongsTo(Major::class, 'majors_id', 'id');
    }
}
