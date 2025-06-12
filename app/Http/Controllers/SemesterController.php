<?php

namespace App\Http\Controllers;

use App\Models\AcademicPeriod;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periods = AcademicPeriod::all();
        return view('semester.index', compact('periods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('semester.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'tahun_ajaran' => 'required|string|max:255',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        // Create a new period
        AcademicPeriod::create([
            'tahun_ajaran' => $request->input('tahun_ajaran'),
            'semester' => $request->input('semester'),
        ]);

        toast('Semester berhasil dibuat.', 'success')->width('350');

        return redirect()->route('semester.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $period = AcademicPeriod::findOrFail($id);

        return view('semester.edit', compact('period'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $period = AcademicPeriod::findOrFail($id);

        // Validate the request data
        $request->validate([
            'tahun_ajaran' => 'required|string|max:255',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        // Create a new period
        $period->update([
            'tahun_ajaran' => $request->input('tahun_ajaran'),
            'semester' => $request->input('semester'),
        ]);

        toast('Semester berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('semester.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $period = AcademicPeriod::findOrFail($id);

        try {
            // Hapus record dari database
            $period->delete();

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
