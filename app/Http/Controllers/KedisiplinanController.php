<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Student;
use App\Models\LateArrival;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PelanggaranKedisiplinanNotification;

class KedisiplinanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Dapatkan pengguna yang sedang login
        $user = Auth::user();

        // 2. Terapkan kondisi berdasarkan peran (role)
        if ($user->hasRole(['kepala madrasah', 'wakamad kesiswaan'])) {
            // Jika Kepala Madrasah atau Wakamad, tampilkan semua data
            $arrivals = LateArrival::with('room')->latest()->get();
        } elseif ($user->hasRole('guru')) {
            // Jika guru, tampilkan hanya data di mana nama 'guru_piket'
            // sama dengan nama pengguna yang login
            $arrivals = LateArrival::with('room')
                ->where('guru_piket', $user->name)
                ->latest()
                ->get();
        } else {
            // Untuk peran lain (jika ada), jangan tampilkan data apa pun
            $arrivals = collect(); // Membuat collection kosong
        }



        // 3. Kirim data yang sudah difilter ke view
        return view('terlambat.index', compact('arrivals'));
    }

    public function cetakKedisiplinan(Request $request)
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
        $kedisiplinan = LateArrival::with(['room'])
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
            'kedisiplinan' => $kedisiplinan,
            'kepala_madrasah' => $kepalaMadrasah,
            'periode' => $periodeFormatted,
            'tanggal_cetak' => $tanggalCetakFormatted,
            'judul_laporan' => "Laporan Pelanggaran Kedisiplinan - " . $periodeFormatted,
        ];

        // 4. Render view ke dalam PDF menggunakan Dompdf
        $pdf = Pdf::loadView('terlambat.cetak', $data);

        // 5. Atur orientasi kertas (opsional, default portrait)
        $pdf->setPaper('a4', 'portrait');

        // 6. Tampilkan PDF di browser (stream) atau download
        return $pdf->stream('laporan-kedisiplinan-' . $validated['bulan'] . '.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guru = User::role('guru')->get();
        $siswa = Student::where('status', 'Aktif')->get();
        return view('terlambat.create', compact('guru', 'siswa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'guru_piket' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu_datang' => 'required|date_format:H:i',
        ]);

        $siswa = Student::with('user')->findOrFail($request->input('student_id'));

        // Create a new LateArrival
        $newLateArrival = LateArrival::create([
            'student_id' => $request->input('student_id'),
            'nama_siswa' => $siswa->nama_lengkap,
            'guru_piket' => $request->input('guru_piket'),
            'kelas' => $siswa->room->tingkat . ' ' . $siswa->room->rombongan . ' ' . $siswa->room->nama_jurusan,
            'tanggal' => $request->input('tanggal'),
            'waktu_datang' => $request->input('waktu_datang'),
        ]);

        if ($siswa->user && $siswa->user->email) {
            try {
                Mail::to($siswa->user->email)->send(new PelanggaranKedisiplinanNotification($newLateArrival));
            } catch (\Exception $e) {
                // Opsional: Catat error jika email gagal terkirim tanpa menghentikan proses
                Log::error('Gagal mengirim email notifikasi pelanggaran: ' . $e->getMessage());
            }
        }

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
        $siswa = Student::where('status', 'Aktif')->get();

        return view('terlambat.edit', compact('terlambat', 'siswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $LateArrival = LateArrival::findOrFail($id);

        // Validate the request data
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'guru_piket' => 'required|string|max:255',
            'tanggal' => 'required|date',
        ]);

        $siswa = Student::with('user')->findOrFail($request->input('student_id'));

        // Create a new LateArrival
        $LateArrival->update([
            'student_id' => $request->input('student_id'),
            'nama_siswa' => $siswa->nama_lengkap,
            'guru_piket' => $request->input('guru_piket'),
            'kelas' => $siswa->room->tingkat . ' ' . $siswa->room->rombongan . ' ' . $siswa->room->nama_jurusan,
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
