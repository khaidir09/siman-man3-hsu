<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Major;
use App\Models\Alumni;
use App\Models\Attendance;
use App\Models\HealthCare;
use App\Models\Cooperative;
use App\Models\LateArrival;
use App\Models\Infrastructure;
use App\Models\Extracurricular;
use App\Models\CounselingGuidance;
use App\Models\AcademicAchievement;
use Illuminate\Support\Facades\Auth;
use App\Models\ExtracurricularStudent;
use App\Models\ExtracurricularAchievement;

class DashboardController extends Controller
{
    public function index()
    {

        $user = Auth::user();


        // ===================================================================
        // LANGKAH 1: SIAPKAN SEMUA DATA STATISTIK UMUM
        // ===================================================================
        $viewData = [
            'guru' => User::role('guru')->count(),
            'jurusan' => Major::count(),
            'kelas' => Room::count(),
            'prestasiAkademik' => AcademicAchievement::all()->count(),
            'pelanggaran' => LateArrival::count(),
            'alumni' => Alumni::count(),
            'konseling' => CounselingGuidance::count(),
            'inventaris' => Infrastructure::count(),
            'uks' => HealthCare::count(),
            'jumlahEkskul' => Extracurricular::where('status', 'Aktif')->count(),
            'jumlahPrestasiEkskul' => ExtracurricularAchievement::where('tahun', now()->year)->count(),
            'jumlahAnggotaEkskul' => ExtracurricularStudent::whereYear('tanggal_bergabung', now()->year)
                ->whereMonth('tanggal_bergabung', now()->month)->count(),
        ];

        // --- Logika Khusus untuk Sisa Kas Koperasi ---
        $kasTerakhirBulanLalu = Cooperative::where('tanggal', '<', now()->startOfMonth())
            ->latest('tanggal')
            ->latest('id')
            ->first();

        $transaksiBulanIni = Cooperative::whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)
            ->latest('tanggal')
            ->latest('id')
            ->first();

        // Sisa kas adalah data terakhir di bulan ini, atau jika tidak ada, data terakhir bulan lalu.
        $viewData['sisaKas'] = $transaksiBulanIni->jumlah_kas ?? ($kasTerakhirBulanLalu->jumlah_kas ?? 0);


        // ===================================================================
        // LANGKAH 2: SIAPKAN DATA STATISTIK KEHADIRAN SESUAI PERAN
        // ===================================================================
        $isKepalaMadrasah = $user->hasRole('kepala madrasah');
        $isWaliKelas = $user->hasRole('wali kelas');

        // Periode waktu untuk statistik (6 bulan terakhir)
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subMonths(5)->startOfMonth();

        // Query dasar yang akan difilter
        $query = Attendance::whereBetween('bulan', [$startDate, $endDate]);

        if ($isWaliKelas) {
            // --- Logika untuk Wali Kelas ---
            $waliKelasRoomId = $user->roomClass->id ?? null; // Menggunakan relasi homeroomClass

            if ($waliKelasRoomId) {
                $query->where('rooms_id', $waliKelasRoomId);
                $attendanceData = $query->orderBy('bulan', 'asc')->get();
                $currentMonthData = $attendanceData->last();

                // Isi data untuk kartu statistik
                $viewData['stats_rata_rata'] = $currentMonthData->rata_rata ?? 0;
                $viewData['stats_sakit'] = $currentMonthData->sakit ?? 0;
                $viewData['stats_izin'] = $currentMonthData->izin ?? 0;
                $viewData['stats_alpa'] = $currentMonthData->alpa ?? 0;

                // Isi data untuk grafik
                $viewData['trend_labels'] = $attendanceData->map(fn($item) => Carbon::parse($item->bulan)->locale('id')->format('M Y'));
                $viewData['trend_data'] = $attendanceData->pluck('rata_rata');
                $viewData['absence_breakdown_data'] = [$currentMonthData->sakit ?? 0, $currentMonthData->izin ?? 0, $currentMonthData->alpa ?? 0];
            }
        } elseif ($isKepalaMadrasah) {
            // --- Logika untuk Kepala Madrasah ---
            $allAttendanceData = $query->get()->groupBy(fn($date) => Carbon::parse($date->bulan)->format('Y-m'));
            $currentMonthAttendances = $allAttendanceData->get($endDate->format('Y-m'));

            // Isi data untuk kartu statistik
            $viewData['stats_rata_rata'] = $currentMonthAttendances ? $currentMonthAttendances->avg('rata_rata') : 0;
            $viewData['stats_sakit'] = $currentMonthAttendances ? $currentMonthAttendances->sum('sakit') : 0;
            $viewData['stats_izin'] = $currentMonthAttendances ? $currentMonthAttendances->sum('izin') : 0;
            $viewData['stats_alpa'] = $currentMonthAttendances ? $currentMonthAttendances->sum('alpa') : 0;

            // Isi data untuk grafik tren
            $trendLabels = collect();
            $trendData = collect();
            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $monthKey = $date->format('Y-m');
                $trendLabels->push($date->locale('id')->format('M Y'));
                $monthlyData = $allAttendanceData->get($monthKey);
                $trendData->push($monthlyData ? $monthlyData->avg('rata_rata') : 0);
            }
            $viewData['trend_labels'] = $trendLabels;
            $viewData['trend_data'] = $trendData;

            // Isi data untuk grafik perbandingan kelas
            $classComparisonData = Attendance::where('bulan', '>=', $endDate->startOfMonth())->with('room')->get();
            $viewData['class_comparison_labels'] = $classComparisonData->map(fn($item) => $item->room->tingkat . ' ' . $item->room->rombongan . ' ' . $item->room->nama_jurusan);
            $viewData['class_comparison_data'] = $classComparisonData->pluck('rata_rata');
        }

        // ===================================================================
        // LANGKAH 3: KIRIM SEMUA DATA KE VIEW
        // ===================================================================
        return view('dashboard.index', $viewData);
    }
}
