<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\AcademicPeriod;
use App\Models\Extracurricular;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\ExtracurricularAchievement;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     * (Halaman ini bisa menampilkan daftar semua prestasi dari semua ekskul)
     */
    public function index()
    {
        $achievements = ExtracurricularAchievement::with('extracurricular')->latest('tahun')->get();
        return view('prestasi-ekskul.index', compact('achievements'));
    }

    public function getMembersAjax(Extracurricular $ekskul)
    {
        // Mengambil hanya id dan nama lengkap dari anggota ekskul yang dipilih
        // diurutkan berdasarkan nama
        $members = $ekskul->students()->orderBy('nama_lengkap')->select('students.id', 'nama_lengkap')->get();

        // Mengembalikan data dalam format JSON yang akan dibaca oleh JavaScript
        return response()->json($members);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $ekstrakurikuler = Extracurricular::orderBy('nama_ekskul')->get();

        return view('prestasi-ekskul.create', compact('ekstrakurikuler'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data prestasi
        $validatedData = $request->validate([
            'extracurricular_id' => 'required|exists:extracurriculars,id',
            'student_id' => 'required|exists:students,id',
            'nama_lomba' => 'required|string|max:255',
            'peringkat' => 'required|string|max:100',
            'tingkat' => ['required', Rule::in(['Sekolah', 'Kecamatan', 'Kabupaten', 'Provinsi', 'Nasional', 'Internasional'])],
            'tahun' => 'required|integer|date_format:Y|min:1990|max:' . date('Y'),
            'penyelenggara' => 'required|string|max:255',
            'sertifikat' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('sertifikat')) {
            // Simpan file ke storage/app/public/sertifikat_prestasi
            // Laravel akan otomatis membuat nama file yang unik
            $path = $request->file('sertifikat')->store('public/sertifikat_prestasi');

            // Simpan path yang dikembalikan oleh store() ke dalam data yang akan disimpan
            $validatedData['sertifikat'] = $path;
        }

        // Buat record prestasi baru
        ExtracurricularAchievement::create($validatedData);

        toast('Data Prestasi berhasil ditambahkan.', 'success')->width('350');

        // Redirect kembali ke halaman detail ekstrakurikuler yang bersangkutan
        return redirect()->route('ekstrakurikuler.show', $validatedData['extracurricular_id']);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $prestasi = ExtracurricularAchievement::findOrFail($id);
        $ekstrakurikuler = Extracurricular::orderBy('nama_ekskul')->get();
        $pembina = User::whereHas('roles', function ($query) {
            $query->where('name', 'pembina ekskul');
        })->get();
        $academicPeriods = AcademicPeriod::all();
        return view('prestasi-ekskul.edit', compact('prestasi', 'ekstrakurikuler', 'pembina', 'academicPeriods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $prestasi = ExtracurricularAchievement::findOrFail($id);
        // Validasi data
        $validatedData = $request->validate([
            'extracurricular_id' => 'required|exists:extracurriculars,id',
            'student_id' => 'required|exists:students,id',
            'nama_lomba' => 'required|string|max:255',
            'peringkat' => 'required|string|max:100',
            'tingkat' => ['required', Rule::in(['Kabupaten', 'Provinsi', 'Nasional'])],
            'tahun' => 'required|integer|date_format:Y|min:1990|max:' . date('Y'),
            'penyelenggara' => 'required|string|max:255',
            'sertifikat' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('sertifikat')) {
            // Hapus file lama jika ada
            if ($prestasi->sertifikat) {
                Storage::delete($prestasi->sertifikat);
            }
            // Simpan file baru dan update path-nya
            $path = $request->file('sertifikat')->store('public/sertifikat_prestasi');
            $validatedData['sertifikat'] = $path;
        }

        // Update record
        $prestasi->update($validatedData);

        toast('Data Prestasi berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('prestasi-ekskul.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prestasi = ExtracurricularAchievement::findOrFail($id);
        try {
            // Hapus record dari database
            $prestasi->delete();

            // Kembalikan respons dalam format JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Data Prestasi Berhasil Dihapus!'
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
