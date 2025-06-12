<?php

namespace App\Http\Controllers;

use App\Models\CounselingGuidance;
use App\Models\Room;
use Illuminate\Http\Request;

class KonselingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guidances = CounselingGuidance::all();
        return view('konseling.index', compact('guidances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::all();
        return view('konseling.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'tanggal' => 'required|date',
            'nama_siswa' => 'required|string|max:255',
            'rooms_id' => 'required|exists:rooms,id',
            'uraian_masalah' => 'required',
            'pemecahan_masalah' => 'required',
        ]);

        // Create a new guidance
        CounselingGuidance::create([
            'tanggal' => $request->input('tanggal'),
            'nama_siswa' => $request->input('nama_siswa'),
            'rooms_id' => $request->input('rooms_id'),
            'uraian_masalah' => $request->input('uraian_masalah'),
            'pemecahan_masalah' => $request->input('pemecahan_masalah'),
            'is_pribadi' => $request->input('is_pribadi') == 1 ? 1 : 0,
            'is_sosial' => $request->input('is_sosial') == 1 ? 1 : 0,
            'is_belajar' => $request->input('is_belajar') == 1 ? 1 : 0,
            'is_karir' => $request->input('is_karir') == 1 ? 1 : 0,
        ]);

        toast('Data Pelanggaran Kedisiplinan berhasil dibuat.', 'success')->width('350');

        return redirect()->route('konseling.index');
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
        $konseling = CounselingGuidance::findOrFail($id);
        $rooms = Room::all();

        return view('konseling.edit', compact('konseling', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $guidance = CounselingGuidance::findOrFail($id);

        // Validate the request data
        $request->validate([
            'tanggal' => 'required|date',
            'nama_siswa' => 'required|string|max:255',
            'rooms_id' => 'required|exists:rooms,id',
            'uraian_masalah' => 'required',
            'pemecahan_masalah' => 'required',
        ]);

        // Create a new guidance
        $guidance->update([
            'tanggal' => $request->input('tanggal'),
            'nama_siswa' => $request->input('nama_siswa'),
            'rooms_id' => $request->input('rooms_id'),
            'uraian_masalah' => $request->input('uraian_masalah'),
            'pemecahan_masalah' => $request->input('pemecahan_masalah'),
            'is_pribadi' => $request->input('is_pribadi') == 1 ? 1 : 0,
            'is_sosial' => $request->input('is_sosial') == 1 ? 1 : 0,
            'is_belajar' => $request->input('is_belajar') == 1 ? 1 : 0,
            'is_karir' => $request->input('is_karir') == 1 ? 1 : 0,
        ]);

        toast('Data Pelanggaran Kedisiplinan berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('konseling.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guidance = CounselingGuidance::findOrFail($id);

        try {
            // Hapus record dari database
            $guidance->delete();

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
