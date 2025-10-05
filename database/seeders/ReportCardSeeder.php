<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Learning;
use App\Models\ReportCard;
use Illuminate\Database\Seeder;
use App\Models\ReportCardDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReportCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bungkus dalam transaksi untuk memastikan semua data berhasil dibuat
        DB::transaction(function () {
            // Ambil periode ajaran yang aktif untuk diisi rapornya
            // Ganti '1' dengan ID periode ajaran yang sesuai di database Anda
            $activePeriodId = 1;

            // Ambil semua siswa
            $students = Student::with('room')->where('room_id', 1)->get();

            // Loop untuk setiap siswa
            foreach ($students as $student) {

                // 1. Buat atau ambil record master rapor untuk siswa & periode ini
                $reportCard = ReportCard::firstOrCreate(
                    ['student_id' => $student->id, 'academic_period_id' => $activePeriodId],
                    [
                        'room_id' => $student->room_id,
                        'homeroom_teacher_id' => $student->room->wali_kelas_id,
                        'status' => 'Draft', // Status awal adalah Draft
                        'sakit' => rand(0, 5),
                        'izin' => rand(0, 5),
                        'alfa' => rand(0, 3),
                    ]
                );

                // 2. Ambil semua "pembelajaran" yang ada di kelas siswa tersebut
                $learningsInClass = Learning::where('room_id', $student->room_id)
                    ->where('academic_period_id', $activePeriodId)
                    ->with('learningObjectives')
                    ->get();

                // 3. Loop untuk setiap pembelajaran (mata pelajaran)
                foreach ($learningsInClass as $learning) {

                    // 1. Generate satu nilai akhir acak
                    $nilaiAkhir = rand(68, 98);

                    // 2. Tentukan kalimat pembuka berdasarkan nilai akhir
                    if ($nilaiAkhir >= 86) {
                        $openingPhrase = 'Menunjukkan penguasaan yang sangat baik';
                    } elseif ($nilaiAkhir >= 76) {
                        $openingPhrase = 'Menunjukkan penguasaan yang baik';
                    } else {
                        $openingPhrase = 'Menunjukkan pemahaman yang cukup';
                    }

                    // Ambil 2 TP secara acak
                    $randomObjectives = $learning->learningObjectives->isNotEmpty()
                        ? $learning->learningObjectives->random(min(2, $learning->learningObjectives->count()))
                        : collect();

                    // Buat deskripsi capaian
                    $finalDescription = $openingPhrase . ' pada sebagian besar kompetensi.';
                    if ($randomObjectives->isNotEmpty()) {
                        $descriptions = $randomObjectives->pluck('deskripsi')->implode(', ');
                        $finalDescription = $openingPhrase . ' dalam: ' . $descriptions . '.';
                    }

                    // 4. Buat atau update detail rapor
                    $detail = ReportCardDetail::updateOrCreate(
                        ['report_card_id' => $reportCard->id, 'subject_id' => $learning->subject_id],
                        [
                            'nilai_akhir' => $nilaiAkhir,
                            'deskripsi_capaian' => $finalDescription,
                        ]
                    );

                    // 5. Hubungkan detail rapor dengan TP yang dipilih
                    if ($randomObjectives->isNotEmpty()) {
                        $detail->learningObjectives()->sync($randomObjectives->pluck('id'));
                    }
                }
            }
        });
    }
}
