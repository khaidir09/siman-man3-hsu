<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Membuat Permissions (Izin)
        Permission::create(['name' => 'prestasi index']);
        Permission::create(['name' => 'prestasi create']);
        Permission::create(['name' => 'prestasi update']);
        Permission::create(['name' => 'prestasi delete']);
        Permission::create(['name' => 'prestasi print']);
        Permission::create(['name' => 'pelanggaran index']);
        Permission::create(['name' => 'pelanggaran create']);
        Permission::create(['name' => 'pelanggaran update']);
        Permission::create(['name' => 'pelanggaran delete']);
        Permission::create(['name' => 'pelanggaran print']);
        Permission::create(['name' => 'kehadiran index']);
        Permission::create(['name' => 'kehadiran create']);
        Permission::create(['name' => 'kehadiran update']);
        Permission::create(['name' => 'kehadiran delete']);
        Permission::create(['name' => 'kehadiran print']);
        Permission::create(['name' => 'konseling index']);
        Permission::create(['name' => 'konseling create']);
        Permission::create(['name' => 'konseling update']);
        Permission::create(['name' => 'konseling delete']);
        Permission::create(['name' => 'konseling print']);
        Permission::create(['name' => 'sarpras index']);
        Permission::create(['name' => 'sarpras create']);
        Permission::create(['name' => 'sarpras update']);
        Permission::create(['name' => 'sarpras delete']);
        Permission::create(['name' => 'sarpras print']);
        Permission::create(['name' => 'uks index']);
        Permission::create(['name' => 'uks create']);
        Permission::create(['name' => 'uks update']);
        Permission::create(['name' => 'uks delete']);
        Permission::create(['name' => 'uks print']);
        Permission::create(['name' => 'koperasi index']);
        Permission::create(['name' => 'koperasi create']);
        Permission::create(['name' => 'koperasi update']);
        Permission::create(['name' => 'koperasi delete']);
        Permission::create(['name' => 'koperasi print']);
        Permission::create(['name' => 'alumni index']);
        Permission::create(['name' => 'alumni create']);
        Permission::create(['name' => 'alumni update']);
        Permission::create(['name' => 'alumni delete']);
        Permission::create(['name' => 'alumni print']);
        Permission::create(['name' => 'jadwal index']);
        Permission::create(['name' => 'jadwal create']);
        Permission::create(['name' => 'jadwal update']);
        Permission::create(['name' => 'jadwal delete']);
        Permission::create(['name' => 'jadwal print']);
        Permission::create(['name' => 'ekskul index']);
        Permission::create(['name' => 'ekskul create']);
        Permission::create(['name' => 'ekskul update']);
        Permission::create(['name' => 'ekskul delete']);
        Permission::create(['name' => 'ekskul print']);


        // Membuat Roles (Peran)
        $roleKepalaMadrasah = Role::create(['name' => 'kepala madrasah']);
        $roleWakamadKesiswaan = Role::create(['name' => 'wakamad kesiswaan']);
        $roleWakamadSarpras = Role::create(['name' => 'wakamad sarpras']);
        $roleGuruBK = Role::create(['name' => 'guru bk']);
        $roleWaliKelas = Role::create(['name' => 'wali kelas']);
        $roleUKS = Role::create(['name' => 'uks']);
        $roleKoperasi = Role::create(['name' => 'koperasi']);
        $roleTataUsaha = Role::create(['name' => 'tata usaha']);

        // Memberikan Permissions ke Roles
        $roleKepalaMadrasah->givePermissionTo([
            'prestasi index',
            'prestasi print',
            'pelanggaran index',
            'pelanggaran print',
            'kehadiran index',
            'kehadiran print',
            'konseling index',
            'konseling print',
            'sarpras index',
            'sarpras print',
            'uks index',
            'uks print',
            'koperasi index',
            'koperasi print',
            'alumni index',
            'alumni print',
            'jadwal index',
            'jadwal print',
            'ekskul index',
            'ekskul print',
        ]);

        $roleWakamadKesiswaan->givePermissionTo([
            'konseling index',
            'kehadiran create',
            'kehadiran update',
            'kehadiran delete',
            'kehadiran print',
        ]);

        $roleWaliKelas->givePermissionTo([
            'konseling index',
            'kehadiran create',
            'kehadiran update',
            'kehadiran delete',
            'kehadiran print',
        ]);

        $roleTataUsaha->givePermissionTo([
            'alumni index',
            'alumni create',
            'alumni update',
            'alumni delete',
            'alumni print',
        ]);

        $roleWakamadSarpras->givePermissionTo([
            'sarpras index',
            'sarpras create',
            'sarpras update',
            'sarpras delete',
            'sarpras print',
        ]);
        $roleGuruBK->givePermissionTo([
            'konseling index',
            'konseling create',
            'konseling update',
            'konseling delete',
            'konseling print',
        ]);
        $roleUKS->givePermissionTo([
            'uks index',
            'uks create',
            'uks update',
            'uks delete',
            'uks print',
        ]);
        $roleKoperasi->givePermissionTo([
            'koperasi index',
            'koperasi create',
            'koperasi update',
            'koperasi delete',
            'koperasi print',
        ]);
    }
}
