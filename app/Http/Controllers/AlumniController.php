<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Room;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data alumni dengan relasinya untuk efisiensi (eager loading)
        $alumni = Alumni::with(['room', 'academicPeriod'])->latest()->get();
        return view('alumni.index', compact('alumni'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data yang diperlukan untuk form dropdown
        $rooms = Room::all();
        $academicPeriods = AcademicPeriod::all();
        return view('alumni.create', compact('rooms', 'academicPeriods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data sesuai skema tabel alumnis
        $validatedData = $request->validate([
            'no_induk' => 'required|string|max:255|unique:alumnis,no_induk',
            'nama_siswa' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'rooms_id' => 'required|exists:rooms,id',
            'tanggal_lahir' => 'required|date',
            'academic_periods_id' => 'required|exists:academic_periods,id',
            'melanjutkan' => 'required|string|max:255',
            'nama_tempat' => 'string|max:255',
        ]);

        // Buat record baru menggunakan model Alumni
        Alumni::create($validatedData);

        toast('Data Alumni berhasil dibuat.', 'success')->width('350');

        return redirect()->route('alumni.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumni $alumni)
    {
        // Bisa dikosongkan atau digunakan untuk halaman detail
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Menggunakan Route Model Binding untuk mengambil data alumni
        $rooms = Room::all();
        $academicPeriods = AcademicPeriod::all();
        $alumni = Alumni::findOrFail($id);

        return view('alumni.edit', compact('alumni', 'rooms', 'academicPeriods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $alumni = Alumni::findOrFail($id);

        $validatedData = $request->validate([
            'no_induk' => 'required|string|max:255|unique:alumnis,no_induk,' . $alumni->id,
            'nama_siswa' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'rooms_id' => 'required|exists:rooms,id',
            'tanggal_lahir' => 'required|date',
            'academic_periods_id' => 'required|exists:academic_periods,id',
            'melanjutkan' => 'required|string|max:255',
            'nama_tempat' => 'string|max:255',
        ]);

        // Update record alumni
        $alumni->update($validatedData);

        toast('Data Alumni berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('alumni.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $alumni = Alumni::findOrFail($id);
        try {
            // Hapus record dari database
            $alumni->delete();

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
