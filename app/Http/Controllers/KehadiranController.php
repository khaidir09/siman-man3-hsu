<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Attendance;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendances = Attendance::all();
        return view('kehadiran.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::all();
        return view('kehadiran.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'rooms_id' => 'required|exists:rooms,id',
            'izin' => 'required|integer|min:0',
            'sakit' => 'required|integer|min:0',
            'alpa' => 'required|integer|min:0',
            'hari_efektif' => 'required|integer|min:0',
            'jumlah_siswa' => 'required|integer|min:0',
        ]);

        // hitung jumlah absen
        $jumlahAbsen = $request->input('izin') + $request->input('sakit') + $request->input('alpa');

        $jumlahDiharapkan = $request->input('jumlah_siswa') * $request->input('hari_efektif');

        $jumlahAktual = $jumlahDiharapkan - $jumlahAbsen;

        $rataRata = 0.00;

        // hitung rata-rata kehadiran
        $rataRata = ($jumlahAktual / $jumlahDiharapkan) * 100;

        // Konversi format bulan dari YYYY-MM menjadi YYYY-MM-01
        $bulan = $request->input('bulan') . '-01';

        // Create a new Attendance
        Attendance::create([
            'rooms_id' => $request->input('rooms_id'),
            'bulan' => $bulan,
            'izin' => $request->input('izin'),
            'sakit' => $request->input('sakit'),
            'alpa' => $request->input('alpa'),
            'jumlah_absen' => $jumlahAbsen,
            'hari_efektif' => $request->input('hari_efektif'),
            'jumlah_siswa' => $request->input('jumlah_siswa'),
            'rata_rata' => $rataRata,
        ]);

        toast('Data Kehadiran berhasil dibuat.', 'success')->width('350');

        return redirect()->route('kehadiran.index');
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
        $kehadiran = Attendance::findOrFail($id);
        $rooms = Room::all();

        return view('kehadiran.edit', compact('kehadiran', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $Attendance = Attendance::findOrFail($id);

        // Validate the request data
        $request->validate([
            'rooms_id' => 'required|exists:rooms,id',
            'izin' => 'required|integer|min:0',
            'sakit' => 'required|integer|min:0',
            'alpa' => 'required|integer|min:0',
            'hari_efektif' => 'required|integer|min:0',
            'jumlah_siswa' => 'required|integer|min:0',
        ]);

        // hitung jumlah absen
        $jumlahAbsen = $request->input('izin') + $request->input('sakit') + $request->input('alpa');

        $jumlahDiharapkan = $request->input('jumlah_siswa') * $request->input('hari_efektif');

        $jumlahAktual = $jumlahDiharapkan - $jumlahAbsen;

        $rataRata = 0.00;

        // hitung rata-rata kehadiran
        $rataRata = ($jumlahAktual / $jumlahDiharapkan) * 100;

        // Konversi format bulan dari YYYY-MM menjadi YYYY-MM-01
        $bulan = $request->input('bulan') . '-01';

        // Create a new Attendance
        $Attendance->update([
            'rooms_id' => $request->input('rooms_id'),
            'bulan' => $bulan,
            'izin' => $request->input('izin'),
            'sakit' => $request->input('sakit'),
            'alpa' => $request->input('alpa'),
            'jumlah_absen' => $jumlahAbsen,
            'hari_efektif' => $request->input('hari_efektif'),
            'jumlah_siswa' => $request->input('jumlah_siswa'),
            'rata_rata' => $rataRata,
        ]);

        toast('Data Kehadiran berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('kehadiran.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Attendance = Attendance::findOrFail($id);

        try {
            // Hapus record dari database
            $Attendance->delete();

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
