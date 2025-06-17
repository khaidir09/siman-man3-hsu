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
            <h1>Data Alumni</h1>
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
                    <form action="{{ route('alumni.cetak') }}" method="POST" target="_blank">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Pilih Tahun Ajaran</label>
                                <select name="academic_periods_id" class="form-control" required>
                                    @foreach ($academicPeriods as $period)
                                        <option value="{{ $period->id }}">{{ $period->tahun_ajaran }} - {{ $period->semester }}</option>
                                    @endforeach
                                </select>
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
                <h4>Semua Data Alumni</h4>
                <div class="card-header-action">
                    {{-- Mengarahkan ke route untuk membuat data alumni baru --}}
                    <a href="{{ route('alumni.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat baru
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-sub">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tahun Lulus</th>
                                <th>Nomor Induk</th>
                                <th>Nama</th>
                                <th>Kelas Terakhir</th>
                                <th>Melanjutkan</th>
                                <th>Nama Tempat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Menggunakan variabel $alumni yang dikirim dari controller --}}
                            @foreach ($alumni as $item)
                                <tr>
                                    {{-- Menggunakan $loop->iteration untuk penomoran yang lebih baik --}}
                                    <td>{{ $loop->iteration }}</td>
                                    {{-- Menampilkan tahun pelajaran dari relasi academicPeriod --}}
                                    <td>{{ $item->academicPeriod->tahun_ajaran ?? 'N/A' }}</td>
                                    <td>{{ $item->no_induk }}</td>
                                    <td>{{ $item->nama_siswa }}</td>
                                    {{-- Menampilkan kelas terakhir dari relasi room --}}
                                    <td>
                                        {{-- Menambahkan null safe operator (??) untuk keamanan jika relasi/data kosong --}}
                                        {{ $item->room->tingkat ?? '' }}-{{ $item->room->rombongan ?? '' }} {{ $item->room->major->nama_jurusan ?? '' }}
                                    </td>
                                    <td>{{ $item->melanjutkan }}</td>
                                    <td>{{ $item->nama_tempat }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            {{-- Mengarahkan ke route edit untuk alumni --}}
                                            <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ route('alumni.edit', $item->id) }}"
                                                class="btn btn-primary rounded"><i class="fas fa-edit"></i>
                                            </a>
                                            {{-- Mengarahkan ke route destroy untuk alumni --}}
                                            <a data-toggle="tooltip" data-placement="bottom" title="Hapus" href="{{ route('alumni.destroy', $item->id) }}"
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
                "targets": [6] // Menonaktifkan sorting untuk kolom 'Aksi' (kolom ke-7, index 6)
            }],
            // Mengurutkan berdasarkan Tahun Lulus (kolom kedua, index 1) secara descending (terbaru dulu)
            "order": [[ 1, "desc" ]]
        });
    </script>
@endpush