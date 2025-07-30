<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Room;
use App\Models\User;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\ExamScore;
use Illuminate\Http\Request;
use App\Models\AcademicPeriod;
use App\Mail\ExamScoreNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class NilaiUjianController extends Controller
{
    public function edit(Exam $exam)
    {
        // Eager load relasi untuk efisiensi dan mengambil data yang dibutuhkan
        $exam->load('learning.room.students', 'learning.subject');

        // Ambil semua siswa dari kelas yang terkait dengan ujian ini
        $students = $exam->learning->room->students;

        // Ambil nilai yang sudah ada untuk ujian ini.
        // pluck() akan membuat array asosiatif [student_id => score]
        // Ini berguna untuk mengisi kembali form jika nilai sudah pernah diinput.
        $existingScores = ExamScore::where('exam_id', $exam->id)
            ->pluck('score', 'student_id');

        return view('ujian.input-nilai', compact('exam', 'students', 'existingScores'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'nullable|numeric|min:0|max:100', // Validasi setiap nilai di dalam array
        ]);

        $students = Student::whereIn('id', array_keys($request->scores))->with('user')->get()->keyBy('id');

        foreach ($request->scores as $studentId => $score) {
            if (!is_null($score)) {
                // Simpan nilai dan dapatkan recordnya
                $savedScore = ExamScore::updateOrCreate(
                    ['exam_id' => $exam->id, 'student_id' => $studentId],
                    ['score' => $score]
                );

                $student = $students->get($studentId);

                if ($student && $student->user && $student->user->email) {
                    try {
                        Mail::to($student->user->email)->send(new ExamScoreNotification($savedScore));
                    } catch (\Exception $e) {
                        Log::error('Gagal mengirim email nilai ujian: ' . $e->getMessage());
                    }
                }
            }
        }

        toast('Nilai ujian berhasil disimpan.', 'success');
        return redirect()->route('ujian.index');
    }
}
