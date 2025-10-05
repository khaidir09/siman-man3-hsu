<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ScheduleJumatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Jadwal hari Jumat untuk room_id 1
        DB::table('schedules')->insert([
            [
                'learning_id' => 21,
                'time_slot_id' => 2,
                'hari' => 'Jumat',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 21,
                'time_slot_id' => 3,
                'hari' => 'Jumat',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 21,
                'time_slot_id' => 4,
                'hari' => 'Jumat',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 70,
                'time_slot_id' => 5,
                'hari' => 'Jumat',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 70,
                'time_slot_id' => 6,
                'hari' => 'Jumat',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 70,
                'time_slot_id' => 7,
                'hari' => 'Jumat',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 169,
                'time_slot_id' => 8,
                'hari' => 'Jumat',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 169,
                'time_slot_id' => 9,
                'hari' => 'Jumat',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 169,
                'time_slot_id' => 10,
                'hari' => 'Jumat',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 237,
                'time_slot_id' => 11,
                'hari' => 'Jumat',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'learning_id' => 237,
                'time_slot_id' => 12,
                'hari' => 'Jumat',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
