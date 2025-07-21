<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignStudentRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolesToAssign = [];
        $roleId = 12; // Role ID untuk siswa
        $modelType = 'App\\Models\\User';

        // Loop untuk model_id dari 103 sampai 122
        for ($modelId = 103; $modelId <= 122; $modelId++) {
            $rolesToAssign = array_merge($rolesToAssign, [
                [
                    'role_id' => $roleId,
                    'model_type' => $modelType,
                    'model_id' => $modelId,
                ],
            ]);
        }

        // Lakukan bulk insert untuk efisiensi
        // Ini akan menambahkan semua data dalam satu query ke database
        DB::table('model_has_roles')->insert($rolesToAssign);
    }
}
