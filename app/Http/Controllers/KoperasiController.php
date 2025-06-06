<?php

namespace App\Http\Controllers;

use App\Models\Cooperative;
use Illuminate\Http\Request;
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

        $transaction->delete();

        toast('Data Transaksi berhasil dihapus.', 'success')->width('350');

        return redirect()->route('unit-usaha.index');
    }
}
