@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Unit Usaha</h1>
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