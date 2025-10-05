<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AcademicAchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('academic_achievements')->insert([
            // Kelas 1
            [
                'nisn' => '0081123456',
                'nama' => 'Muhammad Alif Pratama',
                'ortu' => 'Budi Santoso',
                'rooms_id' => 1,
                'jumlah_nilai' => 1349,
                'rata_rata' => 89.93,
                'ranking' => 1,
                'academic_periods_id' => 2
            ],
            [
                'nisn' => '0079876543',
                'nama' => 'Aisyah Putri Lestari',
                'ortu' => 'Agus Setiawan',
                'rooms_id' => 1,
                'jumlah_nilai' => 1348,
                'rata_rata' => 89.86,
                'ranking' => 2,
                'academic_periods_id' => 2
            ],
            [
                'nisn' => '0082233445',
                'nama' => 'Fauzan Adriansyah',
                'ortu' => 'Ahmad Hidayat',
                'rooms_id' => 1,
                'jumlah_nilai' => 1325,
                'rata_rata' => 88.33,
                'ranking' => 3,
                'academic_periods_id' => 2
            ],

            // Kelas 2
            [
                'nisn' => '0073344556',
                'nama' => 'Siti Nurhaliza',
                'ortu' => 'Eko Prasetyo',
                'rooms_id' => 2,
                'jumlah_nilai' => 1295,
                'rata_rata' => 86.33,
                'ranking' => 1,
                'academic_periods_id' => 2
            ],
            [
                'nisn' => '0084455667',
                'nama' => 'Rizky Maulana',
                'ortu' => 'Joko Susilo',
                'rooms_id' => 2,
                'jumlah_nilai' => 1290,
                'rata_rata' => 86.00,
                'ranking' => 2,
                'academic_periods_id' => 2
            ],
            [
                'nisn' => '0075566778',
                'nama' => 'Annisa Rahmawati',
                'ortu' => 'Yusuf Abdullah',
                'rooms_id' => 2,
                'jumlah_nilai' => 1289,
                'rata_rata' => 85.93,
                'ranking' => 3,
                'academic_periods_id' => 2
            ],

            // Kelas 3
            [
                'nisn' => '0086677889',
                'nama' => 'Ahmad Zaki Abdullah',
                'ortu' => 'Abdul Rahman',
                'rooms_id' => 3,
                'jumlah_nilai' => 1339,
                'rata_rata' => 89.27,
                'ranking' => 1,
                'academic_periods_id' => 2
            ],
            [
                'nisn' => '0077788990',
                'nama' => 'Fatimah Azzahra',
                'ortu' => 'Hasan Basri',
                'rooms_id' => 3,
                'jumlah_nilai' => 1313,
                'rata_rata' => 87.53,
                'ranking' => 2,
                'academic_periods_id' => 2
            ],
            [
                'nisn' => '0088899001',
                'nama' => 'Iqbal Ramadhan',
                'ortu' => 'Syamsul Arifin',
                'rooms_id' => 3,
                'jumlah_nilai' => 1306,
                'rata_rata' => 87.07,
                'ranking' => 3,
                'academic_periods_id' => 2
            ],

            // ... (lanjutkan untuk kelas 4 hingga 12 dengan pola yang sama)

            // Kelas 12
            [
                'nisn' => '0076677889',
                'nama' => 'Laila Ramadhani',
                'ortu' => 'Taufik Hidayat',
                'rooms_id' => 4,
                'jumlah_nilai' => 1363,
                'rata_rata' => 90.87,
                'ranking' => 1,
                'academic_periods_id' => 2
            ],
            [
                'nisn' => '0087788990',
                'nama' => 'Rasyid Al-Ghifari',
                'ortu' => 'Zainal Abidin',
                'rooms_id' => 4,
                'jumlah_nilai' => 1361,
                'rata_rata' => 90.73,
                'ranking' => 2,
                'academic_periods_id' => 2
            ],
            [
                'nisn' => '0078899001',
                'nama' => 'Sofia Marwah',
                'ortu' => 'Anwar Sanusi',
                'rooms_id' => 4,
                'jumlah_nilai' => 1319,
                'rata_rata' => 87.93,
                'ranking' => 3,
                'academic_periods_id' => 2
            ],
        ]);
    }
}
