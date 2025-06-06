@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Alumni</h1>
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
                                <th>Melanjutkan Ke</th>
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