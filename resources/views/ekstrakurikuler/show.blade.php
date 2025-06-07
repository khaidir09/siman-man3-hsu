@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            {{-- Breadcrumb --}}
            <div class="section-header-back">
                <a href="{{ route('ekstrakurikuler.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Detail Ekstrakurikuler</h1>
        </div>

        <div class="section-body">
            <div class="row">
                {{-- KARTU DETAIL UTAMA --}}
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $ekstrakurikuler->nama_ekskul }}</h4>
                            <div class="card-header-action">
                                <a href="{{ route('ekstrakurikuler.edit', $ekstrakurikuler->id) }}" class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <p><strong>Pembina:</strong> {{ $ekstrakurikuler->pembina->name ?? 'N/A' }}</p>
                            <p><strong>Tahun Ajaran:</strong> {{ $ekstrakurikuler->academicPeriod->tahun_ajaran ?? 'N/A' }}</p>
                            <p><strong>Jadwal:</strong> {{ $ekstrakurikuler->jadwal_hari }}, Pukul {{ \Carbon\Carbon::parse($ekstrakurikuler->jadwal_waktu)->format('H:i') }}</p>
                            <p><strong>Lokasi:</strong> {{ $ekstrakurikuler->lokasi }}</p>
                            <p><strong>Status:</strong>
                                @if ($ekstrakurikuler->status == 'Aktif')
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Tidak Aktif</span>
                                @endif
                            </p>
                            <hr>
                            <p><strong>Deskripsi:</strong><br>{{ $ekstrakurikuler->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                        </div>
                    </div>
                </div>

                {{-- KARTU MANAJEMEN ANGGOTA --}}
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Daftar Anggota</h4>
                        </div>
                        <div class="card-body">
                            {{-- FORM TAMBAH ANGGOTA --}}
                            <form action="{{ route('ekstrakurikuler.addMember', $ekstrakurikuler->id) }}" method="POST" class="mb-4">
                                @csrf
                                <div class="input-group">
                                    <select name="student_id" class="form-control" required>
                                        <option value="">Pilih Siswa untuk Ditambahkan</option>
                                        @foreach ($studentsForAdding as $student)
                                            <option value="{{ $student->id }}">{{ $student->nama_lengkap }} ({{ $student->nis }})</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">Tambah Anggota</button>
                                    </div>
                                </div>
                                @error('student_id') <p class="text-danger mt-1">{{ $message }}</p> @enderror
                            </form>

                            {{-- TABEL ANGGOTA --}}
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Siswa</th>
                                            <th>Kelas</th>
                                            <th>Jabatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($ekstrakurikuler->students as $student)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $student->nama_lengkap }}</td>
                                                <td>{{ $student->room->tingkat ?? '' }}-{{ $student->room->rombongan ?? '' }}</td>
                                                <td>{{ $student->pivot->jabatan }}</td>
                                                <td>
                                                    {{-- FORM HAPUS ANGGOTA --}}
                                                    <form action="{{ route('ekstrakurikuler.removeMember', [$ekstrakurikuler->id, $student->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus anggota ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus Anggota"><i class="fas fa-user-times"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Belum ada anggota yang terdaftar.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KARTU PRESTASI (Contoh) --}}
            <div class="row">
                <div class="col-12">
                     <div class="card">
                        <div class="card-header">
                            <h4>Prestasi yang Diraih</h4>
                             <div class="card-header-action">
                                {{-- Tombol ini bisa diarahkan ke form tambah prestasi --}}
                                <a href="#" class="btn btn-primary">Tambah Prestasi</a>
                            </div>
                        </div>
                        <div class="card-body">
                             <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tahun</th>
                                            <th>Nama Prestasi</th>
                                            <th>Tingkat</th>
                                            <th>Penyelenggara</th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                         @forelse ($ekstrakurikuler->achievements as $achievement)
                                             <tr>
                                                 <td>{{ $achievement->tahun }}</td>
                                                 <td>{{ $achievement->nama_prestasi }}</td>
                                                 <td>{{ $achievement->tingkat }}</td>
                                                 <td>{{ $achievement->penyelenggara }}</td>
                                             </tr>
                                         @empty
                                             <tr>
                                                 <td colspan="4" class="text-center">Belum ada prestasi yang dicatat.</td>
                                             </tr>
                                         @endforelse
                                     </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection