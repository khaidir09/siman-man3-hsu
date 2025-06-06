<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthCare extends Model
{
    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo(Room::class, 'rooms_id', 'id');
    }
}
