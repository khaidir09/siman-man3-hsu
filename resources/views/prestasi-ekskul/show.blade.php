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
                                <div class="row">
                                    <div class="col-md-5">
                                        <label>Pilih Siswa</label>
                                        <select name="student_id" class="form-control" required>
                                            <option value="">Pilih Siswa untuk Ditambahkan</option>
                                            @foreach ($studentsForAdding as $student)
                                                <option value="{{ $student->id }}">{{ $student->nama_lengkap }} ({{ $student->nisn }})</option>
                                            @endforeach
                                        </select>
                                         @error('student_id') <p class="text-danger mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="col-md-5">
                                        <label>Pilih Jabatan</label>
                                        <select name="jabatan" class="form-control" required>
                                            <option value="Anggota">Anggota</option>
                                            <option value="Ketua">Ketua</option>
                                            <option value="Wakil Ketua">Wakil Ketua</option>
                                            <option value="Sekretaris">Sekretaris</option>
                                            <option value="Bendahara">Bendahara</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                        @error('jabatan') <p class="text-danger mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label>&nbsp;</label>
                                        <button class="btn btn-primary btn-block" type="submit">Tambah</button>
                                    </div>
                                </div>
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
                                            <th>Nilai</th>
                                            <th width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($ekstrakurikuler->students as $student)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $student->nama_lengkap }}</td>
                                                <td>{{ $student->room->tingkat ?? '' }}-{{ $student->room->rombongan ?? '' }}</td>
                                                {{-- Form untuk Update Jabatan dan Nilai --}}
                                                <form action="{{ route('ekstrakurikuler.updateMember', [$ekstrakurikuler->id, $student->id]) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <td>
                                                        <select name="jabatan" class="form-control form-control-sm">
                                                            <option value="Anggota" {{ $student->pivot->jabatan == 'Anggota' ? 'selected' : '' }}>Anggota</option>
                                                            <option value="Ketua" {{ $student->pivot->jabatan == 'Ketua' ? 'selected' : '' }}>Ketua</option>
                                                            <option value="Wakil Ketua" {{ $student->pivot->jabatan == 'Wakil Ketua' ? 'selected' : '' }}>Wakil Ketua</option>
                                                            <option value="Sekretaris" {{ $student->pivot->jabatan == 'Sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                                                            <option value="Bendahara" {{ $student->pivot->jabatan == 'Bendahara' ? 'selected' : '' }}>Bendahara</option>
                                                            <option value="Lainnya" {{ $student->pivot->jabatan == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="nilai" class="form-control form-control-sm">
                                                            <option value="">-- Beri Nilai --</option>
                                                            <option value="A" {{ $student->pivot->nilai == 'A' ? 'selected' : '' }}>A (Sangat Baik)</option>
                                                            <option value="B" {{ $student->pivot->nilai == 'B' ? 'selected' : '' }}>B (Baik)</option>
                                                            <option value="C" {{ $student->pivot->nilai == 'C' ? 'selected' : '' }}>C (Cukup)</option>
                                                            <option value="D" {{ $student->pivot->nilai == 'D' ? 'selected' : '' }}>D (Kurang)</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="submit" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Simpan Perubahan"><i class="fas fa-save"></i></button>
                                                </form> {{-- Form update ditutup di sini, SEBELUM form hapus --}}
                            
                                                {{-- Form untuk Hapus Anggota (sekarang berada di luar form update) --}}
                                                <form action="{{ route('ekstrakurikuler.removeMember', [$ekstrakurikuler->id, $student->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus anggota ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger ml-2" data-toggle="tooltip" title="Hapus Anggota"><i class="fas fa-user-times"></i></button>
                                                </form>
                                                        </div>
                                                    </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Belum ada anggota yang terdaftar.</td>
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
                                <a href="{{ route('achievements.create', ['ekskul_id' => $ekstrakurikuler->id]) }}" class="btn btn-primary">
                                    Tambah Prestasi
                                </a>
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