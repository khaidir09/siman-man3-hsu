<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Student;
use App\Models\HealthCare;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\KesehatanNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class KesehatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data kesehatan
        $kesehatan = HealthCare::with('student')->latest()->get(); // Gunakan eager loading untuk efisiensi
        // Mengarahkan ke view kesehatan.index
        return view('kesehatan.index', compact('kesehatan'));
    }

    public function cetakKesehatan(Request $request)
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
        $kesehatan = HealthCare::with(['student'])
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
            'kesehatan' => $kesehatan,
            'kepala_madrasah' => $kepalaMadrasah,
            'periode' => $periodeFormatted,
            'tanggal_cetak' => $tanggalCetakFormatted,
            'judul_laporan' => "Laporan UKS - " . $periodeFormatted,
        ];

        // 4. Render view ke dalam PDF menggunakan Dompdf
        $pdf = Pdf::loadView('kesehatan.cetak', $data);

        // 5. Atur orientasi kertas (opsional, default portrait)
        $pdf->setPaper('a4', 'landscape');

        // 6. Tampilkan PDF di browser (stream) atau download
        return $pdf->stream('laporan-uks-' . $validated['bulan'] . '.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswa = Student::where('status', 'Aktif')->get();
        return view('kesehatan.create', compact('siswa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data sesuai skema tabel health_cares
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'keluhan' => 'required|string|max:255',
            'orang_tua' => 'required|string|max:255',
            'alamat' => 'required|string',
            'hasil_pemeriksaan' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $siswa = Student::with('user')->findOrFail($request->input('student_id'));

        // Membuat record baru menggunakan model HealthCare
        $newHealthCare = HealthCare::create([
            'student_id' => $request->input('student_id'),
            'nama_siswa' => $siswa->nama_lengkap,
            'kelas' => $siswa->room->tingkat . ' ' . $siswa->room->rombongan . ' ' . $siswa->room->nama_jurusan,
            'keluhan' => $request->input('keluhan'),
            'orang_tua' => $request->input('orang_tua'),
            'alamat' => $request->input('alamat'),
            'hasil_pemeriksaan' => $request->input('hasil_pemeriksaan'),
            'tanggal' => $request->input('tanggal'),
        ]);

        if ($siswa->user && $siswa->user->email) {
            try {
                Mail::to($siswa->user->email)->send(new KesehatanNotification($newHealthCare));
            } catch (\Exception $e) {
                Log::error('Gagal mengirim email notifikasi UKS: ' . $e->getMessage());
            }
        }

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
        $siswa = Student::where('status', 'Aktif')->get();

        // Mengarahkan ke view kesehatan.edit dengan data yang relevan
        return view('kesehatan.edit', compact('kesehatan', 'siswa'));
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
            'student_id' => 'required|exists:students,id',
            'keluhan' => 'required|string|max:255',
            'orang_tua' => 'required|string|max:255',
            'alamat' => 'required|string',
            'hasil_pemeriksaan' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $siswa = Student::with('user')->findOrFail($request->input('student_id'));

        // Meng-update record
        $kesehatan->update([
            'student_id' => $request->input('student_id'),
            'nama_siswa' => $siswa->nama_lengkap,
            'kelas' => $siswa->room->tingkat . ' ' . $siswa->room->rombongan . ' ' . $siswa->room->nama_jurusan,
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
