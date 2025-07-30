<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Major;
use App\Models\Alumni;
use App\Models\Presence;
use App\Models\Schedule;
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
        $data = [];

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


        $isKepalaMadrasah = $user->hasRole('kepala madrasah');
        $isWaliKelas = $user->hasRole('wali kelas');
        $isSiswa = $user->hasRole('siswa');

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

        // Jika user adalah guru, ambil jadwal mengajarnya hari ini
        if ($user->hasRole('guru')) {
            $todayIndonesianDay = Carbon::now()->locale('id')->isoFormat('dddd');

            // Ambil jadwal guru untuk hari ini
            $schedules = Schedule::with(['learning', 'timeSlot'])->get()->where('learning.user_id', $user->id)
                ->where('hari', $todayIndonesianDay) // Mencocokkan dengan nama hari
                ->sortBy('timeSlot.waktu_mulai');

            // Cek untuk setiap jadwal, apakah presensi sudah diambil hari ini
            $todayDate = now()->toDateString();
            foreach ($schedules as $schedule) {
                $schedule->presence_taken = Presence::where('schedule_id', $schedule->id)
                    ->where('user_id', $user->id) // Kolom guru di tabel presences
                    ->whereDate('created_at', $todayDate) // Cek berdasarkan tanggal pembuatan
                    ->exists();
            }

            $data['today_schedules'] = $schedules;
        }

        if ($isSiswa) {
            $studentId = Auth::user()->student->id;

            $presencesThisMonth = Presence::where('student_id', $studentId)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->get();

            // Hitung rekap untuk kartu statistik
            $rekap = $presencesThisMonth->countBy('status');

            // Siapkan data untuk dikirim ke view
            $data['rekap_hadir'] = $rekap->get('hadir', 0);
            $data['rekap_izin']  = $rekap->get('izin', 0);
            $data['rekap_sakit'] = $rekap->get('sakit', 0);
            $data['rekap_alfa']  = $rekap->get('alfa', 0);
        }


        return view('dashboard.index', $viewData, $data);
    }
}
