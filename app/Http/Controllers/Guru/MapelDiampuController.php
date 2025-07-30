<?php

namespace App\Http\Controllers\Guru;

use App\Models\Schedule;
use App\Http\Controllers\Controller;
use App\Models\Learning;
use Illuminate\Support\Facades\Auth;

class MapelDiampuController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $groupedSubjects = collect(); // Inisialisasi koleksi kosong

        if ($user->hasRole('guru')) {
            // 1. Ambil SEMUA jadwal yang dimiliki oleh guru yang sedang login
            // Gunakan eager loading 'with()' untuk performa yang jauh lebih baik!
            $learnings = Learning::where('user_id', $user->id)
                ->with(['subject', 'room'])
                ->get();

            // 2. Kelompokkan hasil jadwal tersebut berdasarkan nama mata pelajaran
            // Hasilnya akan menjadi: [ 'Matematika' => [jadwal_di_X_IPA_1, jadwal_di_X_IPA_2], 'Fisika' => [...] ]
            $groupedSubjects = $learnings->groupBy('subject.nama_mapel');
        } else {
            // Logika untuk admin/wakasek jika diperlukan (misal: menampilkan semua mapel)
            // Untuk saat ini, kita fokus pada guru
        }

        return view('guru.mapel-diampu', compact('groupedSubjects'));
    }
}
