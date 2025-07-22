<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AcademicPeriod;
use App\Models\Extracurricular;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\NilaiEkskulNotification;
use App\Models\User;

class ExtracurricularController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data dengan relasi untuk efisiensi (eager loading)
        $ekstrakurikuler = Extracurricular::with(['pembina', 'academicPeriod'])->latest()->get();
        $academicPeriods = AcademicPeriod::all();
        return view('ekstrakurikuler.index', compact('ekstrakurikuler', 'academicPeriods'));
    }

    public function cetakLaporanRangkuman(Request $request)
    {
        $imagePath = public_path('images/kemenag.png');
        // 1. Validasi input dari form modal
        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'nomor_surat' => 'nullable|string|max:255',
            'tanggal_cetak' => 'required|date',
        ]);

        // 2. Ambil data utama berdasarkan input
        $academicPeriod = AcademicPeriod::findOrFail($validated['academic_period_id']);

        // 3. Ambil semua data ekstrakurikuler
        // Gunakan withCount untuk menghitung jumlah relasi secara efisien
        $ekstrakurikuler = Extracurricular::where('tahun_ajaran_id', $academicPeriod->id)
            ->with('pembina')
            ->withCount(['students', 'achievements']) // Menghitung jumlah siswa dan prestasi
            ->orderBy('nama_ekskul', 'asc')
            ->get();

        // 4. Ambil data untuk tanda tangan
        $kepalaMadrasah = User::role('kepala madrasah')->first();
        $wakamadKesiswaan = User::role('wakamad kesiswaan')->first();

        // 5. Format data untuk ditampilkan di view
        $tanggalCetakFormatted = Carbon::parse($validated['tanggal_cetak'])->locale('id')->translatedFormat('d F Y');
        $periodeFormatted = "Semester " . $academicPeriod->semester . " Tahun Pelajaran " . $academicPeriod->tahun_ajaran;

        // 6. Kumpulkan semua data untuk dikirim ke view
        $data = [
            'imagePath' => $imagePath,
            'ekstrakurikuler' => $ekstrakurikuler,
            'kepala_madrasah' => $kepalaMadrasah,
            'wakamad_kesiswaan' => $wakamadKesiswaan,
            'periode' => $periodeFormatted,
            'nomor_surat' => $request->nomor_surat,
            'tanggal_cetak' => $tanggalCetakFormatted,
        ];

        // 7. Render view ke dalam PDF
        $pdf = Pdf::loadView('ekstrakurikuler.cetak', $data);
        $pdf->setPaper('a4', 'portrait'); // Landscape lebih cocok untuk tabel rangkuman

        // 8. Buat nama file yang dinamis dan tampilkan PDF
        $fileName = 'laporan-rangkuman-ekskul-' . Str::slug($academicPeriod->tahun_ajaran) . '.pdf';
        return $pdf->stream($fileName);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data yang diperlukan untuk form dropdown
        // Asumsi 'pembina' adalah user dengan role 'guru'. Sesuaikan jika berbeda.
        $pembina = User::whereHas('roles', function ($query) {
            $query->where('name', 'pembina ekskul');
        })->get();
        $academicPeriods = AcademicPeriod::all();

        return view('ekstrakurikuler.create', compact('pembina', 'academicPeriods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data sesuai skema
        $validatedData = $request->validate([
            'nama_ekskul' => 'required|string|max:255|unique:extracurriculars,nama_ekskul',
            'pembina_id' => 'required|exists:users,id',
            'deskripsi' => 'nullable|string',
            'jadwal_hari' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'])],
            'jadwal_waktu' => 'required|date_format:H:i',
            'lokasi' => 'required|string|max:255',
            'status' => ['required', Rule::in(['Aktif', 'Tidak Aktif'])],
            'tahun_ajaran_id' => 'required|exists:academic_periods,id',
        ]);

        // Buat record baru
        Extracurricular::create($validatedData);

        toast('Data Ekstrakurikuler berhasil dibuat.', 'success')->width('350');

        return redirect()->route('ekstrakurikuler.index');
    }

    /**
     * Display the specified resource.
     * (Halaman ini bisa dikembangkan untuk menampilkan detail anggota dan prestasi)
     */
    public function show(Extracurricular $ekstrakurikuler)
    {
        // Load semua relasi yang dibutuhkan untuk ditampilkan
        $ekstrakurikuler->load(['pembina', 'academicPeriod', 'students.room', 'achievements']);

        // Ambil ID siswa yang sudah menjadi anggota ekskul ini
        $memberIds = $ekstrakurikuler->students->pluck('id');

        // Ambil daftar siswa yang statusnya 'Aktif' dan BUKAN anggota ekskul ini,
        // untuk ditampilkan di dropdown 'Tambah Anggota'
        $studentsForAdding = Student::where('status', 'Aktif')->whereNotIn('id', $memberIds)->get();

        $academicPeriods = AcademicPeriod::all();

        return view('ekstrakurikuler.show', compact('ekstrakurikuler', 'studentsForAdding', 'academicPeriods'));
    }

    public function cetakDetail(Request $request)
    {
        $imagePath = public_path('images/kemenag.png');

        // 1. Validasi input dari form modal
        $validated = $request->validate([
            'extracurricular_id' => 'required|exists:extracurriculars,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'tanggal_cetak' => 'required|date',
        ]);

        // 2. Ambil data utama berdasarkan input
        $ekskul = Extracurricular::with('pembina')->findOrFail($validated['extracurricular_id']);
        $academicPeriod = AcademicPeriod::findOrFail($validated['academic_period_id']);

        // 3. Ambil data relasi yang relevan untuk laporan

        // Ambil anggota dari ekstrakurikuler ini
        $anggota = $ekskul->students()->orderBy('nama_lengkap')->get();

        // Ambil prestasi yang diraih ekskul ini PADA PERIODE YANG DIPILIH
        $prestasi = $ekskul->achievements()
            // ->where('academic_period_id', $academicPeriod->id)
            ->with('student') // Ambil data siswa peraih prestasi
            ->orderBy('tahun', 'desc')
            ->get();

        // Ambil data kepala madrasah
        $kepalaMadrasah = User::role('kepala madrasah')->first();

        // 4. Format data untuk ditampilkan di view
        $tanggalCetakFormatted = Carbon::parse($validated['tanggal_cetak'])->locale('id')->translatedFormat('d F Y');
        $periodeFormatted = "Semester " . $academicPeriod->semester . " Tahun Pelajaran " . $academicPeriod->tahun_ajaran;

        // 5. Kumpulkan semua data untuk dikirim ke view
        $data = [
            'imagePath' => $imagePath,
            'ekskul' => $ekskul,
            'anggota' => $anggota,
            'prestasi' => $prestasi,
            'kepala_madrasah' => $kepalaMadrasah,
            'periode' => $periodeFormatted,
            'tanggal_cetak' => $tanggalCetakFormatted,
        ];

        // 6. Render view ke dalam PDF
        $pdf = Pdf::loadView('ekstrakurikuler.cetak-detail', $data);
        $pdf->setPaper('a4', 'landscape');

        // 7. Buat nama file yang dinamis dan tampilkan PDF
        $fileName = 'laporan-' . Str::slug($ekskul->nama_ekskul) . '-' . Str::slug($academicPeriod->tahun_ajaran) . '.pdf';
        return $pdf->stream($fileName);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Extracurricular $ekstrakurikuler)
    {
        // Menggunakan Route Model Binding
        $pembina = User::whereHas('roles', function ($query) {
            $query->where('name', 'pembina ekskul');
        })->get();
        $academicPeriods = AcademicPeriod::all();

        return view('ekstrakurikuler.edit', compact('ekstrakurikuler', 'pembina', 'academicPeriods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Extracurricular $ekstrakurikuler)
    {
        // Validasi data
        $validatedData = $request->validate([
            'nama_ekskul' => 'required|string|max:255|unique:extracurriculars,nama_ekskul,' . $ekstrakurikuler->id,
            'pembina_id' => 'required|exists:users,id',
            'deskripsi' => 'nullable|string',
            'jadwal_hari' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'])],
            // 'jadwal_waktu' => 'required|date_format:H:i',
            'lokasi' => 'required|string|max:255',
            'status' => ['required', Rule::in(['Aktif', 'Tidak Aktif'])],
            'tahun_ajaran_id' => 'required|exists:academic_periods,id',
        ]);

        // Update record
        $ekstrakurikuler->update($validatedData);

        toast('Data Ekstrakurikuler berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('ekstrakurikuler.index');
    }

    public function addMember(Request $request, Extracurricular $ekstrakurikuler)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'jabatan' => 'required|string|max:100'
        ]);

        // Cek apakah siswa sudah menjadi anggota
        if ($ekstrakurikuler->students()->where('student_id', $request->student_id)->exists()) {
            toast('Siswa sudah terdaftar sebagai anggota.', 'error');
            return redirect()->back();
        }

        // Tambahkan siswa ke tabel pivot
        $ekstrakurikuler->students()->attach($request->student_id, [
            'jabatan' => $request->jabatan,
            'tanggal_bergabung' => now()
        ]);

        toast('Anggota berhasil ditambahkan.', 'success');
        return redirect()->back();
    }

    public function updateMember(Request $request, Extracurricular $ekstrakurikuler, Student $student)
    {
        $validated = $request->validate([
            'jabatan' => 'required|string|max:100',
            'nilai' => ['nullable', 'string', Rule::in(['A', 'B', 'C', 'D', 'E'])],
        ]);

        $newGrade = $request->input('nilai');

        // Gunakan updateExistingPivot() untuk mengubah data di tabel pivot
        $ekstrakurikuler->students()->updateExistingPivot($student->id, [
            'jabatan' => $validated['jabatan'],
            'nilai' => $newGrade,
        ]);

        if ($request->filled('nilai')) {
            $user = $student->user;
            Mail::to($user->email)->send(new NilaiEkskulNotification($user, $ekstrakurikuler, $newGrade));
        }

        toast('Data keanggotaan berhasil diperbarui.', 'success');
        return redirect()->back();
    }

    /**
     * Remove a member from the extracurricular.
     */
    public function removeMember(Extracurricular $ekstrakurikuler, Student $student)
    {
        // Hapus relasi siswa dari tabel pivot
        $ekstrakurikuler->students()->detach($student->id);

        toast('Anggota berhasil dihapus.', 'success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ekstrakurikuler = Extracurricular::findOrFail($id);

        try {
            // Hapus record dari database
            $ekstrakurikuler->delete();

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
