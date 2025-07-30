<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\Schedule;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use App\Models\AcademicPeriod;
use App\Models\GeneralSchedule;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    public function create(Schedule $schedule)
    {
        // Cek lagi untuk mencegah input ganda jika user membuka dari link langsung
        $existingPresence = Presence::where('schedule_id', $schedule->id)
            ->whereDate('presence_date', now())
            ->exists();

        if ($existingPresence) {
            toast('Presensi untuk kelas ini sudah diambil hari ini.', 'info');
            return redirect()->route('dashboard');
        }

        // Eager load relasi yang dibutuhkan di view
        $schedule->load(['learning.room.students', 'learning.subject', 'timeSlot']);

        // dd($schedule->id);

        $students = $schedule->learning->room->students;

        return view('presensi.create', compact('schedule', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Schedule $schedule)
    {
        $request->validate([
            'presences' => 'required|array',
            'presences.*.status' => 'required|in:Hadir,Izin,Sakit,Alfa',
            'presences.*.notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $schedule) {
            foreach ($request->presences as $studentId => $data) {
                Presence::create([
                    'student_id' => $studentId,
                    'schedule_id' => $schedule->id,
                    'user_id' => auth()->id(),
                    'presence_date' => now()->toDateString(),
                    'status' => $data['status'],
                    'notes' => $data['notes'] ?? null,
                ]);
            }
        });

        toast('Data presensi berhasil disimpan!', 'success');
        return redirect()->route('dashboard');
    }

    public function showHistory(Request $request)
    {
        // Ambil ID siswa dari user yang sedang login
        $studentId = Auth::user()->student->id;

        // Tentukan periode filter. Default ke bulan dan tahun saat ini jika tidak ada input
        $selectedMonth = (int) $request->input('bulan', date('m'));
        $selectedYear = (int) $request->input('tahun', date('Y'));

        // Ambil semua data presensi untuk siswa pada periode yang dipilih
        $history = Presence::where('student_id', $studentId)
            ->whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->with(['schedule.learning.subject', 'schedule.timeSlot']) // Eager loading
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung rekap untuk kartu statistik
        $rekap = $history->countBy('status');

        // Siapkan data untuk dikirim ke view
        $data = [
            'riwayat_presensi' => $history,
            'rekap_hadir'      => $rekap->get('hadir', 0),
            'rekap_izin'       => $rekap->get('izin', 0),
            'rekap_sakit'      => $rekap->get('sakit', 0),
            'rekap_alfa'       => $rekap->get('alfa', 0),
            'bulan_terpilih'   => $selectedMonth,
            'tahun_terpilih'   => $selectedYear,
        ];

        return view('presensi.riwayat', $data);
    }
}
