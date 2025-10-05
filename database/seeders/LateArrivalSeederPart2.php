<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LateArrivalSeederPart2 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('late_arrivals')->insert([
            [
                'student_id' => 65,
                'nama_siswa' => 'Wildan Al-Farisi',
                'guru_piket' => 'Syaifullah, S.Ag., M.Ag.',
                'kelas' => 'X B',
                'tanggal' => '2025-07-21',
                'waktu_datang' => '08:45:12',
            ],
            [
                'student_id' => 43,
                'nama_siswa' => 'Hasan Basri',
                'guru_piket' => 'Pahmi, S.Ag.',
                'kelas' => 'X A',
                'tanggal' => '2025-07-21',
                'waktu_datang' => '08:48:58',
            ],
            [
                'student_id' => 29,
                'nama_siswa' => 'Siti Aisyah Putri',
                'guru_piket' => 'Anita, S.Pd.',
                'kelas' => 'X A',
                'tanggal' => '2025-07-21',
                'waktu_datang' => '08:52:26',
            ],
            [
                'student_id' => 32,
                'nama_siswa' => 'Annisa Fitriani',
                'guru_piket' => 'Tutilawati, S.Pd.I.',
                'kelas' => 'X A',
                'tanggal' => '2025-07-21',
                'waktu_datang' => '08:42:10',
            ],
            [
                'student_id' => 134,
                'nama_siswa' => 'Khadijah Al-Kubro',
                'guru_piket' => 'Murjani, S.Pd.I.',
                'kelas' => 'X D',
                'tanggal' => '2025-07-21',
                'waktu_datang' => '08:50:01',
            ],
            [
                'student_id' => 123,
                'nama_siswa' => 'Muhammad Alif Pratama',
                'guru_piket' => 'Ramdan Syahrin, S.Ag.',
                'kelas' => 'X D',
                'tanggal' => '2025-07-22',
                'waktu_datang' => '08:42:19',
            ],
            [
                'student_id' => 61,
                'nama_siswa' => 'Lia Agustina',
                'guru_piket' => 'Nazaruddin, S.Pd.',
                'kelas' => 'X B',
                'tanggal' => '2025-07-22',
                'waktu_datang' => '08:41:24',
            ],
            [
                'student_id' => 63,
                'nama_siswa' => 'Aulia Rahman',
                'guru_piket' => 'Norhadiah, S.Ag.',
                'kelas' => 'X B',
                'tanggal' => '2025-07-22',
                'waktu_datang' => '08:48:05',
            ],
            [
                'student_id' => 53,
                'nama_siswa' => 'Nadia Aulia',
                'guru_piket' => 'Anita, S.Pd.',
                'kelas' => 'X B',
                'tanggal' => '2025-07-22',
                'waktu_datang' => '08:57:56',
            ],
            [
                'student_id' => 132,
                'nama_siswa' => 'Fatimah Azzahra',
                'guru_piket' => 'Syarif Hamidillah, S.Pd.I.',
                'kelas' => 'X D',
                'tanggal' => '2025-07-23',
                'waktu_datang' => '08:49:42',
            ],
            [
                'student_id' => 37,
                'nama_siswa' => 'Daffa Al-Hafidz',
                'guru_piket' => 'Hj. Mahmudah, S.Pd.I.',
                'kelas' => 'X A',
                'tanggal' => '2025-07-23',
                'waktu_datang' => '08:44:15',
            ],
            [
                'student_id' => 136,
                'nama_siswa' => 'Aminah Hasanah',
                'guru_piket' => 'Anita, S.Pd.',
                'kelas' => 'X D',
                'tanggal' => '2025-07-23',
                'waktu_datang' => '08:50:36',
            ],
            [
                'student_id' => 48,
                'nama_siswa' => 'Fajar Maulana Siddiq',
                'guru_piket' => 'Murjani, S.Pd.I.',
                'kelas' => 'X B',
                'tanggal' => '2025-07-23',
                'waktu_datang' => '08:50:42',
            ],
            [
                'student_id' => 125,
                'nama_siswa' => 'Ahmad Zaki Abdullah',
                'guru_piket' => 'Hj. Mahmudah, S.Pd.I.',
                'kelas' => 'X D',
                'tanggal' => '2025-07-23',
                'waktu_datang' => '08:46:59',
            ],
            [
                'student_id' => 74,
                'nama_siswa' => 'Guntur Wibowo',
                'guru_piket' => 'Rahimah S.Ag.',
                'kelas' => 'X C',
                'tanggal' => '2025-07-24',
                'waktu_datang' => '08:53:46',
            ],
            [
                'student_id' => 62,
                'nama_siswa' => 'Dimas Saputra',
                'guru_piket' => 'Hj. Sri Yani, S.Pd.',
                'kelas' => 'X B',
                'tanggal' => '2025-07-24',
                'waktu_datang' => '08:50:45',
            ],
            [
                'student_id' => 32,
                'nama_siswa' => 'Annisa Fitriani',
                'guru_piket' => 'Ridha Mukhlisah, S.Pd.I.',
                'kelas' => 'X A',
                'tanggal' => '2025-07-24',
                'waktu_datang' => '08:54:27',
            ],
            [
                'student_id' => 73,
                'nama_siswa' => 'Dian Novita Sari',
                'guru_piket' => 'Hj. Sri Yani, S.Pd.',
                'kelas' => 'X C',
                'tanggal' => '2025-07-24',
                'waktu_datang' => '08:50:39',
            ],
            [
                'student_id' => 84,
                'nama_siswa' => 'Kamal Pasya',
                'guru_piket' => 'Sri Yanti, S.Pd.I.',
                'kelas' => 'X C',
                'tanggal' => '2025-07-24',
                'waktu_datang' => '08:54:54',
            ],
            [
                'student_id' => 142,
                'nama_siswa' => 'Hasanah Fitriani',
                'guru_piket' => 'Anita, S.Pd.',
                'kelas' => 'X D',
                'tanggal' => '2025-07-25',
                'waktu_datang' => '08:41:23',
            ],
            [
                'student_id' => 68,
                'nama_siswa' => 'Rangga Dwi Saputra',
                'guru_piket' => 'Nazaruddin, S.Pd.',
                'kelas' => 'X C',
                'tanggal' => '2025-07-25',
                'waktu_datang' => '08:55:36',
            ],
            [
                'student_id' => 60,
                'nama_siswa' => 'Bayu Anggara',
                'guru_piket' => 'H. Sauqil Ajmi, S.Pd.',
                'kelas' => 'X B',
                'tanggal' => '2025-07-25',
                'waktu_datang' => '08:49:03',
            ],
            [
                'student_id' => 140,
                'nama_siswa' => 'Yasmin Salsabila',
                'guru_piket' => 'Hj. Mahmudah, S.Pd.I.',
                'kelas' => 'X D',
                'tanggal' => '2025-07-25',
                'waktu_datang' => '08:57:08',
            ],
        ]);
    }
}
