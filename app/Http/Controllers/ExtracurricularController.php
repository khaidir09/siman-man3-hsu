<?php

namespace App\Http\Controllers;

use App\Models\Extracurricular;
use App\Models\User; // Asumsi pembina adalah User
use App\Models\AcademicPeriod;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExtracurricularController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data dengan relasi untuk efisiensi (eager loading)
        $ekstrakurikuler = Extracurricular::with(['pembina', 'academicPeriod'])->latest()->get();
        return view('ekstrakurikuler.index', compact('ekstrakurikuler'));
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
            'kelompok' => 'required|string|max:255',
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

        return view('ekstrakurikuler.show', compact('ekstrakurikuler', 'studentsForAdding'));
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
            'kelompok' => 'required|string|max:255',
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

        // Gunakan updateExistingPivot() untuk mengubah data di tabel pivot
        $ekstrakurikuler->students()->updateExistingPivot($student->id, [
            'jabatan' => $validated['jabatan'],
            'nilai' => $request->input('nilai'),
        ]);

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
    public function destroy(Extracurricular $ekstrakurikuler)
    {
        // Hapus record
        // Jika Anda menggunakan onDelete('cascade') pada migrasi,
        // data di tabel pivot (extracurricular_student) akan ikut terhapus.
        $ekstrakurikuler->delete();

        toast('Data Ekstrakurikuler berhasil dihapus.', 'success')->width('350');

        return redirect()->back();
    }
}
