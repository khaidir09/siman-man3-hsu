<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NaikKelasController extends Controller
{
    public function index()
    {
        // 1. Cari kelas di mana user yang login adalah wali kelasnya
        // firstOrFail() akan otomatis menampilkan error 404 jika user bukan wali kelas
        $sourceRoom = Room::where('wali_kelas_id', Auth::id())->with('students')->firstOrFail();

        // 2. Sediakan daftar semua kelas untuk dropdown tujuan
        $destinationRooms = Room::orderBy('tingkat')->get();

        return view('kenaikan-kelas.index', compact('sourceRoom', 'destinationRooms'));
    }

    public function store(Request $request)
    {
        // Validasi menjadi lebih sederhana
        $validated = $request->validate([
            'destination_room_id' => 'required|exists:rooms,id',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id', // Pastikan semua ID siswa valid
        ]);

        DB::transaction(function () use ($validated) {
            // Langsung update semua siswa yang dipilih ke kelas tujuan
            Student::whereIn('id', $validated['student_ids'])
                ->update(['room_id' => $validated['destination_room_id']]);
        });

        toast('Proses kenaikan kelas berhasil disimpan.', 'success');
        return redirect()->back();
    }
}
