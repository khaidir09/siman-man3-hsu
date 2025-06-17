<?php

namespace App\Http\Controllers;

use App\Models\AcademicAchievement;
use App\Models\Alumni;
use App\Models\LateArrival;
use App\Models\Major;
use App\Models\Room;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $guru = User::whereHas('roles', function ($query) {
            $query->where('name', 'guru');
        })->count();
        $jurusan = Major::all()->count();
        $kelas = Room::all()->count();
        $prestasiAkademik = AcademicAchievement::all()->count();
        $pelanggaran = LateArrival::all()->count();
        $alumni = Alumni::all()->count();
        return view('dashboard.index', compact('guru', 'jurusan', 'kelas', 'prestasiAkademik', 'pelanggaran', 'alumni'));
    }
}
