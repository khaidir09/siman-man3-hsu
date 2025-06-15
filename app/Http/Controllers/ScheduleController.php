<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use App\Models\AcademicPeriod;
use App\Models\GeneralSchedule;
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
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $timeSlots = TimeSlot::orderBy('jam_ke')->get();
        $schedules = Schedule::with(['subject', 'teacher'])
            ->get()
            ->groupBy(['room_id', 'hari', 'time_slot_id']);

        // --- TAMBAHAN BARU ---
        // Ambil semua jadwal umum
        $generalSchedules = GeneralSchedule::all();
        $generalEvents = [];

        // Proses data jadwal umum agar mudah diakses di view
        foreach ($generalSchedules as $event) {
            for ($i = $event->time_slot_id_mulai; $i <= $event->time_slot_id_selesai; $i++) {
                $generalEvents[$event->hari][$i] = $event->nama_kegiatan;
            }
        }

        return view('jadwal.index', compact('rooms', 'days', 'timeSlots', 'schedules', 'generalEvents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua data master yang dibutuhkan untuk dropdown di form
        $rooms = Room::orderBy('tingkat')->get();
        $subjects = Subject::orderBy('nama_mapel')->get();
        $teachers = User::role('guru')->orderBy('name')->get();
        $timeSlots = TimeSlot::orderBy('jam_ke')->get();
        $academicPeriods = AcademicPeriod::all();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        return view('jadwal.create', compact('rooms', 'subjects', 'teachers', 'timeSlots', 'academicPeriods', 'days'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'user_id' => 'required|exists:users,id',
            'time_slot_id' => 'required|exists:time_slots,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'hari' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'])],
        ]);

        // --- Validasi Konflik Jadwal ---
        // 1. Cek apakah kelas sudah ada jadwal di jam & hari yang sama
        $classConflict = Schedule::where('room_id', $validatedData['room_id'])
            ->where('time_slot_id', $validatedData['time_slot_id'])
            ->where('hari', $validatedData['hari'])
            ->where('academic_period_id', $validatedData['academic_period_id'])
            ->exists();

        if ($classConflict) {
            return redirect()->back()->withErrors(['time_slot_id' => 'Jadwal untuk kelas ini sudah terisi pada hari dan jam yang sama.'])->withInput();
        }

        // 2. Cek apakah guru sudah mengajar di tempat lain pada jam & hari yang sama
        $teacherConflict = Schedule::where('user_id', $validatedData['user_id'])
            ->where('time_slot_id', $validatedData['time_slot_id'])
            ->where('hari', $validatedData['hari'])
            ->where('academic_period_id', $validatedData['academic_period_id'])
            ->exists();

        if ($teacherConflict) {
            return redirect()->back()->withErrors(['user_id' => 'Guru tersebut sudah memiliki jadwal mengajar pada hari dan jam yang sama.'])->withInput();
        }
        // --- Akhir Validasi Konflik ---

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

        $rooms = Room::orderBy('tingkat')->get();
        $subjects = Subject::orderBy('nama_mapel')->get();
        $teachers = User::role('guru')->orderBy('name')->get();
        $timeSlots = TimeSlot::orderBy('jam_ke')->get();
        $academicPeriods = AcademicPeriod::all();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        return view('jadwal.edit', compact('schedule', 'rooms', 'subjects', 'teachers', 'timeSlots', 'academicPeriods', 'days'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $schedule = Schedule::findOrFail($id);

        // 1. Validasi semua input dari form
        $validatedData = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'user_id' => 'required|exists:users,id',
            'time_slot_id' => 'required|exists:time_slots,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'hari' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'])],
        ]);

        // --- Validasi Konflik Jadwal (Dengan Pengecualian) ---

        // 2. Cek apakah kelas sudah ada jadwal di jam & hari yang sama,
        //    namun abaikan jadwal yang sedang diedit ini.
        $classConflict = Schedule::where('room_id', $validatedData['room_id'])
            ->where('time_slot_id', $validatedData['time_slot_id'])
            ->where('hari', $validatedData['hari'])
            ->where('academic_period_id', $validatedData['academic_period_id'])
            ->where('id', '!=', $schedule->id) // KUNCI: Abaikan ID jadwal saat ini
            ->exists();

        if ($classConflict) {
            return redirect()->back()
                ->withErrors(['time_slot_id' => 'Jadwal untuk kelas ini sudah terisi pada hari dan jam yang sama.'])
                ->withInput();
        }

        // 3. Cek apakah guru sudah mengajar di tempat lain pada jam & hari yang sama,
        //    namun abaikan jadwal yang sedang diedit ini.
        $teacherConflict = Schedule::where('user_id', $validatedData['user_id'])
            ->where('time_slot_id', $validatedData['time_slot_id'])
            ->where('hari', $validatedData['hari'])
            ->where('academic_period_id', $validatedData['academic_period_id'])
            ->where('id', '!=', $schedule->id) // KUNCI: Abaikan ID jadwal saat ini
            ->exists();

        if ($teacherConflict) {
            return redirect()->back()
                ->withErrors(['user_id' => 'Guru tersebut sudah memiliki jadwal mengajar lain pada hari dan jam yang sama.'])
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
        $classConflict = Schedule::where('room_id', $schedule->room_id)
            ->where('time_slot_id', $nextTimeSlot->id)
            ->where('hari', $schedule->hari)
            ->where('academic_period_id', $schedule->academic_period_id)
            ->exists();

        if ($classConflict) {
            toast('Jadwal untuk kelas ini di jam berikutnya sudah terisi.', 'error')->width('450');
            return back();
        }

        // Cek apakah guru sudah mengajar di tempat lain
        $teacherConflict = Schedule::where('user_id', $schedule->user_id)
            ->where('time_slot_id', $nextTimeSlot->id)
            ->where('hari', $schedule->hari)
            ->where('academic_period_id', $schedule->academic_period_id)
            ->exists();

        if ($teacherConflict) {
            toast('Guru ini sudah memiliki jadwal lain di jam berikutnya.', 'error')->width('450');
            return back();
        }

        // 5. Jika tidak ada konflik, buat jadwal baru
        Schedule::create([
            'room_id' => $schedule->room_id,
            'subject_id' => $schedule->subject_id,
            'user_id' => $schedule->user_id,
            'time_slot_id' => $nextTimeSlot->id, // Gunakan ID dari jam berikutnya
            'academic_period_id' => $schedule->academic_period_id,
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
