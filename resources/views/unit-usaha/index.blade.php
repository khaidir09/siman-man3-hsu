@extends('layouts.master')

@push('style')
    <style>
        .modal-backdrop {
            position: relative;
        }
    </style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Unit Usaha</h1>
            <div class="section-header-action ml-auto">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#printModal">
                    <i class="fas fa-print"></i> Cetak Laporan
                </a>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="printModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cetak Laporan Prestasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- Form untuk mengirim data filter cetak --}}
                    <form action="{{ route('unit-usaha.cetak') }}" method="POST" target="_blank">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Bulan</label>
                                <input type="month" name="bulan" id="" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Cetak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Semua Transaksi Unit Usaha</h4>
                <div class="card-header-action">
                    {{-- Mengarahkan ke route untuk membuat transaksi koperasi baru --}}
                    <a href="{{ route('unit-usaha.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat Baru
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-sub">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Jenis Transaksi</th>
                                <th>Keterangan</th>
                                <th>Total</th>
                                <th>Saldo Kas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Menggunakan variabel $transactions yang dikirim dari controller --}}
                            @foreach ($transactions as $item)
                                <tr>
                                    {{-- Menggunakan $loop->iteration untuk penomoran yang rapi --}}
                                    <td>{{ $loop->iteration }}</td>
                                    {{-- Formatting tanggal --}}
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d F Y') }}</td>
                                    <td>
                                        {{-- Memberi warna berbeda untuk Pemasukan dan Pengeluaran --}}
                                        @if ($item->jenis_transaksi == 'Pemasukan')
                                            <span class="badge badge-success">{{ $item->jenis_transaksi }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ $item->jenis_transaksi }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->keterangan)
                                            {{ $item->keterangan }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    {{-- Formatting angka menjadi format Rupiah --}}
                                    <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($item->jumlah_kas, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            {{-- Mengarahkan ke route destroy untuk koperasi --}}
                                            {{-- Ingat: Logika hapus pada controller hanya mengizinkan hapus data terakhir --}}
                                            <a data-toggle="tooltip" data-placement="bottom" title="Hapus" href="{{ route('unit-usaha.destroy', $item->id) }}"
                                                class="btn btn-danger delete-item rounded ml-2"><i
                                                    class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Inisialisasi DataTable
        $("#table-sub").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [6] // Menonaktifkan sorting untuk kolom 'Aksi' (kolom ke-7, index 6)
            }],
             // Controller sudah mengurutkan data dari yang terbaru,
             // jadi ordering di sisi client bisa dinonaktifkan atau disesuaikan jika perlu.
             // "order": [[ 1, "desc" ]] // Contoh jika ingin urutkan berdasarkan Tanggal descending
        });
    </script>
@endpush