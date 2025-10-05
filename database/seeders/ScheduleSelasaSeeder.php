<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ScheduleSelasaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Jadwal hari Selasa untuk room_id 1
        DB::table('schedules')->insert([
            [
                'learning_id' => 3,
                'time_slot_id' => 2,
                'hari' => 'Selasa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 3,
                'time_slot_id' => 3,
                'hari' => 'Selasa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 3,
                'time_slot_id' => 4,
                'hari' => 'Selasa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 4,
                'time_slot_id' => 5,
                'hari' => 'Selasa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 4,
                'time_slot_id' => 6,
                'hari' => 'Selasa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 4,
                'time_slot_id' => 7,
                'hari' => 'Selasa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 6,
                'time_slot_id' => 8,
                'hari' => 'Selasa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 6,
                'time_slot_id' => 9,
                'hari' => 'Selasa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 7,
                'time_slot_id' => 10,
                'hari' => 'Selasa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 7,
                'time_slot_id' => 11,
                'hari' => 'Selasa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 8,
                'time_slot_id' => 12,
                'hari' => 'Selasa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 8,
                'time_slot_id' => 13,
                'hari' => 'Selasa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
