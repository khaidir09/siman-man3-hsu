<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;
use App\Models\AcademicAchievement;
use App\Models\AcademicPeriod;
use App\Models\Room;

class PrestasiAkademikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $academic_achievements = AcademicAchievement::all();
        return view('prestasi-akademik.index', compact('academic_achievements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::all();
        $periods = AcademicPeriod::all();
        return view('prestasi-akademik.create', compact('rooms', 'periods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'nisn' => 'required|numeric|digits:10|unique:academic_achievements,nisn',
            'nama' => 'required|string|max:255',
            'ortu' => 'required|string|max:255',
            'jumlah_nilai' => 'required|string|max:255',
            'rata_rata' => 'required|decimal:0,2',
            'ranking' => 'required|string|max:255',
            'rooms_id' => 'required|exists:rooms,id',
            'academic_periods_id' => 'required|exists:academic_periods,id'
        ]);

        // Create a new major
        AcademicAchievement::create([
            'nisn' => $request->input('nisn'),
            'nama' => $request->input('nama'),
            'ortu' => $request->input('ortu'),
            'jumlah_nilai' => $request->input('jumlah_nilai'),
            'rata_rata' => $request->input('rata_rata'),
            'ranking' => $request->input('ranking'),
            'rooms_id' => $request->input('rooms_id'),
            'academic_periods_id' => $request->input('academic_periods_id'),
        ]);

        toast('Prestasi Akademik berhasil dibuat.', 'success')->width('350');

        return redirect()->route('prestasi-akademik.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $prestasi = AcademicAchievement::findOrFail($id);

        $rooms = Room::all();
        $periods = AcademicPeriod::all();

        return view('prestasi-akademik.edit', compact('prestasi', 'rooms', 'periods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $prestasi = AcademicAchievement::findOrFail($id);

        // Validate the request data
        $request->validate([
            'nisn' => 'required|numeric|digits:10|unique:academic_achievements,nisn,' . $prestasi->id,
            'nama' => 'required|string|max:255',
            'ortu' => 'required|string|max:255',
            'jumlah_nilai' => 'required|string|max:255',
            'rata_rata' => 'required|decimal:0,2',
            'ranking' => 'required|string|max:255',
            'rooms_id' => 'required|exists:rooms,id',
            'academic_periods_id' => 'required|exists:academic_periods,id'
        ]);

        // Create a new major
        $prestasi->update([
            'nisn' => $request->input('nisn'),
            'nama' => $request->input('nama'),
            'ortu' => $request->input('ortu'),
            'jumlah_nilai' => $request->input('jumlah_nilai'),
            'rata_rata' => $request->input('rata_rata'),
            'ranking' => $request->input('ranking'),
            'rooms_id' => $request->input('rooms_id'),
            'academic_periods_id' => $request->input('academic_periods_id'),
        ]);

        toast('Prestasi Akademik berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('prestasi-akademik.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prestasi = AcademicAchievement::findOrFail($id);

        $prestasi->delete();

        toast('Prestasi Akademik berhasil dihapus.', 'success')->width('350');

        return redirect()->back();
    }
}
