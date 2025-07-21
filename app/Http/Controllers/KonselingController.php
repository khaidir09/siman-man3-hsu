<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CounselingGuidance;
use App\Mail\KonselingNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

    public function cetakKonseling(Request $request)
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
        $konseling = CounselingGuidance::with(['student'])
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->orderBy('tanggal', 'asc')
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
            'konseling' => $konseling,
            'kepala_madrasah' => $kepalaMadrasah,
            'periode' => $periodeFormatted,
            'tanggal_cetak' => $tanggalCetakFormatted,
            'judul_laporan' => "Laporan Bimbingan Konseling - " . $periodeFormatted,
        ];

        // 4. Render view ke dalam PDF menggunakan Dompdf
        $pdf = Pdf::loadView('konseling.cetak', $data);

        // 5. Atur orientasi kertas (opsional, default portrait)
        $pdf->setPaper('a4', 'portrait');

        // 6. Tampilkan PDF di browser (stream) atau download
        return $pdf->stream('laporan-konseling-' . $validated['bulan'] . '.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswa = Student::where('status', 'Aktif')->get();
        return view('konseling.create', compact('siswa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'tanggal' => 'required|date',
            'student_id' => 'required|exists:students,id',
            'uraian_masalah' => 'required',
            'pemecahan_masalah' => 'required',
        ]);

        $siswa = Student::with('user')->findOrFail($request->input('student_id'));

        // Create a new guidance
        $counseling = CounselingGuidance::create([
            'tanggal' => $request->input('tanggal'),
            'student_id' => $request->input('student_id'),
            'nama_siswa' => $siswa->nama_lengkap,
            'kelas' => $siswa->room->tingkat . ' ' . $siswa->room->rombongan . ' ' . $siswa->room->nama_jurusan,
            'uraian_masalah' => $request->input('uraian_masalah'),
            'pemecahan_masalah' => $request->input('pemecahan_masalah'),
            'is_pribadi' => $request->input('is_pribadi') == 1 ? 1 : 0,
            'is_sosial' => $request->input('is_sosial') == 1 ? 1 : 0,
            'is_belajar' => $request->input('is_belajar') == 1 ? 1 : 0,
            'is_karir' => $request->input('is_karir') == 1 ? 1 : 0,
        ]);

        try {
            if ($siswa->user && $siswa->user->email) {
                Mail::to($siswa->user->email)->send(new KonselingNotification($counseling));
            }
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email notifikasi konseling: ' . $e->getMessage());
        }

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
        $siswa = Student::where('status', 'Aktif')->get();

        return view('konseling.edit', compact('konseling', 'siswa'));
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
            'student_id' => 'required|exists:students,id',
            'uraian_masalah' => 'required',
            'pemecahan_masalah' => 'required',
        ]);

        $siswa = Student::with('user')->findOrFail($request->input('student_id'));

        // Create a new guidance
        $guidance->update([
            'tanggal' => $request->input('tanggal'),
            'student_id' => $request->input('student_id'),
            'nama_siswa' => $siswa->nama_lengkap,
            'kelas' => $siswa->room->tingkat . ' ' . $siswa->room->rombongan . ' ' . $siswa->room->nama_jurusan,
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
