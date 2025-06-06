<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounselingGuidance extends Model
{
    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo(Room::class, 'rooms_id', 'id');
    }
}
