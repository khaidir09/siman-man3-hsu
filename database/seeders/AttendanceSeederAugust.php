<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AttendanceSeederAugust extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('attendances')->insert([
            [
                'rooms_id' => 1,
                'bulan' => '2025-08-01',
                'izin' => 8,
                'sakit' => 7,
                'alpa' => 4,
                'jumlah_absen' => 19,
                'hari_efektif' => 20,
                'jumlah_siswa' => 20,
                'rata_rata' => 95.25,
            ],
            [
                'rooms_id' => 2,
                'bulan' => '2025-08-01',
                'izin' => 0,
                'sakit' => 2,
                'alpa' => 5,
                'jumlah_absen' => 7,
                'hari_efektif' => 20,
                'jumlah_siswa' => 20,
                'rata_rata' => 98.25,
            ],
            [
                'rooms_id' => 3,
                'bulan' => '2025-08-01',
                'izin' => 5,
                'sakit' => 8,
                'alpa' => 6,
                'jumlah_absen' => 19,
                'hari_efektif' => 20,
                'jumlah_siswa' => 20,
                'rata_rata' => 95.25,
            ],
            [
                'rooms_id' => 4,
                'bulan' => '2025-08-01',
                'izin' => 2,
                'sakit' => 9,
                'alpa' => 5,
                'jumlah_absen' => 16,
                'hari_efektif' => 20,
                'jumlah_siswa' => 20,
                'rata_rata' => 96.0,
            ],
            [
                'rooms_id' => 5,
                'bulan' => '2025-08-01',
                'izin' => 5,
                'sakit' => 8,
                'alpa' => 2,
                'jumlah_absen' => 15,
                'hari_efektif' => 20,
                'jumlah_siswa' => 20,
                'rata_rata' => 96.25,
            ],
            [
                'rooms_id' => 6,
                'bulan' => '2025-08-01',
                'izin' => 5,
                'sakit' => 3,
                'alpa' => 5,
                'jumlah_absen' => 13,
                'hari_efektif' => 20,
                'jumlah_siswa' => 20,
                'rata_rata' => 96.75,
            ],
            [
                'rooms_id' => 7,
                'bulan' => '2025-08-01',
                'izin' => 1,
                'sakit' => 6,
                'alpa' => 3,
                'jumlah_absen' => 10,
                'hari_efektif' => 20,
                'jumlah_siswa' => 20,
                'rata_rata' => 97.5,
            ],
            [
                'rooms_id' => 8,
                'bulan' => '2025-08-01',
                'izin' => 7,
                'sakit' => 3,
                'alpa' => 0,
                'jumlah_absen' => 10,
                'hari_efektif' => 20,
                'jumlah_siswa' => 20,
                'rata_rata' => 97.5,
            ],
            [
                'rooms_id' => 9,
                'bulan' => '2025-08-01',
                'izin' => 6,
                'sakit' => 6,
                'alpa' => 1,
                'jumlah_absen' => 13,
                'hari_efektif' => 20,
                'jumlah_siswa' => 20,
                'rata_rata' => 96.75,
            ],
            [
                'rooms_id' => 10,
                'bulan' => '2025-08-01',
                'izin' => 3,
                'sakit' => 12,
                'alpa' => 5,
                'jumlah_absen' => 20,
                'hari_efektif' => 20,
                'jumlah_siswa' => 20,
                'rata_rata' => 95.0,
            ],
            [
                'rooms_id' => 11,
                'bulan' => '2025-08-01',
                'izin' => 1,
                'sakit' => 12,
                'alpa' => 0,
                'jumlah_absen' => 13,
                'hari_efektif' => 20,
                'jumlah_siswa' => 20,
                'rata_rata' => 96.75,
            ],
            [
                'rooms_id' => 12,
                'bulan' => '2025-08-01',
                'izin' => 6,
                'sakit' => 12,
                'alpa' => 4,
                'jumlah_absen' => 22,
                'hari_efektif' => 20,
                'jumlah_siswa' => 20,
                'rata_rata' => 94.5,
            ],
        ]);
    }
}
