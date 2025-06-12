<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\LateArrival;
use Illuminate\Http\Request;

class KedisiplinanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $arrivals = LateArrival::all();
        return view('terlambat.index', compact('arrivals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::all();
        return view('terlambat.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'guru_piket' => 'required|string|max:255',
            'rooms_id' => 'required|exists:rooms,id',
            'tanggal' => 'required|date',
            'waktu_datang' => 'required|date_format:H:i',
        ]);

        // Create a new LateArrival
        LateArrival::create([
            'nama_siswa' => $request->input('nama_siswa'),
            'guru_piket' => $request->input('guru_piket'),
            'rooms_id' => $request->input('rooms_id'),
            'tanggal' => $request->input('tanggal'),
            'waktu_datang' => $request->input('waktu_datang'),
        ]);

        toast('Data Pelanggaran Kedisiplinan berhasil dibuat.', 'success')->width('350');

        return redirect()->route('terlambat.index');
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
        $terlambat = LateArrival::findOrFail($id);
        $rooms = Room::all();

        return view('terlambat.edit', compact('terlambat', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $LateArrival = LateArrival::findOrFail($id);

        // Validate the request data
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'guru_piket' => 'required|string|max:255',
            'rooms_id' => 'required|exists:rooms,id',
            'tanggal' => 'required|date',
            'waktu_datang' => 'required|date_format:H:i',
        ]);

        // Create a new LateArrival
        $LateArrival->update([
            'nama_siswa' => $request->input('nama_siswa'),
            'guru_piket' => $request->input('guru_piket'),
            'rooms_id' => $request->input('rooms_id'),
            'tanggal' => $request->input('tanggal'),
            'waktu_datang' => $request->input('waktu_datang'),
        ]);

        toast('Data Pelanggaran Kedisiplinan berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('terlambat.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $LateArrival = LateArrival::findOrFail($id);

        try {
            // Hapus record dari database
            $LateArrival->delete();

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
