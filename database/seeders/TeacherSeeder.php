<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar nama guru
        $teachers = [
            'Hj. Lisa Indianawati, S.Pd.',
            'Hj. Norhidayati,S.Ag.',
            'Paturrahman,S.Ag.',
            'H. Sauqil Ajmi, S.Pd.',
            'Hj. Rabiatul Adawiyah, S.Ag.',
            'Noor Hidayati, S.Pd.',
            'Ridha Mukhlisah, S.Pd.I.',
            'Pahmi, S.Ag.',
            'Tutilawati, S.Pd.I.',
            'Zainal Anhar, S.Ag.',
            'Hj. Mahmudah, S.Pd.I.',
            'Syaifullah, S.Ag., M.Ag.',
            'Murjani, S.Pd.I.',
            'Syarif Hamidillah, S.Pd.I.',
            'H. Ahd. Pauzi. S.Pd.I.',
            'Norhadiah, S.Ag.',
            'Siti Ramadhah, S.Pd.',
            'Siti Nur Hamidah, S.Si.',
            'Hj. Sri Yani, S.Pd.',
            'Ramdan Syahrin, S.Ag.',
            'Rahimah S.Ag.',
            'Nazaruddin, S.Pd.',
            'Mahdian S.Pd.I.',
            'Maulidah Hasanah, S.Pd.',
            'Ahmad Muttaqin, S.Pd.I.',
            'Dr. Mahmud, M.Pd.I.',
            'Rahmadhani Fadli, S.Pd.',
            'Sri Yanti, S.Pd.I.',
            'Farida Rahmi, S.Pd.',
            'Muhammad Rezky Maulana, S.Pd.',
            'Anita, S.Pd.',
            'Hairullah, S.Hum.',
        ];

        // 1. Pastikan role 'guru' ada. Jika tidak, buat baru.
        // Role ID 10 yang Anda sebutkan akan ditangani oleh sistem secara otomatis
        // jika role 'guru' adalah role ke-10 yang dibuat.
        $guruRole = Role::firstOrCreate(['name' => 'guru', 'guard_name' => 'web']);

        foreach ($teachers as $fullName) {
            // 2. Membersihkan nama untuk membuat email prefix
            // Menghapus gelar akademik dan gelar kehormatan
            $prefixesToRemove = ['Hj. ', 'H. ', 'Dr. '];
            $suffixesToRemove = [', S.Pd.', ',S.Ag.', ', S.Ag.', ', S.Pd.I.', ', S.Ag., M.Ag.', ', S.Si.', ', S.Hum.', ', M.Pd.I.'];

            $cleanName = str_replace($prefixesToRemove, '', $fullName);
            $cleanName = str_replace($suffixesToRemove, '', $cleanName);
            $cleanName = trim($cleanName); // Menghapus spasi di awal/akhir
            $cleanName = str_replace('.', '', $cleanName); // Menghapus titik dari nama seperti "Ahd."

            // Membuat email prefix: ganti spasi dengan titik dan ubah ke huruf kecil
            $emailPrefix = strtolower(str_replace(' ', '.', $cleanName));
            $email = $emailPrefix . '@gmail.com';

            // 3. Membuat atau memperbarui user
            // updateOrCreate akan mencari user berdasarkan email. Jika ada, akan di-update.
            // Jika tidak ada, akan dibuat baru. Ini mencegah duplikasi jika seeder dijalankan berkali-kali.
            $user = User::updateOrCreate(
                ['email' => $email], // Kunci unik untuk mencari user
                [
                    'name' => $fullName,
                    'password' => Hash::make('password'),
                ]
            );

            // 4. Menetapkan role 'guru' ke user
            // Ini akan secara otomatis mengisi tabel model_has_roles
            $user->assignRole($guruRole);

            // Memberi output di console
            $this->command->info("User '{$fullName}' berhasil diproses dengan email '{$email}' dan peran 'guru'.");
        }
    }
}
