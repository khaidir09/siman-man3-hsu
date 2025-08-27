<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $guarded = [];

    public function room()
    {
        return $this->hasMany(Room::class, 'majors_id', 'id');
    }
}
