<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder7 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            'Muhammad Rifqi Pratama',
            'Siti Nurhaliza Safitri',
            'Ahmad Fauzan Rahman',
            'Annisa Putri Ramadhani',
            'Muhammad Iqbal Maulana',
            'Putri Aulia Rahman',
            'Reza Aditya Nugraha',
            'Dinda Ayu Lestari',
            'Muhammad Zaki Mubarak',
            'Nabila Azzahra Putri',
            'Fajar Sidik Permana',
            'Indah Mutia Sari',
            'Muhammad Rizky Ananda',
            'Aulia Cahya Kamila',
            'Gilang Ramadhan Saputra',
            'Syifa Aulia Salsabila',
            'Muhammad Aldiansyah Putra',
            'Amanda Dwi Lestari',
            'Dimas Wahyu Pratama',
            'Zahra Nur Azizah'
        ];

        DB::transaction(function () use ($students) {
            foreach ($students as $name) {

                // 1. Membuat data untuk User
                $user = User::create([
                    'name' => $name,
                    // Membuat email dari nama, contoh: muhammad.farhan.abdullah@example.com
                    'email' => strtolower(str_replace(' ', '.', $name)) . '@gmail.com',
                    'password' => Hash::make('password'), // Password default untuk semua siswa
                ]);

                // 2. Menetapkan role 'siswa' untuk user yang baru dibuat
                // Pastikan role 'siswa' sudah ada di database Anda
                $user->assignRole('siswa');

                // 3. Membuat data untuk Student

                // Menghasilkan tahun lahir acak (misal: 2007-2009)
                $birthYear = rand(2007, 2009);

                // Membuat NISN sesuai format: 3 digit tahun lahir + 7 digit acak
                $nisn = '0' . substr($birthYear, -2) . mt_rand(1000000, 9999999);

                Student::create([
                    'user_id' => $user->id,
                    'nama_lengkap' => $name,
                    'nisn' => $nisn,
                    'tanggal_lahir' => $birthYear . '-' . rand(1, 12) . '-' . rand(1, 28), // Tambahan data tgl lahir
                    'room_id' => 7,
                    'status' => 'Aktif',
                ]);
            }
        });
    }
}
