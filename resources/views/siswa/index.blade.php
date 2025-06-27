@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Anggota Ekstrakurikuler</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Semua Data Anggota Ekstrakurikuler</h4>
                <div class="card-header-action">
                    @if (Auth::user()->hasRole('pembina ekskul'))
                    <a href="{{ route('siswa.create') }}" class="btn btn-primary">
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
                                <th>NISN</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Status</th>
                                @if (Auth::user()->hasRole('pembina ekskul'))
                                <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Menggunakan variabel $students yang dikirim dari controller --}}
                            @foreach ($students as $student)
                                <tr>
                                    {{-- Menggunakan $loop->iteration untuk penomoran yang rapi --}}
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $student->nisn }}</td>
                                    <td>{{ $student->nama_lengkap }}</td>
                                    {{-- Menampilkan kelas dari relasi 'room' --}}
                                    <td>
                                        @if($student->room)
                                            {{ $student->room->tingkat }}-{{ $student->room->rombongan }} {{ $student->room->nama_jurusan }}
                                        @else
                                            <span class="text-muted">Belum ada kelas</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- Memberi warna berbeda untuk setiap status --}}
                                        @if ($student->status == 'Aktif')
                                            <span class="badge badge-success">{{ $student->status }}</span>
                                        @elseif ($student->status == 'Lulus')
                                            <span class="badge badge-secondary">{{ $student->status }}</span>
                                        @elseif ($student->status == 'Pindah')
                                            <span class="badge badge-warning">{{ $student->status }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ $student->status }}</span>
                                        @endif
                                    </td>
                                    @if (Auth::user()->hasRole('pembina ekskul'))
                                    <td>
                                        <div class="btn-group" role="group">
                                            {{-- Tombol Edit --}}
                                            <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ route('siswa.edit', $student->id) }}"
                                                class="btn btn-primary rounded ml-2"><i class="fas fa-edit"></i>
                                            </a>
                                            {{-- Tombol Hapus --}}
                                            <a data-toggle="tooltip" data-placement="bottom" title="Hapus" href="{{ route('siswa.destroy', $student->id) }}"
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
                "targets": [5] // Menonaktifkan sorting untuk kolom 'Aksi' (kolom ke-6, index 5)
            }],
            // Mengurutkan berdasarkan Nama Siswa (kolom ketiga, index 2) secara ascending (A-Z)
            "order": [[ 2, "asc" ]]
        });
    </script>
@endpush