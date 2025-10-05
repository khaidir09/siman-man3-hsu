<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('attendances')->insert([
            [
                'rooms_id' => 1,
                'bulan' => '2025-07-01',
                'izin' => 5,
                'sakit' => 7,
                'alpa' => 2,
                'jumlah_absen' => 14,
                'hari_efektif' => 14,
                'jumlah_siswa' => 20,
                'rata_rata' => 95,
            ],
            [
                'rooms_id' => 2,
                'bulan' => '2025-07-01',
                'izin' => 0,
                'sakit' => 3,
                'alpa' => 3,
                'jumlah_absen' => 6,
                'hari_efektif' => 14,
                'jumlah_siswa' => 20,
                'rata_rata' => 87.86,
            ],
            [
                'rooms_id' => 3,
                'bulan' => '2025-07-01',
                'izin' => 3,
                'sakit' => 3,
                'alpa' => 2,
                'jumlah_absen' => 8,
                'hari_efektif' => 14,
                'jumlah_siswa' => 20,
                'rata_rata' => 97.14,
            ],
            [
                'rooms_id' => 4,
                'bulan' => '2025-07-01',
                'izin' => 1,
                'sakit' => 4,
                'alpa' => 1,
                'jumlah_absen' => 6,
                'hari_efektif' => 14,
                'jumlah_siswa' => 20,
                'rata_rata' => 97.86,
            ],
            [
                'rooms_id' => 5,
                'bulan' => '2025-07-01',
                'izin' => 4,
                'sakit' => 8,
                'alpa' => 1,
                'jumlah_absen' => 13,
                'hari_efektif' => 14,
                'jumlah_siswa' => 20,
                'rata_rata' => 95.36,
            ],
            [
                'rooms_id' => 6,
                'bulan' => '2025-07-01',
                'izin' => 1,
                'sakit' => 6,
                'alpa' => 2,
                'jumlah_absen' => 9,
                'hari_efektif' => 14,
                'jumlah_siswa' => 20,
                'rata_rata' => 96.79,
            ],
            [
                'rooms_id' => 7,
                'bulan' => '2025-07-01',
                'izin' => 3,
                'sakit' => 2,
                'alpa' => 2,
                'jumlah_absen' => 7,
                'hari_efektif' => 14,
                'jumlah_siswa' => 20,
                'rata_rata' => 97.5,
            ],
            [
                'rooms_id' => 8,
                'bulan' => '2025-07-01',
                'izin' => 4,
                'sakit' => 2,
                'alpa' => 0,
                'jumlah_absen' => 6,
                'hari_efektif' => 14,
                'jumlah_siswa' => 20,
                'rata_rata' => 97.86,
            ],
            [
                'rooms_id' => 9,
                'bulan' => '2025-07-01',
                'izin' => 1,
                'sakit' => 6,
                'alpa' => 3,
                'jumlah_absen' => 10,
                'hari_efektif' => 14,
                'jumlah_siswa' => 20,
                'rata_rata' => 96.43,
            ],
            [
                'rooms_id' => 10,
                'bulan' => '2025-07-01',
                'izin' => 5,
                'sakit' => 7,
                'alpa' => 2,
                'jumlah_absen' => 14,
                'hari_efektif' => 14,
                'jumlah_siswa' => 20,
                'rata_rata' => 95,
            ],
            [
                'rooms_id' => 11,
                'bulan' => '2025-07-01',
                'izin' => 5,
                'sakit' => 5,
                'alpa' => 3,
                'jumlah_absen' => 13,
                'hari_efektif' => 14,
                'jumlah_siswa' => 20,
                'rata_rata' => 95.36,
            ],
            [
                'rooms_id' => 12,
                'bulan' => '2025-07-01',
                'izin' => 1,
                'sakit' => 2,
                'alpa' => 1,
                'jumlah_absen' => 4,
                'hari_efektif' => 14,
                'jumlah_siswa' => 20,
                'rata_rata' => 98.57,
            ],
        ]);
    }
}
