<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LateArrivalSeederPart3 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('late_arrivals')->insert([
            [
                'student_id' => 49,
                'nama_siswa' => 'Dewi Lestari',
                'guru_piket' => 'Hairullah, S.Hum.',
                'kelas' => 'X B',
                'tanggal' => '2025-07-28',
                'waktu_datang' => '08:55:44',
            ],
            [
                'student_id' => 38,
                'nama_siswa' => 'Khairul Azzam',
                'guru_piket' => 'Siti Ramadhah, S.Pd.',
                'kelas' => 'X A',
                'tanggal' => '2025-07-28',
                'waktu_datang' => '08:41:06',
            ],
            [
                'student_id' => 84,
                'nama_siswa' => 'Kamal Pasya',
                'guru_piket' => 'Farida Rahmi, S.Pd.',
                'kelas' => 'X C',
                'tanggal' => '2025-07-28',
                'waktu_datang' => '08:59:01',
            ],
            [
                'student_id' => 50,
                'nama_siswa' => 'Muhammad Zidan Ramadhan',
                'guru_piket' => 'Anita, S.Pd.',
                'kelas' => 'X B',
                'tanggal' => '2025-07-29',
                'waktu_datang' => '08:59:27',
            ],
            [
                'student_id' => 72,
                'nama_siswa' => 'Reza Ardiyansah',
                'guru_piket' => 'Siti Nur Hamidah, S.Si.',
                'kelas' => 'X C',
                'tanggal' => '2025-07-29',
                'waktu_datang' => '08:41:22',
            ],
            [
                'student_id' => 124,
                'nama_siswa' => 'Siti Aisyah',
                'guru_piket' => 'Norhadiah, S.Ag.',
                'kelas' => 'X D',
                'tanggal' => '2025-07-29',
                'waktu_datang' => '08:55:14',
            ],
            [
                'student_id' => 128,
                'nama_siswa' => 'Dewi',
                'guru_piket' => 'Nazaruddin, S.Pd.',
                'kelas' => 'X D',
                'tanggal' => '2025-07-29',
                'waktu_datang' => '08:51:13',
            ],
            [
                'student_id' => 42,
                'nama_siswa' => 'Putri Amelia',
                'guru_piket' => 'Ahmad Muttaqin, S.Pd.I.',
                'kelas' => 'X A',
                'tanggal' => '2025-07-29',
                'waktu_datang' => '08:41:26',
            ],
            [
                'student_id' => 47,
                'nama_siswa' => 'Annisa Rahmawati',
                'guru_piket' => 'Anita, S.Pd.',
                'kelas' => 'X B',
                'tanggal' => '2025-07-30',
                'waktu_datang' => '08:51:39',
            ],
            [
                'student_id' => 127,
                'nama_siswa' => 'Fauzan Adriansyah',
                'guru_piket' => 'Muhammad Rezky Maulana, S.Pd.',
                'kelas' => 'X D',
                'tanggal' => '2025-07-30',
                'waktu_datang' => '08:47:22',
            ],
            [
                'student_id' => 63,
                'nama_siswa' => 'Aulia Rahman',
                'guru_piket' => 'Anita, S.Pd.',
                'kelas' => 'X B',
                'tanggal' => '2025-07-30',
                'waktu_datang' => '08:42:50',
            ],
            [
                'student_id' => 59,
                'nama_siswa' => 'Zahra Cantika',
                'guru_piket' => 'Syaifullah, S.Ag., M.Ag.',
                'kelas' => 'X B',
                'tanggal' => '2025-07-31',
                'waktu_datang' => '08:59:49',
            ],
            [
                'student_id' => 83,
                'nama_siswa' => 'Farah Diba',
                'guru_piket' => 'H. Sauqil Ajmi, S.Pd.',
                'kelas' => 'X C',
                'tanggal' => '2025-07-31',
                'waktu_datang' => '08:55:35',
            ],
            [
                'student_id' => 33,
                'nama_siswa' => 'Yusuf Ali Alatas',
                'guru_piket' => 'Zainal Anhar, S.Ag.',
                'kelas' => 'X A',
                'tanggal' => '2025-07-31',
                'waktu_datang' => '08:48:33',
            ],
            [
                'student_id' => 132,
                'nama_siswa' => 'Fatimah Azzahra',
                'guru_piket' => 'Hj. Lisa Indianawati, S.Pd.',
                'kelas' => 'X D',
                'tanggal' => '2025-08-01',
                'waktu_datang' => '08:48:21',
            ],
            [
                'student_id' => 33,
                'nama_siswa' => 'Yusuf Ali Alatas',
                'guru_piket' => 'H. Ahd. Pauzi. S.Pd.I.',
                'kelas' => 'X A',
                'tanggal' => '2025-08-01',
                'waktu_datang' => '08:49:26',
            ],
            [
                'student_id' => 130,
                'nama_siswa' => 'Indah Permatasari',
                'guru_piket' => 'Hairullah, S.Hum.',
                'kelas' => 'X D',
                'tanggal' => '2025-08-01',
                'waktu_datang' => '08:43:20',
            ],
            [
                'student_id' => 38,
                'nama_siswa' => 'Khairul Azzam',
                'guru_piket' => 'Hj. Rabiatul Adawiyah, S.Ag.',
                'kelas' => 'X A',
                'tanggal' => '2025-08-01',
                'waktu_datang' => '08:46:10',
            ],
        ]);
    }
}
