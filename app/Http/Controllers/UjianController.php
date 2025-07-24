<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Room;
use App\Models\User;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\AcademicPeriod;
use App\Mail\NewExamNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UjianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Exam::query();

        $user = Auth::user();

        if ($user->hasRole('guru')) {
            $query->where('teacher_id', $user->id);
        }

        $exams = $query->with(['subject', 'room', 'teacher'])
            ->orderBy('exam_date', 'desc')
            ->paginate(10);

        return view('ujian.index', compact('exams'));
    }

    /**
     * Menampilkan form untuk membuat data ujian baru.
     */
    public function create()
    {
        $user = Auth::user();
        $data = [];

        if ($user->hasRole('wakasek kurikulum')) {
            // Jika Wakasek, ambil semua data
            $data['subjects'] = Subject::orderBy('nama_mapel', 'asc')->get();
            $data['rooms'] = Room::orderBy('tingkat', 'asc')->get();
            $data['teachers'] = User::whereHas('roles', fn($q) => $q->where('name', 'guru'))->orderBy('name', 'asc')->get();
        } elseif ($user->hasRole('guru')) {
            // Jika Guru, ambil data yang berelasi dengannya saja
            $teacherId = $user->id;

            // Ambil ID mata pelajaran unik yang diajar oleh guru ini dari jadwal
            $subjectIds = Schedule::where('user_id', $teacherId)->distinct()->pluck('subject_id');
            $data['subjects'] = Subject::whereIn('id', $subjectIds)->orderBy('nama_mapel', 'asc')->get();

            // Ambil ID kelas unik yang diajar oleh guru ini dari jadwal
            $roomIds = Schedule::where('user_id', $teacherId)->distinct()->pluck('room_id');
            $data['rooms'] = Room::whereIn('id', $roomIds)->orderBy('tingkat', 'asc')->get();

            // Untuk guru, tidak perlu daftar guru lain
            $data['teachers'] = null;
        }

        // Data periode ajaran sama untuk semua peran
        $data['academicPeriods'] = AcademicPeriod::all();

        return view('ujian.create', $data);
    }

    /**
     * Menyimpan data ujian baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'room_id' => 'required|exists:rooms,id',
            'teacher_id' => 'required|exists:users,id',
            'exam_date' => 'required|date',
            'academic_period_id' => 'required|exists:academic_periods,id',
        ]);

        // Buat record baru
        $newExam = Exam::create($validated);

        try {
            // 1. Ambil semua siswa yang berada di kelas yang sama dengan ujian
            // Gunakan `with('user')` untuk eager loading agar efisien
            $students = Student::where('room_id', $newExam->room_id)->with('user')->get();

            // 2. Looping melalui setiap siswa untuk mengirim email
            foreach ($students as $student) {
                // Pastikan siswa memiliki akun user dan email yang valid
                if ($student->user && $student->user->email) {
                    Mail::to($student->user->email)->send(new NewExamNotification($newExam));
                }
            }
        } catch (\Exception $e) {
            // Opsional: Catat error jika email gagal terkirim tanpa menghentikan proses
            Log::error('Gagal mengirim notifikasi ujian baru: ' . $e->getMessage());
        }


        toast('Data ujian berhasil dibuat.', 'success');
        return redirect()->route('ujian.index');
    }

    /**
     * Menampilkan detail satu data ujian.
     * (Method ini opsional, seringkali pengguna langsung ke 'edit')
     */
    public function show(Exam $ujian)
    {
        // 'ujian' otomatis diambil dari database berkat Route Model Binding
        return view('ujian.show', compact('ujian'));
    }

    /**
     * Menampilkan form untuk mengedit data ujian.
     */
    public function edit(Exam $ujian)
    {
        $user = Auth::user();

        // --- Langkah 1: Otorisasi Keamanan ---
        // Jika user adalah guru, cek apakah dia pemilik ujian ini.
        // Jika bukan, hentikan proses dan tampilkan error 403 (Forbidden).
        if ($user->hasRole('guru') && $ujian->teacher_id !== $user->id) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        // --- Langkah 2: Menyiapkan Data untuk Form ---
        $data = ['ujian' => $ujian]; // Sertakan data ujian yang akan diedit

        if ($user->hasRole('wakasek kurikulum')) {
            // Jika Wakasek, ambil semua data
            $data['subjects'] = Subject::orderBy('nama_mapel', 'asc')->get();
            $data['rooms'] = Room::orderBy('tingkat', 'asc')->get();
            $data['teachers'] = User::whereHas('roles', fn($q) => $q->where('name', 'guru'))->orderBy('name', 'asc')->get();
        } elseif ($user->hasRole('guru')) {
            // Jika Guru, ambil data yang berelasi dengannya saja
            $teacherId = $user->id;

            $subjectIds = Schedule::where('user_id', $teacherId)->distinct()->pluck('subject_id');
            $data['subjects'] = Subject::whereIn('id', $subjectIds)->orderBy('nama_mapel', 'asc')->get();

            $roomIds = Schedule::where('user_id', $teacherId)->distinct()->pluck('room_id');
            $data['rooms'] = Room::whereIn('id', $roomIds)->orderBy('tingkat', 'asc')->get();
        }

        // Data periode ajaran sama untuk semua peran
        $data['academicPeriods'] = AcademicPeriod::all();

        return view('ujian.edit', $data);
    }

    /**
     * Memperbarui data ujian di database.
     */
    public function update(Request $request, Exam $ujian)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'room_id' => 'required|exists:rooms,id',
            'teacher_id' => 'required|exists:users,id',
            'exam_date' => 'required|date',
            'academic_period_id' => 'required|exists:academic_periods,id',
        ]);

        // Update record yang ada
        $ujian->update($validated);

        toast('Data ujian berhasil diperbarui.', 'success');
        return redirect()->route('ujian.index');
    }

    /**
     * Menghapus data ujian dari database.
     */
    public function destroy(Exam $ujian)
    {
        // Hapus record
        $ujian->delete();

        // Karena di migration kita menggunakan cascadeOnDelete(), 
        // semua nilai (exam_scores) yang terkait dengan ujian ini akan ikut terhapus otomatis.

        toast('Data ujian berhasil dihapus.', 'success');
        return redirect()->route('ujian.index');
    }
}
