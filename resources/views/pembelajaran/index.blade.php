@extends('layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Pembelajaran</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Semua Data Pembelajaran</h4>
                <div class="card-header-action">
                    {{-- Tombol 'Buat Baru' hanya muncul untuk role tertentu, misal: admin atau kurikulum --}}
                    @if (Auth::user()->hasRole('wakamad kurikulum'))
                    <a href="{{ route('pembelajaran.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat baru
                    </a>
                    @endif
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-pembelajaran">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru Pengampu</th>
                                <th>Kelas</th>
                                <th>Tahun Ajaran / Semester</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Menggunakan variabel $pembelajaran yang dikirim dari controller --}}
                            @foreach ($learnings as $item)
                                <tr>
                                    {{-- Menggunakan $loop->iteration untuk penomoran --}}
                                    <td>{{ $loop->iteration }}</td>
                                    {{-- Menampilkan nama dari relasi mataPelajaran --}}
                                    <td>{{ $item->subject->nama_mapel ?? 'N/A' }}</td>
                                    {{-- Menampilkan nama dari relasi guru --}}
                                    <td>{{ $item->user->name ?? 'N/A' }}</td>
                                    {{-- Menampilkan nama dari relasi rombel (Rombongan Belajar) --}}
                                    <td>{{ $item->room->tingkat }}-{{ $item->room->rombongan }} {{ $item->room->nama_jurusan }}</td>
                                    {{-- Menampilkan periode dari relasi semester dan tahunAjaran --}}
                                    <td>{{ $item->academicPeriod->tahun_ajaran ?? '' }} {{ $item->academicPeriod->semester ?? '' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            {{-- Tombol Edit dan Hapus hanya untuk role tertentu --}}
                                            @if (Auth::user()->hasRole('wakamad kurikulum'))
                                            {{-- Tombol Edit --}}
                                            <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ route('pembelajaran.edit', $item->id) }}"
                                                class="btn btn-primary rounded ml-2"><i class="fas fa-edit"></i>
                                            </a>
                                            {{-- Tombol Hapus dengan konfirmasi --}}
                                            <a data-toggle="tooltip" data-placement="bottom" title="Hapus" href="{{ route('pembelajaran.destroy', $item->id) }}"
                                                class="btn btn-danger delete-item rounded ml-2"><i
                                                    class="fas fa-trash-alt"></i>
                                            </a>
                                            @endif
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
        // Inisialisasi DataTable untuk tabel pembelajaran
        $("#table-pembelajaran").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [5] // Menonaktifkan sorting untuk kolom 'Aksi' (kolom ke-6, index 5)
            }],
             // Mengurutkan berdasarkan Mata Pelajaran (kolom kedua, index 1) secara ascending (A-Z)
            "order": [[ 1, "asc" ]]
        });
    </script>
@endpush
