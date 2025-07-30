<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Subject;
use App\Models\Learning;
use Illuminate\Http\Request;
use App\Models\AcademicPeriod;
use App\Models\Extracurricular;
use App\Models\LearningObjective;
use Illuminate\Support\Facades\Auth;

class TujuanPembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query = LearningObjective::query()->with('learning');

        // Jika user adalah guru, filter hanya TP dari mapel yang diajar
        if ($user->hasRole('guru')) {
            // Gunakan whereHas untuk memfilter Exam berdasarkan kondisi pada relasi 'pembelajaran'
            $query->whereHas('learning', function ($subQuery) use ($user) {
                $subQuery->where('user_id', $user->id);
            });
        }

        $learningObjectives = $query->latest()->paginate(10);

        return view('tujuan-pembelajaran.index', compact('learningObjectives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $data = [];

        $pembelajaranQuery = Learning::with('subject', 'user', 'room', 'academicPeriod');

        if ($user->hasRole('wakasek kurikulum')) {
            $data['learnings'] = $pembelajaranQuery->get();
        } elseif ($user->hasRole('guru')) {
            // Jika Guru, ambil hanya data pembelajaran yang berelasi dengan ID guru tersebut.
            $data['learnings'] = $pembelajaranQuery->where('user_id', $user->id)->get();
        } else {
            // Default jika user tidak memiliki peran yang sesuai, kembalikan array kosong.
            $data['learnings'] = [];
        }

        return view('tujuan-pembelajaran.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'learning_id' => 'required|exists:learnings,id',
            'deskripsi' => 'required|string',
        ]);

        LearningObjective::create($validated);

        toast('Data Tujuan Pembelajaran berhasil dibuat.', 'success')->width('350');

        return redirect()->route('tujuan-pembelajaran.index');
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
    public function edit(LearningObjective $tujuan_pembelajaran)
    {
        // Logika untuk mengisi dropdown sama seperti di method create
        $user = Auth::user();
        $learnings = collect();

        if ($user->hasRole('wakasek kurikulum')) {
            $learnings = Learning::with('subject', 'user', 'room', 'academicPeriod')->get();
        } elseif ($user->hasRole('guru')) {
            $learnings = Learning::with('subject', 'user', 'room', 'academicPeriod')
                ->where('user_id', $user->id)
                ->get();
        } else {
            // Jika user tidak memiliki peran yang sesuai, kembalikan array kosong.
            $learnings = collect();
        }

        return view('tujuan-pembelajaran.edit', compact('tujuan_pembelajaran', 'learnings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LearningObjective $learningObjective)
    {
        // Validasi data
        $validatedData = $request->validate([
            'learning_id' => 'required|exists:learnings,id',
            'deskripsi' => 'required|string',
        ]);

        // Update record
        $learningObjective->update($validatedData);

        toast('Data Pembelajaran berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('tujuan-pembelajaran.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pembelajaran = Learning::findOrFail($id);

        try {
            // Hapus record dari database
            $pembelajaran->delete();

            // Kembalikan respons dalam format JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Data Pembelajaran Berhasil Dihapus!'
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
