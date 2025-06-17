<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Major;
use Illuminate\Http\Request;
use App\Models\AcademicPeriod;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\AcademicAchievement;

class PrestasiAkademikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $academic_achievements = AcademicAchievement::all();
        $academicPeriods = AcademicPeriod::latest()->get();
        return view('prestasi-akademik.index', compact('academic_achievements', 'academicPeriods'));
    }

    public function cetakPrestasiAkademik(Request $request)
    {
        $imagePath = public_path('images/kemenag.png');

        // 1. Validasi input dari form modal
        $request->validate([
            'academic_periods_id' => 'required',
            'nomor_surat' => 'required|string|max:255',
            'waktu_rapat' => 'required|date',
            'ditetapkan_tanggal' => 'required|date',
        ]);

        // 2. Ambil semua data yang diperlukan untuk laporan
        $academicPeriod = AcademicPeriod::findOrFail($request->academic_periods_id);

        // Asumsi model prestasi Anda bernama AcademicAchievement
        $prestasi = AcademicAchievement::with(['room.major'])
            ->where('academic_periods_id', $request->academic_periods_id)
            ->get();

        // Ambil data kepala madrasah
        $kepalaMadrasah = User::role('kepala madrasah')->first();

        // Format tanggal agar sesuai dengan bahasa Indonesia
        $tanggalRapatFormatted = Carbon::parse($request->waktu_rapat)->locale('id')->translatedFormat('l, d F Y');
        $tanggalDitetapkanFormatted = Carbon::parse($request->ditetapkan_tanggal)->locale('id')->translatedFormat('d F Y');

        // 3. Kumpulkan semua data untuk dikirim ke view
        $data = [
            'imagePath' => $imagePath,
            'prestasi' => $prestasi,
            'kepala_madrasah' => $kepalaMadrasah,
            'academic_period' => $academicPeriod,
            'nomor_surat' => $request->nomor_surat,
            'tanggal_rapat' => $tanggalRapatFormatted,
            'tanggal_ditetapkan' => $tanggalDitetapkanFormatted,
            'judul_laporan' => "Laporan Prestasi Akademik " . $academicPeriod->tahun_ajaran,
        ];

        // 4. Render view ke dalam PDF menggunakan Dompdf
        $pdf = Pdf::loadView('prestasi-akademik.cetak', $data);

        // 5. Atur orientasi kertas (opsional, default portrait)
        $pdf->setPaper('a4', 'portrait');

        // 6. Tampilkan PDF di browser (stream) atau download
        return $pdf->stream('laporan-prestasi-akademik-' . $academicPeriod->tahun_ajaran . '.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::all();
        $periods = AcademicPeriod::all();
        return view('prestasi-akademik.create', compact('rooms', 'periods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'nisn' => 'required|numeric|digits:10|unique:academic_achievements,nisn',
            'nama' => 'required|string|max:255',
            'ortu' => 'required|string|max:255',
            'jumlah_nilai' => 'required|string|max:255',
            'rata_rata' => 'required|decimal:0,2',
            'ranking' => 'required|string|max:255',
            'rooms_id' => 'required|exists:rooms,id',
            'academic_periods_id' => 'required|exists:academic_periods,id'
        ]);

        // Create a new major
        AcademicAchievement::create([
            'nisn' => $request->input('nisn'),
            'nama' => $request->input('nama'),
            'ortu' => $request->input('ortu'),
            'jumlah_nilai' => $request->input('jumlah_nilai'),
            'rata_rata' => $request->input('rata_rata'),
            'ranking' => $request->input('ranking'),
            'rooms_id' => $request->input('rooms_id'),
            'academic_periods_id' => $request->input('academic_periods_id'),
        ]);

        toast('Prestasi Akademik berhasil dibuat.', 'success')->width('350');

        return redirect()->route('prestasi-akademik.index');
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
        $prestasi = AcademicAchievement::findOrFail($id);

        $rooms = Room::all();
        $periods = AcademicPeriod::all();

        return view('prestasi-akademik.edit', compact('prestasi', 'rooms', 'periods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $prestasi = AcademicAchievement::findOrFail($id);

        // Validate the request data
        $request->validate([
            'nisn' => 'required|numeric|digits:10|unique:academic_achievements,nisn,' . $prestasi->id,
            'nama' => 'required|string|max:255',
            'ortu' => 'required|string|max:255',
            'jumlah_nilai' => 'required|string|max:255',
            'rata_rata' => 'required|decimal:0,2',
            'ranking' => 'required|string|max:255',
            'rooms_id' => 'required|exists:rooms,id',
            'academic_periods_id' => 'required|exists:academic_periods,id'
        ]);

        // Create a new major
        $prestasi->update([
            'nisn' => $request->input('nisn'),
            'nama' => $request->input('nama'),
            'ortu' => $request->input('ortu'),
            'jumlah_nilai' => $request->input('jumlah_nilai'),
            'rata_rata' => $request->input('rata_rata'),
            'ranking' => $request->input('ranking'),
            'rooms_id' => $request->input('rooms_id'),
            'academic_periods_id' => $request->input('academic_periods_id'),
        ]);

        toast('Prestasi Akademik berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('prestasi-akademik.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prestasi = AcademicAchievement::findOrFail($id);

        try {
            // Hapus record dari database
            $prestasi->delete();

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
