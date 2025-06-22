<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Cooperative;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule; // Diperlukan untuk validasi 'in'

class KoperasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data transaksi, diurutkan dari yang terbaru
        $transactions = Cooperative::latest('tanggal')->latest('id')->get();
        return view('unit-usaha.index', compact('transactions'));
    }

    public function cetakKoperasi(Request $request)
    {
        $imagePath = public_path('images/kemenag.png');
        // 1. Validasi input dari form modal
        $validated = $request->validate([
            // Memastikan input 'month' ada dan formatnya YYYY-MM (misal: 2024-10)
            'bulan' => 'required|date_format:Y-m',
        ]);

        // 2. Ambil tahun dan bulan dari input
        $date = Carbon::createFromFormat('Y-m', $validated['bulan']);
        $year = $date->year;
        $month = $date->month;

        $saldoAwal = Cooperative::where('tanggal', '<', $date->startOfMonth())
            ->latest('tanggal')
            ->latest('id')
            ->first()
            ->jumlah_kas ?? 0;

        // 3. Ambil semua data yang diperlukan untuk laporan

        // Ganti 'BimbinganKonseling' dengan nama model Anda yang sebenarnya
        $koperasi = Cooperative::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->orderBy('tanggal', 'asc')
            ->get();

        $sisaKas = $koperasi->last()->jumlah_kas ?? $saldoAwal;

        // Ambil data kepala madrasah
        $kepalaMadrasah = User::role('kepala madrasah')->first();

        // Format periode laporan (contoh: OKTOBER 2024)
        $periodeFormatted = strtoupper(Carbon::createFromFormat('Y-m', $validated['bulan'])->locale('id')->translatedFormat('F Y'));

        // Format tanggal cetak (tanggal hari ini)
        $tanggalCetakFormatted = Carbon::now()->locale('id')->translatedFormat('d F Y');

        $totalPemasukan = Cooperative::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)->where('jenis_transaksi', 'Pemasukan')->sum('total');
        $totalPengeluaran = Cooperative::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)->where('jenis_transaksi', 'Pengeluaran')->sum('total');

        // 4. Kumpulkan semua data untuk dikirim ke view
        $data = [
            'imagePath' => $imagePath,
            'koperasi' => $koperasi,
            'kepala_madrasah' => $kepalaMadrasah,
            'periode' => $periodeFormatted,
            'tanggal_cetak' => $tanggalCetakFormatted,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'sisaKas' => $sisaKas,
            'judul_laporan' => "Laporan Bimbingan Konseling - " . $periodeFormatted,
        ];

        // 4. Render view ke dalam PDF menggunakan Dompdf
        $pdf = Pdf::loadView('unit-usaha.cetak', $data);

        // 5. Atur orientasi kertas (opsional, default portrait)
        $pdf->setPaper('a4', 'portrait');

        // 6. Tampilkan PDF di browser (stream) atau download
        return $pdf->stream('laporan-unit-usaha-' . $validated['bulan'] . '.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Untuk form create, kita mungkin perlu mengirim saldo kas terakhir
        $kasTerakhir = Cooperative::latest('tanggal')->latest('id')->first()->jumlah_kas ?? 0;
        return view('unit-usaha.create', compact('kasTerakhir'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data sesuai skema tabel cooperatives
        $validatedData = $request->validate([
            'jenis_transaksi' => ['required', Rule::in(['Pemasukan', 'Pengeluaran'])],
            'total' => 'required|numeric|min:1',
            'keterangan' => 'string|max:255|nullable',
            'tanggal' => 'required|date',
        ]);

        // === LOGIKA UNTUK MENGHITUNG SALDO BERJALAN (JUMLAH KAS) ===

        // 1. Dapatkan transaksi terakhir untuk mengetahui saldo kas sebelumnya.
        $transaksiTerakhir = Cooperative::latest('tanggal')->latest('id')->first();
        $kasSebelumnya = $transaksiTerakhir ? $transaksiTerakhir->jumlah_kas : 0;

        $totalTransaksi = (int) $validatedData['total'];

        // 2. Hitung jumlah kas sekarang berdasarkan jenis transaksi.
        if ($validatedData['jenis_transaksi'] === 'Pemasukan') {
            $kasSekarang = $kasSebelumnya + $totalTransaksi;
        } else { // Pengeluaran
            // Validasi tambahan agar pengeluaran tidak melebihi kas
            if ($totalTransaksi > $kasSebelumnya) {
                return redirect()->back()->withErrors(['total' => 'Jumlah pengeluaran tidak boleh melebihi jumlah kas saat ini.'])->withInput();
            }
            $kasSekarang = $kasSebelumnya - $totalTransaksi;
        }

        // 3. Simpan data ke database
        Cooperative::create([
            'jenis_transaksi' => $validatedData['jenis_transaksi'],
            'total' => $totalTransaksi,
            'keterangan' => $validatedData['keterangan'],
            'tanggal' => $validatedData['tanggal'],
            'jumlah_kas' => $kasSekarang, // Simpan hasil perhitungan kas
        ]);

        toast('Transaksi Koperasi berhasil dibuat.', 'success')->width('350');

        return redirect()->route('unit-usaha.index');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // === PERINGATAN PENTING ===
        // Sama seperti update, menghapus transaksi di tengah akan merusak
        // semua data saldo berjalan (jumlah_kas) setelahnya.
        // Untuk sistem sederhana, disarankan hanya mengizinkan penghapusan data terakhir.

        $transaction = Cooperative::findOrFail($id);
        $transaksiTerakhir = Cooperative::latest('tanggal')->latest('id')->first();

        // Logika sederhana: Hanya izinkan hapus data terakhir untuk menjaga integritas kas
        if ($transaction->id != $transaksiTerakhir->id) {
            toast('Hanya transaksi terakhir yang boleh dihapus untuk menjaga integritas data kas.', 'error')->width('450');
            return redirect()->back();
        }

        try {
            // Hapus record dari database
            $transaction->delete();

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
