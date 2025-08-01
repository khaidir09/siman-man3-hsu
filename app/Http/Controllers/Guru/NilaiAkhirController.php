<?php

namespace App\Http\Controllers\Guru;

use App\Models\Learning;
use App\Models\Schedule;
use App\Models\ReportCard;
use Illuminate\Http\Request;
use App\Models\ReportCardDetail;
use App\Models\LearningObjective;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NilaiAkhirController extends Controller
{
    public function edit(Learning $learning)
    {
        if ($learning->user_id !== Auth::id()) {
            abort(403);
        }

        $learning->load(['room.students', 'subject', 'academicPeriod', 'learningObjectives']);
        $students = $learning->room->students;
        $learningObjectives = $learning->learningObjectives;

        $existingDetails = ReportCardDetail::with('learningObjectives')
            // Cari ReportCardDetail yang relasi 'reportCard'-nya memenuhi SEMUA kondisi berikut:
            ->whereHas('reportCard', function ($query) use ($learning, $students) {
                $query->where('academic_period_id', $learning->academic_period_id)
                    // Pindahkan .whereIn ke dalam sini
                    ->whereIn('student_id', $students->pluck('id'));
            })
            // Filter 'subject_id' tetap di sini karena kolom ini ada di 'report_card_details'
            ->where('subject_id', $learning->subject_id)
            ->get();

        return view('guru.edit-nilai-akhir', compact('learning', 'students', 'learningObjectives', 'existingDetails'));
    }

    public function store(Request $request, Learning $learning)
    {
        if ($learning->user_id !== Auth::id()) {
            abort(403);
        }

        DB::transaction(function () use ($request, $learning) {
            foreach ($learning->room->students as $student) {
                $reportCard = ReportCard::firstOrCreate(
                    ['student_id' => $student->id, 'academic_period_id' => $learning->academic_period_id],
                    ['room_id' => $learning->room_id, 'homeroom_teacher_id' => $student->room->wali_kelas_id, 'status' => 'Draft']
                );

                $detail = ReportCardDetail::updateOrCreate(
                    ['report_card_id' => $reportCard->id, 'subject_id' => $learning->subject_id],
                    [
                        'nilai_akhir' => $request->nilai_akhir[$student->id] ?? null,
                    ]
                );

                // --- BLOK LOGIKA BARU UNTUK DESKRIPSI & PREDIKAT DINAMIS ---
                $finalDescription = null;

                // Ambil nilai pengetahuan untuk menentukan predikat
                $score = (float) ($request->nilai_akhir[$student->id] ?? 0);

                // 1. Tentukan Predikat dan Kalimat Pembuka
                if ($score >= 86) {
                    $openingPhrase = 'Menunjukkan penguasaan yang sangat baik';
                } elseif ($score >= 76) {
                    $openingPhrase = 'Menunjukkan penguasaan yang baik';
                } elseif ($score >= 66) {
                    $openingPhrase = 'Menunjukkan pemahaman yang cukup';
                } else {
                    $openingPhrase = 'Perlu bimbingan lebih lanjut';
                }

                if ($request->has('capaian') && isset($request->capaian[$student->id])) {
                    $selectedTpIds = $request->capaian[$student->id];
                    $detail->learningObjectives()->sync($selectedTpIds);

                    // Ambil deskripsi dari TP yang dipilih
                    $descriptions = LearningObjective::whereIn('id', $selectedTpIds)->pluck('deskripsi')->toArray();

                    // Gabungkan kalimat pembuka dengan daftar TP
                    $finalDescription = $openingPhrase . ' dalam ' . implode(', ', $descriptions) . '.';
                } else {
                    // Jika tidak ada TP yang dipilih, sync array kosong dan buat kalimat generik
                    $detail->learningObjectives()->sync([]);
                    $finalDescription = $openingPhrase . ' pada sebagian besar kompetensi mata pelajaran.';
                }

                // 3. Simpan deskripsi DAN predikat yang sudah dibuat
                $detail->update([
                    'deskripsi_capaian' => $finalDescription,
                ]);
            }
        });

        toast('Nilai akhir mata pelajaran berhasil disimpan!', 'success');
        return redirect()->route('mapel-diampu');
    }
}
