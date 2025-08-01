<?php

namespace App\Http\Controllers;

use App\Models\Learning;
use Illuminate\Http\Request;
use App\Models\LearningObjective;
use Illuminate\Support\Facades\Auth;

class TujuanPembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Learning $learning)
    {
        if ($learning->user_id !== Auth::id()) {
            abort(403);
        }

        // Ambil semua TP yang berelasi dengan $learning
        $learningObjectives = $learning->learningObjectives()->paginate(10);

        return view('tujuan-pembelajaran.index', compact('learning', 'learningObjectives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Learning $learning)
    {
        if ($learning->user_id !== Auth::id()) {
            abort(403);
        }

        return view('tujuan-pembelajaran.create', compact('learning'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Learning $learning)
    {
        if ($learning->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'deskripsi' => 'required|string',
        ]);

        // Buat TP baru yang otomatis terhubung ke $learning
        $learning->learningObjectives()->create([
            'deskripsi' => $validated['deskripsi'],
        ]);

        toast('Tujuan Pembelajaran berhasil ditambahkan.', 'success');
        return redirect()->route('tujuan-pembelajaran.index', $learning->id);
    }


    /**
     * Display the specified resource.
     * (Halaman ini bisa dikembangkan untuk menampilkan detail anggota dan prestasi)
     */
    public function show()
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Learning $learning, LearningObjective $tujuan_pembelajaran)
    {
        if ($learning->user_id !== Auth::id()) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        return view('tujuan-pembelajaran.edit', compact('learning', 'tujuan_pembelajaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Learning $learning, LearningObjective $tujuan_pembelajaran)
    {
        if ($learning->user_id !== Auth::id()) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        // Validasi input
        $validated = $request->validate([
            'deskripsi' => 'required|string',
        ]);

        // Update data
        $tujuan_pembelajaran->update([
            'deskripsi' => $validated['deskripsi'],
        ]);

        toast('Tujuan Pembelajaran berhasil diperbarui.', 'success');
        return redirect()->route('tujuan-pembelajaran.index', $learning->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Learning $learning, LearningObjective $tujuan_pembelajaran)
    {
        if ($learning->user_id !== Auth::id()) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        // Hapus data
        $tujuan_pembelajaran->delete();

        toast('Tujuan Pembelajaran berhasil dihapus.', 'success');
        return redirect()->route('tujuan-pembelajaran.index', $learning->id);
    }
}
