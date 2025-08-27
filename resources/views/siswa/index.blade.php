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
            <h1>Data Siswa</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Semua Data Siswa</h4>
                <div class="card-header-action">
                    @if (Auth::user()->hasRole('kepala madrasah'))
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
                                <th>Aksi</th>
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
                                    <td>
                                        <div class="btn-group" role="group">
                                            {{-- Tombol Edit --}}
                                            <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ route('siswa.edit', $student->id) }}"
                                                class="btn btn-primary rounded"><i class="fas fa-edit"></i>
                                            </a>
                                            {{-- Tombol Pindah Kelas --}}
                                            <button class="btn btn-warning rounded ml-2" data-toggle="modal" data-target="#pindahKelasModal">Pindah Kelas</button>
                                            {{-- Tombol Hapus --}}
                                            <a data-toggle="tooltip" data-placement="bottom" title="Hapus" href="{{ route('siswa.destroy', $student->id) }}"
                                                class="btn btn-danger delete-item rounded ml-2"><i
                                                    class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="pindahKelasModal" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Pindahkan Siswa: {{ $student->nama_lengkap }}</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <form action="{{ route('siswa.transfer', $student->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <p>Kelas Saat Ini: <strong>{{ $student->room->name }}</strong></p>
                                                    <div class="form-group">
                                                        <label>Pindahkan Ke Kelas</label>
                                                        <select name="to_room_id" class="form-control" required>
                                                            @foreach($rooms as $room)
                                                                <option value="{{ $room->id }}">{{ $room->tingkat }}-{{ $room->rombongan }} {{ $room->nama_jurusan }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tanggal Pindah</label>
                                                        <input type="date" name="transfer_date" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Alasan (Opsional)</label>
                                                        <textarea name="reason" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
            "order": [[ 0, "asc" ]]
        });
    </script>
@endpush