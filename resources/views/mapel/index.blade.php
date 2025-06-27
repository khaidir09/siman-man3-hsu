@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Mata Pelajaran</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Semua Data Mata Pelajaran</h4>
                <div class="card-header-action">
                    @if (Auth::user()->hasRole('wakamad kurikulum'))
                    <a href="{{ route('mapel.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat baru
                    </a>
                    @endif
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-sub">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Mata Pelajaran</th>
                                <th>Kode Mapel</th>
                                <th>Kelompok</th>
                                @if (Auth::user()->hasRole('wakamad kurikulum'))
                                <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Menggunakan variabel $subjects yang dikirim dari controller --}}
                            @foreach ($subjects as $subject)
                                <tr>
                                    {{-- Menggunakan $loop->iteration untuk penomoran --}}
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $subject->nama_mapel }}</td>
                                    {{-- Menggunakan null coalescing operator untuk menampilkan '-' jika kode kosong --}}
                                    <td>{{ $subject->kode_mapel ?? '-' }}</td>
                                    <td>Kelompok {{ $subject->kelompok_mapel }}</td>
                                    @if (Auth::user()->hasRole('wakamad kurikulum'))
                                    <td>
                                        <div class="btn-group" role="group">
                                            {{-- Tombol Edit --}}
                                            <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ route('mapel.edit', $subject->id) }}"
                                                class="btn btn-primary rounded"><i class="fas fa-edit"></i>
                                            </a>
                                            {{-- Tombol Hapus (akan memicu SweetAlert dari script master Anda) --}}
                                            <a data-toggle="tooltip" data-placement="bottom" title="Hapus" href="{{ route('mapel.destroy', $subject->id) }}"
                                                class="btn btn-danger delete-item rounded ml-2"><i
                                                    class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                    @endif
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
                "targets": [4] // Menonaktifkan sorting untuk kolom 'Aksi' (kolom ke-5, index 4)
            }],
            // Mengurutkan berdasarkan Nama Mata Pelajaran (kolom kedua, index 1) secara ascending (A-Z)
            "order": [[ 1, "asc" ]]
        });
    </script>
@endpush