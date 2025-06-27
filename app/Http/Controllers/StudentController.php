<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data siswa dengan relasi kelasnya (eager loading)
        $students = Student::with('room.major')->latest()->get();
        return view('siswa.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data kelas untuk dropdown
        $rooms = Room::all();
        return view('siswa.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data berdasarkan skema tabel students
        $validatedData = $request->validate([
            'nisn' => 'required|string|max:50|unique:students,nisn',
            'nama_lengkap' => 'required|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'status' => ['required', Rule::in(['Aktif', 'Lulus', 'Pindah', 'Dikeluarkan'])],
            // Tambahkan validasi untuk field lain dari migrasi komprehensif jika perlu
        ]);

        // Buat record siswa baru
        Student::create($validatedData);

        toast('Data Siswa berhasil dibuat.', 'success')->width('350');

        return redirect()->route('siswa.index');
    }

    /**
     * Display the specified resource.
     * (Halaman ini bisa menampilkan profil lengkap siswa, termasuk ekskul yang diikuti)
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $siswa)
    {
        // Menggunakan Route Model Binding
        $rooms = Room::all();
        return view('siswa.edit', compact('siswa', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $siswa)
    {
        // Validasi data (mirip dengan store, tapi unique diabaikan untuk record saat ini)
        $validatedData = $request->validate([
            'nisn' => 'required|string|max:50|unique:students,nisn,' . $siswa->id,
            'nama_lengkap' => 'required|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'status' => ['required', Rule::in(['Aktif', 'Lulus', 'Pindah', 'Dikeluarkan'])],
        ]);

        // Update record
        $siswa->update($validatedData);

        toast('Data Siswa berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('siswa.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);

        try {
            // Hapus record dari database
            $student->delete();

            // Kembalikan respons dalam format JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Data Kelas Berhasil Dihapus!'
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
