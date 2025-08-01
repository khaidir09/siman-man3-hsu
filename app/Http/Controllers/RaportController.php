<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Student;
use App\Models\ReportCard;
use Illuminate\Http\Request;
use App\Models\AcademicPeriod;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ReportCardDetail;
use Illuminate\Support\Facades\Auth;

class RaportController extends Controller
{
    public function showClass()
    {
        $user = Auth::user();

        // 1. Asumsi periode ajaran yang aktif adalah yang sedang dikerjakan rapornya
        $active_period = AcademicPeriod::latest()->first();

        // Jika tidak ada periode aktif, hentikan
        if (!$active_period) {
            // Anda bisa menampilkan pesan error yang lebih baik di sini
            abort(404, 'Tidak ada periode ajaran yang aktif.');
        }

        // 2. Temukan kelas di mana user ini adalah wali kelasnya
        // Pastikan tabel 'rooms' memiliki kolom 'wali_kelas_id'
        $room = Room::where('wali_kelas_id', $user->id)->firstOrFail();

        // 3. Ambil semua siswa di kelas tersebut
        $students = $room->students;

        // 4. Ambil status rapor semua siswa di kelas ini untuk ditampilkan (efisien)
        $reportCards = ReportCard::where('academic_period_id', $active_period->id)
            ->whereIn('student_id', $students->pluck('id'))
            ->get()
            ->keyBy('student_id');

        return view('raport.kelas', compact('room', 'students', 'active_period', 'reportCards'));
    }

    public function process(Student $student, AcademicPeriod $period)
    {
        // 1. Ambil atau buat master rapor (status: Draft)
        // Ini memastikan selalu ada record rapor untuk dikelola
        $reportCard = ReportCard::firstOrCreate(
            ['student_id' => $student->id, 'academic_period_id' => $period->id],
            [
                'room_id' => $student->room_id,
                'homeroom_teacher_id' => Auth::id(), // ID Wali Kelas yang login
                'status' => 'Draft'
            ]
        );

        // 2. Ambil semua detail nilai yang sudah diinput oleh Guru Mata Pelajaran
        $details = ReportCardDetail::where('report_card_id', $reportCard->id)
            ->with(['learning.learningObjectives' => function ($query) use ($period) {
                $query->where('academic_period_id', $period->id);
            }, 'learningObjectives'])
            ->get();

        // 4. Agregasi Data Ekstrakurikuler
        $ekskul = $student->extracurriculars; // Asumsi relasi sudah ada

        return view('raport.proses', compact('student', 'reportCard', 'details', 'ekskul'));
    }

    public function finalize(Request $request, ReportCard $reportCard)
    {
        $validated = $request->validate([
            'homeroom_teacher_notes' => 'nullable|string',
            'sakit' => 'required|integer|min:0',
            'izin' => 'required|integer|min:0',
            'alfa' => 'required|integer|min:0',
        ]);

        // Update catatan dan ubah status menjadi Final
        $reportCard->update([
            'homeroom_teacher_notes' => $request->input('homeroom_teacher_notes'),
            'sakit' => $validated['sakit'],
            'izin' => $validated['izin'],
            'alfa' => $validated['alfa'],
            'status' => 'Final',
        ]);

        toast('Rapor berhasil difinalisasi!', 'success');
        return redirect()->route('rapor.kelas');
    }

    public function printPdf(ReportCard $reportCard)
    {
        $user = Auth::user();

        $imagePath = public_path('images/kemenag.png');

        // --- Otorisasi Keamanan ---
        // Cek apakah user adalah siswa pemilik rapor, atau wali kelas dari rapor tsb.
        $isOwner = ($user->hasRole('siswa') && $user->student->id == $reportCard->student_id);
        $isHomeroomTeacher = $user->id == $reportCard->homeroom_teacher_id;
        $isAdmin = ($user->hasRole('wakamad kurikulum') || $user->hasRole('kepala madrasah'));

        if (!$isOwner && !$isHomeroomTeacher && !$isAdmin) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        // Pastikan rapor sudah final sebelum dicetak (kecuali oleh admin)
        if ($reportCard->status !== 'Final' && !$isAdmin) {
            abort(403, 'Rapor belum difinalisasi oleh Wali Kelas.');
        }

        // --- Ambil Semua Data yang Diperlukan ---
        $reportCard->load([
            'student.user',
            'student.extracurriculars',
            'student.achievements.extracurricular',
            'room',
            'academicPeriod',
            'homeroomTeacher',
            'details.subject',
            'details.learningObjectives',
        ]);

        // --- Buat PDF ---
        $pdf = Pdf::loadView('raport.cetak', ['reportCard' => $reportCard], [
            'imagePath' => $imagePath,
        ]);

        // Tampilkan PDF di browser, bukan langsung download
        return $pdf->stream('Rapor - ' . $reportCard->student->nama_lengkap . ' - ' . $reportCard->academicPeriod->semester . ' - ' . $reportCard->academicPeriod->tahun_ajaran . '.pdf');
    }
}
