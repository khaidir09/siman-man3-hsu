<?php

namespace App\Http\Controllers;

use App\Models\AcademicAchievement;
use App\Models\Alumni;
use App\Models\Cooperative;
use App\Models\CounselingGuidance;
use App\Models\Extracurricular;
use App\Models\ExtracurricularAchievement;
use App\Models\ExtracurricularStudent;
use App\Models\HealthCare;
use App\Models\Infrastructure;
use App\Models\LateArrival;
use App\Models\Major;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;

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
        $konseling = CounselingGuidance::all()->count();
        $inventaris = Infrastructure::all()->count();
        $uks = HealthCare::all()->count();

        $saldoAwal = Cooperative::where('tanggal', Carbon::now()->startOfMonth())
            ->latest('tanggal')
            ->latest('id')
            ->first()
            ->jumlah_kas ?? 0;

        $date = Carbon::now();
        $year = $date->year;
        $month = $date->month;

        $koperasi = Cooperative::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->orderBy('tanggal', 'asc')
            ->get();

        $sisaKas = $koperasi->last()->jumlah_kas ?? $saldoAwal;

        $jumlahEkskul = Extracurricular::where('status', 'Aktif')->count();

        $jumlahAnggotaEkskul = ExtracurricularStudent::whereYear('tanggal_bergabung', $year)
            ->whereMonth('tanggal_bergabung', $month)->count();

        $jumlahPrestasiEkskul = ExtracurricularAchievement::where('tahun', $year)->count();

        return view('dashboard.index', compact('guru', 'jurusan', 'kelas', 'prestasiAkademik', 'pelanggaran', 'alumni', 'konseling', 'inventaris', 'uks', 'sisaKas', 'jumlahEkskul', 'jumlahAnggotaEkskul', 'jumlahPrestasiEkskul'));
    }
}
