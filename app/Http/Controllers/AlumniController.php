<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Alumni;
use Illuminate\Http\Request;
use App\Models\AcademicPeriod;
use Barryvdh\DomPDF\Facade\Pdf;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data alumni dengan relasinya untuk efisiensi (eager loading)
        $alumni = Alumni::with(['room', 'academicPeriod'])->latest()->get();
        $academicPeriods = AcademicPeriod::latest()->get();
        return view('alumni.index', compact('alumni', 'academicPeriods'));
    }

    public function cetakAlumni(Request $request)
    {
        $imagePath = public_path('images/kemenag.png');
        $request->validate([
            'academic_periods_id' => 'required',
        ]);

        $academicPeriod = AcademicPeriod::findOrFail($request->academic_periods_id);

        $alumni = Alumni::with(['academicPeriod'])
            ->where('academic_periods_id', $request->academic_periods_id)
            ->orderBy('no_induk', 'asc')
            ->get();

        // Ambil data kepala madrasah
        $kepalaMadrasah = User::role('kepala madrasah')->first();

        $tanggalCetakFormatted = Carbon::now()->locale('id')->translatedFormat('d F Y');

        $jumlahAlumniKuliah = $alumni->where('melanjutkan', 'Kuliah')->count();
        $jumlahAlumniBekerja = $alumni->where('melanjutkan', 'Bekerja')->count();
        $jumlahAlumniLainnya = $alumni->where('melanjutkan', '!=', 'Kuliah')->where('melanjutkan', '!=', 'Bekerja')->count();

        $data = [
            'imagePath' => $imagePath,
            'alumni' => $alumni,
            'jumlahAlumniKuliah' => $jumlahAlumniKuliah,
            'jumlahAlumniBekerja' => $jumlahAlumniBekerja,
            'jumlahAlumniLainnya' => $jumlahAlumniLainnya,
            'academic_period' => $academicPeriod,
            'kepala_madrasah' => $kepalaMadrasah,
            'tanggal_cetak' => $tanggalCetakFormatted,
            'judul_laporan' => "Laporan Alumni - " . $academicPeriod->tahun_ajaran,
        ];

        // 4. Render view ke dalam PDF menggunakan Dompdf
        $pdf = Pdf::loadView('alumni.cetak', $data);

        // 5. Atur orientasi kertas (opsional, default portrait)
        $pdf->setPaper('a4', 'landscape');

        // 6. Tampilkan PDF di browser (stream) atau download
        return $pdf->stream('laporan-alumni-' . $academicPeriod->tahun_ajaran . '.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data yang diperlukan untuk form dropdown
        $rooms = Room::all();
        $academicPeriods = AcademicPeriod::all();
        return view('alumni.create', compact('rooms', 'academicPeriods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data sesuai skema tabel alumnis
        $validatedData = $request->validate([
            'no_induk' => 'required|string|max:255|unique:alumnis,no_induk',
            'nama_siswa' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'rooms_id' => 'required|exists:rooms,id',
            'tanggal_lahir' => 'required|date',
            'academic_periods_id' => 'required|exists:academic_periods,id',
            'melanjutkan' => 'required|string|max:255',
            'nama_tempat' => 'string|max:255',
        ]);

        // Buat record baru menggunakan model Alumni
        Alumni::create($validatedData);

        toast('Data Alumni berhasil dibuat.', 'success')->width('350');

        return redirect()->route('alumni.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumni $alumni)
    {
        // Bisa dikosongkan atau digunakan untuk halaman detail
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Menggunakan Route Model Binding untuk mengambil data alumni
        $rooms = Room::all();
        $academicPeriods = AcademicPeriod::all();
        $alumni = Alumni::findOrFail($id);

        return view('alumni.edit', compact('alumni', 'rooms', 'academicPeriods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $alumni = Alumni::findOrFail($id);

        $validatedData = $request->validate([
            'no_induk' => 'required|string|max:255|unique:alumnis,no_induk,' . $alumni->id,
            'nama_siswa' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'rooms_id' => 'required|exists:rooms,id',
            'tanggal_lahir' => 'required|date',
            'academic_periods_id' => 'required|exists:academic_periods,id',
            'melanjutkan' => 'required|string|max:255',
            'nama_tempat' => 'string|max:255',
        ]);

        // Update record alumni
        $alumni->update($validatedData);

        toast('Data Alumni berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('alumni.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $alumni = Alumni::findOrFail($id);
        try {
            // Hapus record dari database
            $alumni->delete();

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
