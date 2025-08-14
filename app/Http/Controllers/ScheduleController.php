<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\TimeSlot;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AcademicPeriod;
use App\Models\GeneralSchedule;
use App\Models\Learning;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     * Halaman ini akan menampilkan jadwal pelajaran per kelas.
     */
    public function index()
    {
        $rooms = Room::with('waliKelas')->orderBy('tingkat')->get();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $timeSlots = TimeSlot::orderBy('jam_ke')->get();

        // Perbaikan: Group jadwal berdasarkan room_id, hari, dan time_slot_id
        $schedules = Schedule::with(['learning'])
            ->get()
            ->groupBy(function ($item) {
                return $item->learning->room_id;
            })->map(function ($group) {
                return $group->groupBy('hari')->map(function ($hariGroup) {
                    return $hariGroup->groupBy('time_slot_id');
                });
            });

        // --- TAMBAHAN BARU ---
        // Ambil semua jadwal umum
        $generalSchedules = GeneralSchedule::all();
        $generalEvents = [];

        $academicPeriods = AcademicPeriod::all();

        // Proses data jadwal umum agar mudah diakses di view
        foreach ($generalSchedules as $event) {
            for ($i = $event->time_slot_id_mulai; $i <= $event->time_slot_id_selesai; $i++) {
                $generalEvents[$event->hari][$i] = $event->nama_kegiatan;
            }
        }

        return view('jadwal.index', compact('rooms', 'days', 'timeSlots', 'schedules', 'generalEvents', 'academicPeriods'));
    }

    public function cetakJadwalKelas(Request $request)
    {
        $imagePath = public_path('images/kemenag.png');

        // 1. Validasi input dari form modal
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'tanggal_cetak' => 'required|date',
        ]);

        // 2. Ambil data utama berdasarkan input
        $room = Room::with('waliKelas')->findOrFail($validated['room_id']);
        $academicPeriod = AcademicPeriod::findOrFail($validated['academic_period_id']);

        // 3. Ambil semua data yang diperlukan untuk tabel jadwal
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $timeSlots = TimeSlot::orderBy('jam_ke')->get();

        // 4. Ambil jadwal pelajaran spesifik untuk kelas dan periode ini
        $schedules = Schedule::with(['learning', 'timeSlot'])
            ->get()
            ->where('learning.room_id', $room->id)
            ->where('learning.academic_period_id', $academicPeriod->id)
            ->groupBy(['hari', 'time_slot_id']); // Kelompokkan agar mudah ditampilkan

        // 5. Ambil jadwal umum (Upacara, Tadarus, dll) untuk periode ini
        $generalSchedulesRaw = GeneralSchedule::where('academic_period_id', $academicPeriod->id)->get();
        $generalSchedules = [];
        foreach ($generalSchedulesRaw as $event) {
            for ($i = $event->time_slot_id_mulai; $i <= $event->time_slot_id_selesai; $i++) {
                $generalSchedules[$event->hari][$i] = $event->nama_kegiatan;
            }
        }

        // 6. Ambil data untuk tanda tangan
        $kepalaMadrasah = User::role('kepala madrasah')->first();
        $wakamadKurikulum = User::role('wakamad kurikulum')->first(); // Pastikan role ini ada

        // 7. Format data lain untuk ditampilkan
        $tanggalCetakFormatted = Carbon::parse($validated['tanggal_cetak'])->locale('id')->translatedFormat('d F Y');
        $periodeFormatted = $academicPeriod->tahun_ajaran;

        // 8. Kumpulkan semua data untuk dikirim ke view
        $data = [
            'imagePath' => $imagePath,
            'room' => $room,
            'academic_period_text' => $periodeFormatted,
            'days' => $days,
            'timeSlots' => $timeSlots,
            'schedules' => $schedules,
            'generalSchedules' => $generalSchedules,
            'kepala_madrasah' => $kepalaMadrasah,
            'wakamad_kurikulum' => $wakamadKurikulum,
            'tanggal_cetak' => $tanggalCetakFormatted,
        ];

        // 9. Render view ke dalam PDF
        $pdf = Pdf::loadView('jadwal.cetak', $data);
        $pdf->setPaper('a4', 'landscape'); // Landscape paling cocok untuk tabel jadwal

        // 10. Buat nama file yang dinamis dan tampilkan PDF
        $fileName = 'jadwal-kelas-' . Str::slug($room->name) . '-' . Str::slug($academicPeriod->tahun_ajaran) . '.pdf';
        return $pdf->stream($fileName);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua data master yang dibutuhkan untuk dropdown di form
        $learnings = Learning::orderBy('id')->get();
        $timeSlots = TimeSlot::orderBy('jam_ke')->get();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        return view('jadwal.create', compact('learnings', 'timeSlots', 'days'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'learning_id' => 'required|exists:learnings,id',
            'time_slot_id' => 'required|exists:time_slots,id',
            'hari' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'])],
        ]);

        // --- Validasi Konflik Jadwal ---
        // 1. Cek apakah kelas sudah ada jadwal di jam & hari yang sama
        $classConflict = Schedule::where('learning_id', $validatedData['learning_id'])
            ->where('time_slot_id', $validatedData['time_slot_id'])
            ->where('hari', $validatedData['hari'])
            ->exists();

        if ($classConflict) {
            return redirect()->back()->withErrors(['time_slot_id' => 'Jadwal untuk kelas ini sudah terisi pada hari dan jam yang sama.'])->withInput();
        }

        Schedule::create($validatedData);

        toast('Jadwal Pelajaran berhasil dibuat.', 'success')->width('350');

        return redirect()->route('jadwal.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $schedule = Schedule::findOrFail($id);

        $learnings = Learning::orderBy('id')->get();
        $timeSlots = TimeSlot::orderBy('jam_ke')->get();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        return view('jadwal.edit', compact('schedule', 'learnings', 'timeSlots', 'days'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $schedule = Schedule::findOrFail($id);

        // 1. Validasi semua input dari form
        $validatedData = $request->validate([
            'learning_id' => 'required|exists:learnings,id',
            'time_slot_id' => 'required|exists:time_slots,id',
            'hari' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'])],
        ]);

        // --- Validasi Konflik Jadwal (Dengan Pengecualian) ---

        // 2. Cek apakah kelas sudah ada jadwal di jam & hari yang sama,
        //    namun abaikan jadwal yang sedang diedit ini.
        $classConflict = Schedule::where('learning_id', $validatedData['learning_id'])
            ->where('time_slot_id', $validatedData['time_slot_id'])
            ->where('hari', $validatedData['hari'])
            ->where('id', '!=', $schedule->id) // KUNCI: Abaikan ID jadwal saat ini
            ->exists();

        if ($classConflict) {
            return redirect()->back()
                ->withErrors(['time_slot_id' => 'Jadwal untuk kelas ini sudah terisi pada hari dan jam yang sama.'])
                ->withInput();
        }

        $schedule->update($validatedData);

        toast('Jadwal Pelajaran berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('jadwal.index');
    }

    public function clone(Schedule $schedule)
    {
        // 1. Dapatkan jam ke- dari jadwal saat ini
        $currentJamKe = $schedule->timeSlot->jam_ke;

        // 2. Cari slot waktu untuk jam berikutnya
        $nextTimeSlot = TimeSlot::where('jam_ke', $currentJamKe + 1)->first();

        // 3. Jika tidak ada jam berikutnya (misalnya sudah jam terakhir), kembalikan error
        if (!$nextTimeSlot) {
            toast('Tidak ada jam pelajaran berikutnya untuk di-clone.', 'error')->width('450');
            return back();
        }

        // 4. Periksa konflik di JAM BERIKUTNYA
        // Cek apakah kelas sudah ada jadwal
        $classConflict = Schedule::where('learning_id', $schedule->learning_id)
            ->where('time_slot_id', $nextTimeSlot->id)
            ->where('hari', $schedule->hari)
            ->exists();

        if ($classConflict) {
            toast('Jadwal untuk kelas ini di jam berikutnya sudah terisi.', 'error')->width('450');
            return back();
        }

        // 5. Jika tidak ada konflik, buat jadwal baru
        Schedule::create([
            'learning_id' => $schedule->learning_id,
            'time_slot_id' => $nextTimeSlot->id, // Gunakan ID dari jam berikutnya
            'hari' => $schedule->hari,
        ]);

        toast('Jadwal berhasil di-clone ke jam berikutnya.', 'success');
        return redirect()->route('jadwal.index'); // Sesuaikan dengan nama route Anda
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedule = Schedule::findOrFail($id);

        try {
            // Hapus record dari database
            $schedule->delete();

            // Kembalikan respons dalam format JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Jadwal Pelajaran berhasil dihapus!'
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
