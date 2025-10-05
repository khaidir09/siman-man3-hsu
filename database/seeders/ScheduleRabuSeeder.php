<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ScheduleRabuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Jadwal hari Rabu untuk room_id 1
        DB::table('schedules')->insert([
            [
                'learning_id' => 10,
                'time_slot_id' => 2,
                'hari' => 'Rabu',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 10,
                'time_slot_id' => 3,
                'hari' => 'Rabu',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 10,
                'time_slot_id' => 4,
                'hari' => 'Rabu',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 11,
                'time_slot_id' => 5,
                'hari' => 'Rabu',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 11,
                'time_slot_id' => 6,
                'hari' => 'Rabu',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 11,
                'time_slot_id' => 7,
                'hari' => 'Rabu',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 12,
                'time_slot_id' => 8,
                'hari' => 'Rabu',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 12,
                'time_slot_id' => 9,
                'hari' => 'Rabu',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 14,
                'time_slot_id' => 10,
                'hari' => 'Rabu',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 14,
                'time_slot_id' => 11,
                'hari' => 'Rabu',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 15,
                'time_slot_id' => 12,
                'hari' => 'Rabu',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 15,
                'time_slot_id' => 13,
                'hari' => 'Rabu',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
