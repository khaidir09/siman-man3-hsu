<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LateArrivalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('late_arrivals')->insert([
            [
                'student_id' => 137,
                'nama_siswa' => 'Dimas Setiawan',
                'guru_piket' => 'Hairullah, S.Hum.',
                'kelas' => 'X D',
                'tanggal' => '2025-07-14',
                'waktu_datang' => '08:55:13',
            ],
            [
                'student_id' => 40,
                'nama_siswa' => 'Aditya Nugraha',
                'guru_piket' => 'Farida Rahmi, S.Pd.',
                'kelas' => 'X A',
                'tanggal' => '2025-07-14',
                'waktu_datang' => '08:45:00',
            ],
            [
                'student_id' => 77,
                'nama_siswa' => 'Rina Amelia',
                'guru_piket' => 'Syaifullah, S.Ag., M.Ag.',
                'kelas' => 'X C',
                'tanggal' => '2025-07-14',
                'waktu_datang' => '08:41:28',
            ],
            [
                'student_id' => 67,
                'nama_siswa' => 'Bunga Citra Lestari',
                'guru_piket' => 'Anita, S.Pd.',
                'kelas' => 'X C',
                'tanggal' => '2025-07-14',
                'waktu_datang' => '08:57:24',
            ],
            [
                'student_id' => 130,
                'nama_siswa' => 'Indah Permatasari',
                'guru_piket' => 'Ahmad Muttaqin, S.Pd.I.',
                'kelas' => 'X D',
                'tanggal' => '2025-07-15',
                'waktu_datang' => '08:49:33',
            ],
            [
                'student_id' => 43,
                'nama_siswa' => 'Hasan Basri',
                'guru_piket' => 'Hj. Rabiatul Adawiyah, S.Ag.',
                'kelas' => 'X A',
                'tanggal' => '2025-07-15',
                'waktu_datang' => '08:53:09',
            ],
            [
                'student_id' => 65,
                'nama_siswa' => 'Wildan Al-Farisi',
                'guru_piket' => 'Hairullah, S.Hum.',
                'kelas' => 'X B',
                'tanggal' => '2025-07-15',
                'waktu_datang' => '08:53:04',
            ],
            [
                'student_id' => 39,
                'nama_siswa' => 'Iqbal Ramadhan',
                'guru_piket' => 'Zainal Anhar, S.Ag.',
                'kelas' => 'X A',
                'tanggal' => '2025-07-15',
                'waktu_datang' => '08:44:31',
            ],
            [
                'student_id' => 72,
                'nama_siswa' => 'Reza Ardiyansah',
                'guru_piket' => 'Ridha Mukhlisah, S.Pd.I.',
                'kelas' => 'X C',
                'tanggal' => '2025-07-16',
                'waktu_datang' => '08:42:55',
            ],
            [
                'student_id' => 33,
                'nama_siswa' => 'Yusuf Ali Alatas',
                'guru_piket' => 'Ramdan Syahrin, S.Ag.',
                'kelas' => 'X A',
                'tanggal' => '2025-07-16',
                'waktu_datang' => '08:55:05',
            ],
            [
                'student_id' => 84,
                'nama_siswa' => 'Kamal Pasya',
                'guru_piket' => 'Siti Nur Hamidah, S.Si.',
                'kelas' => 'X C',
                'tanggal' => '2025-07-16',
                'waktu_datang' => '08:56:36',
            ],
            [
                'student_id' => 59,
                'nama_siswa' => 'Zahra Cantika',
                'guru_piket' => 'Sri Yanti, S.Pd.I.',
                'kelas' => 'X B',
                'tanggal' => '2025-07-16',
                'waktu_datang' => '08:57:49',
            ],
            [
                'student_id' => 31,
                'nama_siswa' => 'Fatimah Az-Zahra',
                'guru_piket' => 'Dr. Mahmud, M.Pd.I.',
                'kelas' => 'X A',
                'tanggal' => '2025-07-16',
                'waktu_datang' => '08:41:02',
            ],
            [
                'student_id' => 71,
                'nama_siswa' => 'Sari Mutiara',
                'guru_piket' => 'Noor Hidayati, S.Pd.',
                'kelas' => 'X C',
                'tanggal' => '2025-07-17',
                'waktu_datang' => '08:44:49',
            ],
            [
                'student_id' => 73,
                'nama_siswa' => 'Dian Novita Sari',
                'guru_piket' => 'Hj. Mahmudah, S.Pd.I.',
                'kelas' => 'X C',
                'tanggal' => '2025-07-17',
                'waktu_datang' => '08:43:24',
            ],
            [
                'student_id' => 80,
                'nama_siswa' => 'Taufik Hidayat',
                'guru_piket' => 'Rahmadhani Fadli, S.Pd.',
                'kelas' => 'X C',
                'tanggal' => '2025-07-17',
                'waktu_datang' => '08:41:29',
            ],
            [
                'student_id' => 48,
                'nama_siswa' => 'Fajar Maulana Siddiq',
                'guru_piket' => 'Siti Ramadhah, S.Pd.',
                'kelas' => 'X B',
                'tanggal' => '2025-07-17',
                'waktu_datang' => '08:59:44',
            ],
            [
                'student_id' => 46,
                'nama_siswa' => 'Rizky Akbar Pratama',
                'guru_piket' => 'H. Sauqil Ajmi, S.Pd.',
                'kelas' => 'X B',
                'tanggal' => '2025-07-18',
                'waktu_datang' => '08:48:50',
            ],
            [
                'student_id' => 35,
                'nama_siswa' => 'Abdul Rahman Hakim',
                'guru_piket' => 'H. Ahd. Pauzi. S.Pd.I.',
                'kelas' => 'X A',
                'tanggal' => '2025-07-18',
                'waktu_datang' => '08:59:33',
            ],
            [
                'student_id' => 29,
                'nama_siswa' => 'Siti Aisyah Putri',
                'guru_piket' => 'Farida Rahmi, S.Pd.',
                'kelas' => 'X A',
                'tanggal' => '2025-07-18',
                'waktu_datang' => '08:45:47',
            ],
            [
                'student_id' => 72,
                'nama_siswa' => 'Reza Ardiyansah',
                'guru_piket' => 'Hairullah, S.Hum.',
                'kelas' => 'X C',
                'tanggal' => '2025-07-18',
                'waktu_datang' => '08:44:06',
            ],
            [
                'student_id' => 57,
                'nama_siswa' => 'Putri Wulandari',
                'guru_piket' => 'Syarif Hamidillah, S.Pd.I.',
                'kelas' => 'X B',
                'tanggal' => '2025-07-18',
                'waktu_datang' => '08:50:25',
            ],
        ]);
    }
}
