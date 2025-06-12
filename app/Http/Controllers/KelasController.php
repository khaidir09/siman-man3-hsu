<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\Room;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all rooms
        $rooms = Room::with('major')->get();

        // Return the view with rooms data
        return view('kelas.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $majors = Major::all();
        return view('kelas.create', compact('majors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'tingkat' => 'required|string|max:255',
            'rombongan' => 'required|string|max:255',
            'majors_id' => 'nullable'
        ]);

        $namaJurusan = Major::find($request->input('majors_id'));


        // Create a new major
        Room::create([
            'tingkat' => $request->input('tingkat'),
            'rombongan' => $request->input('rombongan'),
            'majors_id' => $request->input('majors_id'),
            'nama_jurusan' => $namaJurusan ? $namaJurusan->nama_jurusan : null,
        ]);

        toast('Kelas berhasil dibuat.', 'success')->width('350');

        return redirect()->route('kelas.index');
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
        $room = Room::findOrFail($id);
        $majors = Major::all();

        return view('kelas.edit', compact('room', 'majors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $room = Room::findOrFail($id);

        // Validate the request data
        $request->validate([
            'tingkat' => 'required|string|max:255',
            'rombongan' => 'required|string|max:255',
            'majors_id' => 'nullable'
        ]);

        // Create a new major
        $room->update([
            'tingkat' => $request->input('tingkat'),
            'rombongan' => $request->input('rombongan'),
            'majors_id' => $request->input('majors_id'),
        ]);

        toast('Kelas berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('kelas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);

        try {
            // Hapus record dari database
            $room->delete();

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
