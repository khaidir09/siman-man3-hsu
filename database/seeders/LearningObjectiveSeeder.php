<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LearningObjectiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- SESUAIKAN DATA DI BAWAH INI ---
        // Ganti 'Nama Mata Pelajaran' dan isi array dengan ID dari tabel 'learnings' Anda.
        // Contoh: Jika mapel Fikih diajarkan di 3 kelas berbeda, maka akan ada 3 learning_id.
        $subjectLearnings = [
            'Fikih' => [1, 15, 29], // Ganti dengan learning_id untuk mapel Fikih
            'Bahasa Indonesia' => [2, 16, 30], // Ganti dengan learning_id untuk mapel Bhs. Indonesia
            'Matematika' => [3, 17, 31], // Ganti dengan learning_id untuk mapel Matematika
            'Sejarah Kebudayaan Islam' => [4, 18],
            'Akidah Akhlak' => [5, 19],
            'Bahasa Arab' => [6, 20],
            // ... Tambahkan semua mata pelajaran dan learning_id Anda di sini
        ];
        // ------------------------------------

        $dataToInsert = [];
        $now = Carbon::now();

        // Fungsi untuk membuat deskripsi TP
        $generate_objectives = function ($subject_name) {
            return [
                "Siswa mampu memahami konsep dasar dari {$subject_name}",
                "Siswa mampu menganalisis studi kasus terkait {$subject_name}",
                "Siswa mampu menerapkan teori {$subject_name} dalam pemecahan masalah",
            ];
        };

        // Hapus data lama untuk menghindari duplikat
        DB::table('learning_objectives')->delete();

        // Loop melalui data yang sudah Anda siapkan
        foreach ($subjectLearnings as $subjectName => $learningIds) {
            $objectives = $generate_objectives($subjectName);
            foreach ($learningIds as $learningId) {
                foreach ($objectives as $description) {
                    $dataToInsert[] = [
                        'learning_id' => $learningId,
                        'description' => $description,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
        }

        // Insert semua data sekaligus ke database untuk efisiensi
        DB::table('learning_objectives')->insert($dataToInsert);
    }
}
