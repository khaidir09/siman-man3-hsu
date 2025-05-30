<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Definisikan Roles (sesuaikan jika Anda sudah punya RolesAndPermissionsSeeder terpisah)
        // Jika Anda sudah menjalankan RolesAndPermissionsSeeder sebelumnya, bagian ini bisa
        // Anda sesuaikan atau pastikan role sudah ada.
        $rolesData = [
            'kepala madrasah',
            'wakamad kesiswaan',
            'wakamad sarpras',
            'guru bk',
            'wali kelas',
            'uks',
            'koperasi',
            'tata usaha',
        ];

        foreach ($rolesData as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // Data pengguna
        $users = [
            [
                'name' => 'Kepala Madrasah',
                'email_prefix' => 'kepalamadrasah',
                'role' => 'kepala madrasah',
            ],
            [
                'name' => 'Kesiswaan',
                'email_prefix' => 'kesiswaan',
                'role' => 'wakamad kesiswaan',
            ],
            [
                'name' => 'Sarpras',
                'email_prefix' => 'sarpras',
                'role' => 'wakamad sarpras',
            ],
            [
                'name' => 'BK',
                'email_prefix' => 'bk',
                'role' => 'guru bk',
            ],
            [
                'name' => 'Wali Kelas',
                'email_prefix' => 'walikelas',
                'role' => 'wali kelas',
            ],
            [
                'name' => 'UKS',
                'email_prefix' => 'uks',
                'role' => 'uks',
            ],
            [
                'name' => 'Koperasi',
                'email_prefix' => 'koperasi',
                'role' => 'koperasi',
            ],
            [
                'name' => 'Tata Usaha',
                'email_prefix' => 'tatausaha',
                'role' => 'tata usaha',
            ],
        ];

        $defaultPassword = 'password';

        foreach ($users as $userData) {
            // Cek apakah user sudah ada berdasarkan email
            $user = User::where('email', strtolower($userData['email_prefix']) . '@gmail.com')->first();

            if (!$user) {
                $user = User::create([
                    'name' => $userData['name'],
                    'email' => strtolower($userData['email_prefix']) . '@gmail.com',
                    'password' => Hash::make($defaultPassword),
                    'email_verified_at' => now(),
                ]);

                // Assign role ke user yang baru dibuat
                $user->assignRole($userData['role']);

                $this->command->info("User {$userData['name']} created with role {$userData['role']}.");
            } else {
                // Jika user sudah ada, pastikan role-nya sesuai (atau update jika perlu)
                if (!$user->hasRole($userData['role'])) {
                    // Hapus role lama jika perlu, atau cukup tambahkan role baru
                    // $user->syncRoles([$userData['role']]); // Ini akan mengganti semua role dengan role ini
                    $user->assignRole($userData['role']); // Ini akan menambahkan role jika belum ada
                    $this->command->info("User {$userData['name']} already exists, assigned role {$userData['role']}.");
                } else {
                    $this->command->info("User {$userData['name']} already exists with role {$userData['role']}.");
                }
            }
        }

        $this->command->info('User seeding completed.');
    }
}
