<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ThirdStudentGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studentNames = [
            "Fahmi Aziz",
            "Bunga Citra Lestari",
            "Rangga Dwi Saputra",
            "Aulia Putri Salsabila",
            "Irfan Hakim",
            "Sari Mutiara",
            "Reza Ardiyansah",
            "Dian Novita Sari",
            "Guntur Wibowo",
            "Wulan Dari",
            "Handoko Aji",
            "Rina Amelia",
            "Agung Setiawan",
            "Vina Panduwinata",
            "Taufik Hidayat",
            "Linda Wati",
            "Jamaludin",
            "Farah Diba",
            "Kamal Pasya",
            "Zaskia Adya Mecca"
        ];

        DB::transaction(function () use ($studentNames) {
            foreach ($studentNames as $name) {
                // 1. Membuat data User
                $user = User::create([
                    'name' => $name,
                    'email' => strtolower(str_replace(' ', '.', $name)) . '@gmail.com',
                    'password' => Hash::make('password'),
                ]);

                // 2. Menetapkan role 'siswa'
                $user->assignRole('siswa');

                // 3. Membuat data Student

                // Menghasilkan tahun lahir acak antara 2009 dan 2010
                $birthYear = rand(2009, 2010);

                // Membuat NISN: 3 digit tahun lahir + 7 digit acak
                $nisn = '0' . substr($birthYear, -2) . mt_rand(1000000, 9999999);

                Student::create([
                    'user_id' => $user->id,
                    'nama_lengkap' => $name,
                    'nisn' => $nisn,
                    'tanggal_lahir' => $birthYear . '-' . rand(1, 12) . '-' . rand(1, 28),
                    'room_id' => 3, // Menggunakan room_id 3
                    'status' => 'Aktif',
                ]);
            }
        });
    }
}
