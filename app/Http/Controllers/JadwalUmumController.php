<?php

namespace App\Http\Controllers;

use App\Models\GeneralSchedule;
use App\Models\AcademicPeriod;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JadwalUmumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $generalSchedules = GeneralSchedule::with(['startTimeSlot', 'endTimeSlot', 'academicPeriod'])->latest()->get();
        return view('jadwal-umum.index', compact('generalSchedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $timeSlots = TimeSlot::orderBy('jam_ke')->get();
        $academicPeriods = AcademicPeriod::all();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return view('jadwal-umum.create', compact('timeSlots', 'academicPeriods', 'days'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'hari' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'])],
            'time_slot_id_mulai' => 'required|exists:time_slots,id',
            'time_slot_id_selesai' => 'required|exists:time_slots,id|gte:time_slot_id_mulai',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'keterangan' => 'nullable|string',
        ]);

        GeneralSchedule::create($validatedData);

        toast('Jadwal Umum berhasil dibuat.', 'success')->width('350');

        return redirect()->route('jadwal-umum.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $generalSchedule = GeneralSchedule::findOrFail($id);

        $timeSlots = TimeSlot::orderBy('jam_ke')->get();
        $academicPeriods = AcademicPeriod::all();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return view('jadwal-umum.edit', compact('generalSchedule', 'timeSlots', 'academicPeriods', 'days'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $generalSchedule = GeneralSchedule::findOrFail($id);

        $validatedData = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'hari' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'])],
            'time_slot_id_mulai' => 'required|exists:time_slots,id',
            'time_slot_id_selesai' => 'required|exists:time_slots,id|gte:time_slot_id_mulai',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'keterangan' => 'nullable|string',
        ]);

        $generalSchedule->update($validatedData);

        toast('Jadwal Umum berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('jadwal-umum.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $generalSchedule = GeneralSchedule::findOrFail($id);

        try {
            $generalSchedule->delete();

            // Kembalikan respons dalam format JSON untuk AJAX
            return response()->json([
                'status' => 'success',
                'message' => 'Data Jadwal Umum Berhasil Dihapus!'
            ]);
        } catch (\Exception $e) {
            // Jika terjadi error, kirim respons error
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus data. Terjadi kesalahan.'
            ], 500);
        }
    }
}
