<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\TimeSlot;
use App\Models\Time_slot;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WaktuMapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $time_slots = TimeSlot::orderBy('jam_ke')->get();
        return view('waktu-mapel.index', compact('time_slots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('waktu-mapel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $validatedData = $request->validate([
            'jam_ke' => 'required|integer|unique:time_slots,jam_ke',
            'waktu_mulai' => 'required|date_format:H:i',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // 2. Ambil waktu mulai dari data yang sudah divalidasi
        $waktuMulai = $validatedData['waktu_mulai'];

        // 3. Hitung waktu selesai
        // Menggunakan Carbon untuk menambah 42 menit dari waktu mulai
        $waktuSelesai = Carbon::createFromFormat('H:i', $waktuMulai)
            ->addMinutes(42)
            ->format('H:i:s');

        // 4. Simpan data ke database
        TimeSlot::create([
            'jam_ke' => $validatedData['jam_ke'],
            'waktu_mulai' => $waktuMulai,
            'waktu_selesai' => $waktuSelesai, // Simpan hasil kalkulasi
            'keterangan' => $validatedData['keterangan'],
        ]);

        toast('Data Jam Pelajaran berhasil dibuat.', 'success')->width('350');

        return redirect()->route('waktu-mapel.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TimeSlot $time_slot)
    {
        // Biasanya tidak digunakan untuk data master sederhana
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $time_slot = TimeSlot::findOrFail($id);
        return view('waktu-mapel.edit', compact('time_slot'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $time_slot = TimeSlot::findOrFail($id);
        // 1. Validasi input dari form
        $validatedData = $request->validate([
            // 'jam_ke' divalidasi unik, namun mengabaikan record yang sedang diedit
            'jam_ke' => 'required|integer|unique:time_slots,jam_ke,' . $time_slot->id,
            'waktu_mulai' => 'required|date_format:H:i',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // 2. Ambil waktu mulai dari data yang sudah divalidasi
        $waktuMulai = $validatedData['waktu_mulai'];

        // 3. Hitung ulang waktu selesai
        $waktuSelesai = Carbon::createFromFormat('H:i', $waktuMulai)
            ->addMinutes(42)
            ->format('H:i:s');

        // 4. Update data di database
        $time_slot->update([
            'jam_ke' => $validatedData['jam_ke'],
            'waktu_mulai' => $waktuMulai,
            'waktu_selesai' => $waktuSelesai,
            'keterangan' => $validatedData['keterangan'],
        ]);

        toast('Data Jam Pelajaran berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('waktu-mapel.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $time_slot = TimeSlot::findOrFail($id);

        try {
            if ($time_slot->schedules()->exists()) {
                toast('Jam pelajaran tidak dapat dihapus karena masih digunakan di jadwal.', 'error')->width('450');
                return redirect()->back();
            }

            // Hapus record dari database
            $time_slot->delete();

            // Kembalikan respons dalam format JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Data Jam Pelajaran Berhasil Dihapus!'
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
