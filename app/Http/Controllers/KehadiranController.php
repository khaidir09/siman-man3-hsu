<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function cetakKehadiran(Request $request)
    {
        $imagePath = public_path('images/kemenag.png');
        // 1. Validasi input dari form modal
        $validated = $request->validate([
            // Memastikan input 'month' ada dan formatnya YYYY-MM (misal: 2024-10)
            'bulan' => 'required|date_format:Y-m',
        ]);

        // 2. Ambil tahun dan bulan dari input
        $year = Carbon::createFromFormat('Y-m', $validated['bulan'])->year;
        $month = Carbon::createFromFormat('Y-m', $validated['bulan'])->month;

        // 3. Ambil semua data yang diperlukan untuk laporan

        // Ganti 'BimbinganKonseling' dengan nama model Anda yang sebenarnya
        $kehadiran = Attendance::with(['room'])
            ->whereYear('bulan', $year)
            ->whereMonth('bulan', $month)
            ->orderBy('rooms_id', 'asc')
            ->get();

        // Ambil data kepala madrasah
        $kepalaMadrasah = User::role('kepala madrasah')->first();

        // Format periode laporan (contoh: OKTOBER 2024)
        $periodeFormatted = strtoupper(Carbon::createFromFormat('Y-m', $validated['bulan'])->locale('id')->translatedFormat('F Y'));

        // Format tanggal cetak (tanggal hari ini)
        $tanggalCetakFormatted = Carbon::now()->locale('id')->translatedFormat('d F Y');

        // 4. Kumpulkan semua data untuk dikirim ke view
        $data = [
            'imagePath' => $imagePath,
            'kehadiran' => $kehadiran,
            'kepala_madrasah' => $kepalaMadrasah,
            'periode' => $periodeFormatted,
            'tanggal_cetak' => $tanggalCetakFormatted,
            'judul_laporan' => "Laporan Kehadiran Siswa - " . $periodeFormatted,
        ];

        // 4. Render view ke dalam PDF menggunakan Dompdf
        $pdf = Pdf::loadView('kehadiran.cetak', $data);

        // 5. Atur orientasi kertas (opsional, default portrait)
        $pdf->setPaper('a4', 'landscape');

        // 6. Tampilkan PDF di browser (stream) atau download
        return $pdf->stream('laporan-kehadiran-' . $validated['bulan'] . '.pdf');
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
