<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ScheduleKamisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Jadwal hari Kamis untuk room_id 1
        DB::table('schedules')->insert([
            [
                'learning_id' => 16,
                'time_slot_id' => 2,
                'hari' => 'Kamis',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 16,
                'time_slot_id' => 3,
                'hari' => 'Kamis',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 16,
                'time_slot_id' => 4,
                'hari' => 'Kamis',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 17,
                'time_slot_id' => 5,
                'hari' => 'Kamis',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 17,
                'time_slot_id' => 6,
                'hari' => 'Kamis',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 17,
                'time_slot_id' => 7,
                'hari' => 'Kamis',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 18,
                'time_slot_id' => 8,
                'hari' => 'Kamis',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 18,
                'time_slot_id' => 9,
                'hari' => 'Kamis',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 19,
                'time_slot_id' => 10,
                'hari' => 'Kamis',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 19,
                'time_slot_id' => 11,
                'hari' => 'Kamis',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 20,
                'time_slot_id' => 12,
                'hari' => 'Kamis',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 20,
                'time_slot_id' => 13,
                'hari' => 'Kamis',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
