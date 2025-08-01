<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Mail\NewExamNotification;
use App\Models\Learning;
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
        $user = Auth::user();
        $query = Exam::query()->with('learning.subject', 'learning.room');

        if ($user->hasRole('guru')) {
            // Filter ujian berdasarkan user_id di dalam relasi learning
            $query->whereHas('learning', fn($q) => $q->where('user_id', $user->id));
        }

        $exams = $query->latest()->paginate(10);

        return view('ujian.index', compact('exams'));
    }

    /**
     * Menampilkan form untuk membuat data ujian baru.
     */
    public function create()
    {
        $user = Auth::user();
        $learnings = collect();

        if ($user->hasRole('wakamad kurikulum')) {
            $learnings = Learning::with(['subject', 'room', 'user'])->get();
        } elseif ($user->hasRole('guru')) {
            $learnings = Learning::where('user_id', $user->id)->with(['subject', 'room'])->get();
        }

        return view('ujian.create', compact('learnings'));
    }

    /**
     * Menyimpan data ujian baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'learning_id' => 'required|exists:learnings,id',
            'exam_date' => 'required|date',
        ]);

        // Buat record baru
        $newExam = Exam::create($validated);

        try {
            // 1. Ambil semua siswa yang berada di kelas yang sama dengan ujian
            // Gunakan `with('user')` untuk eager loading agar efisien
            $students = Student::where('room_id', $newExam->learning->room_id)->with('user')->get();

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
        $data = [];

        $pembelajaranQuery = Learning::with('subject', 'user', 'room', 'academicPeriod');

        // --- Langkah 1: Otorisasi Keamanan ---
        // Jika user adalah guru, cek apakah dia pemilik ujian ini.
        // Jika bukan, hentikan proses dan tampilkan error 403 (Forbidden).
        if ($user->hasRole('guru') && $ujian->learning->user_id !== $user->id) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        // --- Langkah 2: Menyiapkan Data untuk Form ---
        $data = ['ujian' => $ujian]; // Sertakan data ujian yang akan diedit

        if ($user->hasRole('wakasek kurikulum')) {
            // Jika Wakasek, ambil semua data
            $data['learnings'] = $pembelajaranQuery->get();
        } elseif ($user->hasRole('guru')) {
            // Jika Guru, ambil hanya data pembelajaran yang berelasi dengan ID guru tersebut.
            $data['learnings'] = $pembelajaranQuery->where('user_id', $user->id)->get();
        } else {
            // Default jika user tidak memiliki peran yang sesuai, kembalikan array kosong.
            $data['learnings'] = [];
        }

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
            'learning_id' => 'required|exists:learnings,id',
            'exam_date' => 'required|date',
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
