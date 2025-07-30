<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AcademicPeriod;
use App\Models\Extracurricular;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\NilaiEkskulNotification;
use App\Models\Learning;
use App\Models\Room;
use App\Models\Subject;
use App\Models\User;

class PembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data dengan relasi untuk efisiensi (eager loading)
        $learnings = Learning::with(['room', 'user', 'subject', 'academicPeriod'])->latest()->get();
        $academicPeriods = AcademicPeriod::all();
        return view('pembelajaran.index', compact('learnings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = User::whereHas('roles', function ($query) {
            $query->where('name', 'guru');
        })->get();
        $academicPeriods = AcademicPeriod::all();
        $rooms = Room::all();
        $subjects = Subject::all();

        return view('pembelajaran.create', compact('teachers', 'academicPeriods', 'rooms', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data sesuai skema
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
        ]);

        // Buat record baru
        Learning::create($validatedData);

        toast('Data Pembelajaran berhasil dibuat.', 'success')->width('350');

        return redirect()->route('pembelajaran.index');
    }

    /**
     * Display the specified resource.
     * (Halaman ini bisa dikembangkan untuk menampilkan detail anggota dan prestasi)
     */
    public function show()
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Extracurricular $ekstrakurikuler)
    {
        $teachers = User::whereHas('roles', function ($query) {
            $query->where('name', 'guru');
        })->get();
        $academicPeriods = AcademicPeriod::all();
        $rooms = Room::all();
        $subjects = Subject::all();

        return view('pembelajaran.edit', compact('teachers', 'academicPeriods', 'rooms', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Learning $pembelajaran)
    {
        // Validasi data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
        ]);

        // Update record
        $pembelajaran->update($validatedData);

        toast('Data Pembelajaran berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('pembelajaran.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pembelajaran = Learning::findOrFail($id);

        try {
            // Hapus record dari database
            $pembelajaran->delete();

            // Kembalikan respons dalam format JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Data Pembelajaran Berhasil Dihapus!'
            ]);
        } catch (\Exception $e) {
            // Jika terjadi error saat menghapus, kirim respons error
            // Log::error($e); // Opsional: catat error ke log
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus data. Terjadi kesalahan.'
            ], 500); // 500 = Internal Server Error
        }
    }
}
