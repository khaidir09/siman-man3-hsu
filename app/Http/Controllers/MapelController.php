<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::orderBy('nama_mapel')->get();
        return view('mapel.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mapel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:subjects,nama_mapel',
            'kode_mapel' => 'nullable|string|max:20|unique:subjects,kode_mapel',
            'kelompok_mapel' => ['required', Rule::in(['A', 'B', 'C', 'D'])],
        ]);

        Subject::create($validatedData);

        toast('Data Mata Pelajaran berhasil dibuat.', 'success')->width('350');

        return redirect()->route('mapel.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        // Biasanya tidak digunakan untuk data master sederhana
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subject = Subject::findOrFail($id);
        return view('mapel.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subject = Subject::findOrFail($id);
        $validatedData = $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:subjects,nama_mapel,' . $subject->id,
            'kode_mapel' => 'nullable|string|max:20|unique:subjects,kode_mapel,' . $subject->id,
            'kelompok_mapel' => ['required', Rule::in(['A', 'B', 'C', 'D'])],
        ]);

        $subject->update($validatedData);

        toast('Data Mata Pelajaran berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('mapel.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = Subject::findOrFail($id);

        try {
            if ($subject->schedules()->exists()) {
                toast('Mata pelajaran tidak dapat dihapus karena masih digunakan di jadwal.', 'error')->width('450');
                return redirect()->back();
            }

            // Hapus record dari database
            $subject->delete();

            // Kembalikan respons dalam format JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Data Mata Pelajaran Berhasil Dihapus!'
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
