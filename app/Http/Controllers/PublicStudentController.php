<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class PublicStudentController extends Controller
{
    /**
     * Menampilkan halaman form untuk mengecek riwayat siswa.
     */
    public function showForm()
    {
        return view('riwayat-siswa.form');
    }

    /**
     * Memvalidasi input NIS & Tanggal Lahir.
     */
    public function checkData(Request $request)
    {
        $validated = $request->validate([
            'nisn' => 'required|numeric',
        ]);

        // Cari siswa berdasarkan NISN DAN Tanggal Lahir
        $student = Student::where('nisn', $validated['nisn'])->first();

        // Jika siswa ditemukan, arahkan ke halaman riwayat. Jika tidak, kembali dengan error.
        if ($student) {
            return redirect()->route('siswa.riwayat.show', ['student' => $student->nisn]);
        } else {
            return back()->withErrors(['nisn' => 'NISN tidak ditemukan.']);
        }
    }

    /**
     * Menampilkan halaman riwayat lengkap siswa.
     */
    public function showHistory(Student $student)
    {
        // Eager load semua relasi yang ingin ditampilkan
        $student->load([
            'achievements.extracurricular',
            'lateArrival',
            'counseling',
            'healthcare'
        ]);

        return view('riwayat-siswa.show', compact('student'));
    }
}
