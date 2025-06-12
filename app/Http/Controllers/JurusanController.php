<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $majors = Major::all();
        return view('jurusan.index', compact('majors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jurusan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'nama_jurusan' => 'required|string|max:255|unique:majors,nama_jurusan',
            'singkatan' => 'required|string|max:255|unique:majors,singkatan',
        ]);

        // Create a new major
        Major::create([
            'nama_jurusan' => $request->input('nama_jurusan'),
            'singkatan' => $request->input('singkatan'),
        ]);

        toast('Jurusan berhasil dibuat.', 'success')->width('350');

        return redirect()->route('jurusan.index');
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
        $major = Major::findOrFail($id);

        return view('jurusan.edit', compact('major'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $major = Major::findOrFail($id);

        // Validate the request data
        $request->validate([
            'nama_jurusan' => 'required|string|max:255|unique:majors,nama_jurusan,' . $major->id,
            'singkatan' => 'required|string|max:255|unique:majors,singkatan,' . $major->id,
        ]);

        // Create a new major
        $major->update([
            'nama_jurusan' => $request->input('nama_jurusan'),
            'singkatan' => $request->input('singkatan'),
        ]);

        toast('Jurusan berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('jurusan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $major = Major::findOrFail($id);

        try {
            // Hapus record dari database
            $major->delete();

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
