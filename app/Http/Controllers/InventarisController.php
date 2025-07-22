<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Infrastructure;
use Barryvdh\DomPDF\Facade\Pdf;

class InventarisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $infrastructures = Infrastructure::all();
        return view('inventaris.index', compact('infrastructures'));
    }

    public function cetakInventaris(Request $request)
    {
        $imagePath = public_path('images/kemenag.png');
        // 1. Validasi input dari form modal
        $validated = $request->validate([
            // Memastikan input 'month' ada dan formatnya YYYY-MM (misal: 2024-10)
            'bulan' => 'required|date_format:Y-m',
        ]);

        // 2. Ambil tahun dan bulan dari input
        $year = Carbon::createFromFormat('Y-m', $validated['bulan'])->year;
        $month = Carbon::createFromFormat('Y-m', $validated['bulan'])->month;

        // 3. Ambil semua data yang diperlukan untuk laporan

        // Ganti 'BimbinganKonseling' dengan nama model Anda yang sebenarnya
        $inventaris = Infrastructure::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('created_at', 'asc')
            ->get();

        // Ambil data kepala madrasah
        $kepalaMadrasah = User::role('kepala madrasah')->first();

        // Format periode laporan (contoh: OKTOBER 2024)
        $periodeFormatted = strtoupper(Carbon::createFromFormat('Y-m', $validated['bulan'])->locale('id')->translatedFormat('F Y'));

        // Format tanggal cetak (tanggal hari ini)
        $tanggalCetakFormatted = Carbon::now()->locale('id')->translatedFormat('d F Y');

        // 4. Kumpulkan semua data untuk dikirim ke view
        $data = [
            'imagePath' => $imagePath,
            'inventaris' => $inventaris,
            'kepala_madrasah' => $kepalaMadrasah,
            'periode' => $periodeFormatted,
            'tanggal_cetak' => $tanggalCetakFormatted,
            'judul_laporan' => "Laporan Inventaris - " . $periodeFormatted,
        ];

        // 4. Render view ke dalam PDF menggunakan Dompdf
        $pdf = Pdf::loadView('inventaris.cetak', $data);

        // 5. Atur orientasi kertas (opsional, default portrait)
        $pdf->setPaper('a4', 'portrait');

        // 6. Tampilkan PDF di browser (stream) atau download
        return $pdf->stream('laporan-inventaris-' . $validated['bulan'] . '.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventaris.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'jenis_kegiatan' => 'required|string|max:255',
            'item' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
            'biaya' => 'required|numeric'
        ]);

        $totalBiaya = $request->input('jumlah') * $request->input('biaya');

        // Create a new infrastructure
        Infrastructure::create([
            'jenis_kegiatan' => $request->input('jenis_kegiatan'),
            'item' => $request->input('item'),
            'jumlah' => $request->input('jumlah'),
            'satuan' => $request->input('satuan'),
            'biaya' => $request->input('biaya'),
            'total_biaya' => $totalBiaya,
        ]);

        toast('Inventaris berhasil dibuat.', 'success')->width('350');

        return redirect()->route('inventaris.index');
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
        $infrastructure = Infrastructure::findOrFail($id);

        return view('inventaris.edit', compact('infrastructure'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $infrastructure = Infrastructure::findOrFail($id);

        // Validate the request data
        $request->validate([
            'jenis_kegiatan' => 'required|string|max:255',
            'item' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'biaya' => 'required|numeric'
        ]);

        $totalBiaya = $request->input('jumlah') * $request->input('biaya');

        // Create a new infrastructure
        $infrastructure->update([
            'jenis_kegiatan' => $request->input('jenis_kegiatan'),
            'item' => $request->input('item'),
            'jumlah' => $request->input('jumlah'),
            'satuan' => $request->input('satuan'),
            'biaya' => $request->input('biaya'),
            'total_biaya' => $totalBiaya,
        ]);

        toast('Inventaris berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('inventaris.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $infrastructure = Infrastructure::findOrFail($id);

        try {
            // Hapus record dari database
            $infrastructure->delete();

            // Kembalikan respons dalam format JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Data Kelas Berhasil Dihapus!'
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
