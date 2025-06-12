<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\HealthCare;
use Illuminate\Http\Request;

class KesehatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data kesehatan
        $kesehatan = HealthCare::with('room')->latest()->get(); // Gunakan eager loading untuk efisiensi
        // Mengarahkan ke view kesehatan.index
        return view('kesehatan.index', compact('kesehatan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::all();
        // Mengarahkan ke view kesehatan.create
        return view('kesehatan.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data sesuai skema tabel health_cares
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'rooms_id' => 'required|exists:rooms,id',
            'keluhan' => 'required|string|max:255',
            'orang_tua' => 'required|string|max:255',
            'alamat' => 'required|string',
            'hasil_pemeriksaan' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        // Membuat record baru menggunakan model HealthCare
        HealthCare::create([
            'nama_siswa' => $request->input('nama_siswa'),
            'rooms_id' => $request->input('rooms_id'),
            'keluhan' => $request->input('keluhan'),
            'orang_tua' => $request->input('orang_tua'),
            'alamat' => $request->input('alamat'),
            'hasil_pemeriksaan' => $request->input('hasil_pemeriksaan'),
            'tanggal' => $request->input('tanggal'),
        ]);

        // Notifikasi Toast
        toast('Data Kesehatan berhasil dibuat.', 'success')->width('350');

        // Redirect ke route kesehatan.index
        return redirect()->route('kesehatan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Biasanya tidak digunakan untuk CRUD sederhana, bisa dikosongkan.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Mengambil data kesehatan spesifik berdasarkan ID
        $kesehatan = HealthCare::findOrFail($id);
        $rooms = Room::all();

        // Mengarahkan ke view kesehatan.edit dengan data yang relevan
        return view('kesehatan.edit', compact('kesehatan', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Mengambil data kesehatan yang akan di-update
        $kesehatan = HealthCare::findOrFail($id);

        // Validasi data (sama seperti di method store)
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'rooms_id' => 'required|exists:rooms,id',
            'keluhan' => 'required|string|max:255',
            'orang_tua' => 'required|string|max:255',
            'alamat' => 'required|string',
            'hasil_pemeriksaan' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        // Meng-update record
        $kesehatan->update([
            'nama_siswa' => $request->input('nama_siswa'),
            'rooms_id' => $request->input('rooms_id'),
            'keluhan' => $request->input('keluhan'),
            'orang_tua' => $request->input('orang_tua'),
            'alamat' => $request->input('alamat'),
            'hasil_pemeriksaan' => $request->input('hasil_pemeriksaan'),
            'tanggal' => $request->input('tanggal'),
        ]);

        // Notifikasi Toast
        toast('Data Kesehatan berhasil diperbarui.', 'success')->width('350');

        // Redirect ke route kesehatan.index
        return redirect()->route('kesehatan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Mengambil data kesehatan yang akan dihapus
        $kesehatan = HealthCare::findOrFail($id);

        try {
            // Hapus record dari database
            $kesehatan->delete();

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
