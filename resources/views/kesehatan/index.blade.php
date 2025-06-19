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
            <h1>Usaha Kesehatan Sekolah</h1>
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
                    <form action="{{ route('kesehatan.cetak') }}" method="POST" target="_blank">
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
                <h4>Semua Usaha Kesehatan Sekolah</h4>
                <div class="card-header-action">
                    {{-- Mengarahkan ke route untuk membuat data kesehatan baru --}}
                    <a href="{{ route('kesehatan.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat baru
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-sub">
                        <thead>
                            <tr>
                                <th>
                                    No.
                                </th>
                                <th>Tanggal</th>
                                <th>Nama Siswa/Ortu</th>
                                <th>Kelas</th>
                                <th>Alamat</th>
                                <th>Keluhan</th>
                                <th>Hasil Pemeriksaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Menggunakan variabel $kesehatan yang dikirim dari controller --}}
                            @foreach ($kesehatan as $item)
                                <tr>
                                    {{-- Menggunakan $loop->iteration untuk penomoran yang lebih baik --}}
                                    <td>{{ $loop->iteration }}</td>
                                    {{-- Formatting tanggal tetap sama --}}
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d F Y') }}</td>
                                    <td>{{ $item->nama_siswa }}/{{ $item->orang_tua }}</td>
                                    {{-- Menampilkan kelas dari relasi 'room' --}}
                                    <td>
                                        {{-- Menambahkan null safe operator (??) untuk keamanan jika relasi/data kosong --}}
                                        {{ $item->room->tingkat ?? '' }}-{{ $item->room->rombongan ?? '' }} {{ $item->room->major->nama_jurusan ?? '' }}
                                    </td>
                                    <td>{!! $item->alamat !!}</td>
                                    {{-- Menampilkan data spesifik untuk kesehatan --}}
                                    <td>{{ $item->keluhan }}</td>
                                    <td>{!! $item->hasil_pemeriksaan !!}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            {{-- Mengarahkan ke route edit untuk kesehatan --}}
                                            <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ route('kesehatan.edit', $item->id) }}"
                                                class="btn btn-primary rounded"><i class="fas fa-edit"></i>
                                            </a>
                                            {{-- Mengarahkan ke route destroy untuk kesehatan --}}
                                            <a data-toggle="tooltip" data-placement="bottom" title="Hapus" href="{{ route('kesehatan.destroy', $item->id) }}"
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
        // Inisialisasi DataTable tetap sama, id tabel tidak berubah
        $("#table-sub").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [7] // Sesuaikan target jika jumlah kolom berubah (Aksi di kolom ke-7, index 6)
            }],
            // Mengurutkan berdasarkan tanggal (kolom kedua, index 1) secara descending (terbaru dulu)
            "order": [[ 1, "desc" ]]
        });
    </script>
@endpush