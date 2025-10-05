<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ScheduleSeninSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Jadwal hari Senin untuk room_id 1
        DB::table('schedules')->insert([
            [
                'learning_id' => 5,
                'time_slot_id' => 3,
                'hari' => 'Senin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 5,
                'time_slot_id' => 4,
                'hari' => 'Senin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 5,
                'time_slot_id' => 5,
                'hari' => 'Senin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 9,
                'time_slot_id' => 6,
                'hari' => 'Senin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 9,
                'time_slot_id' => 7,
                'hari' => 'Senin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 13,
                'time_slot_id' => 8,
                'hari' => 'Senin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 13,
                'time_slot_id' => 9,
                'hari' => 'Senin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 1,
                'time_slot_id' => 10,
                'hari' => 'Senin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 1,
                'time_slot_id' => 11,
                'hari' => 'Senin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 2,
                'time_slot_id' => 12,
                'hari' => 'Senin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 2,
                'time_slot_id' => 13,
                'hari' => 'Senin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
