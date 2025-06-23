@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Anggota Ekstrakurikuler</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Perbarui Data Anggota Ekstrakurikuler</h4>
            </div>
            <div class="card-body">
                {{-- Mengarahkan form action ke route update untuk siswa --}}
                <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Method spoofing untuk update --}}

                    <div class="form-group">
                        <label for="nisn">Nomor Induk Siswa Nasional (NISN) <span class="text-danger">*</span></label>
                        {{-- Helper old() akan menampilkan input baru jika validasi gagal, jika tidak, tampilkan data dari database --}}
                        <input name="nisn" id="nisn" type="text" class="form-control" value="{{ old('nisn', $siswa->nisn) }}">
                        @error('nisn')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                        <input name="nama_lengkap" id="nama_lengkap" type="text" class="form-control" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}">
                        @error('nama_lengkap')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="room_id">Kelas <span class="text-danger">*</span></label>
                        <select name="room_id" id="room_id" class="form-control">
                            <option value="">Pilih Kelas</option>
                            @foreach ($rooms as $room)
                                {{-- Kondisi untuk memilih kelas yang sesuai --}}
                                <option value="{{ $room->id }}" {{ old('room_id', $siswa->room_id) == $room->id ? 'selected' : '' }} class="text-uppercase">
                                    {{ $room->tingkat }} {{ $room->rombongan }} {{ $room->major->nama_jurusan ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('room_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status Siswa <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control">
                            <option value="Aktif" {{ old('status', $siswa->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Lulus" {{ old('status', $siswa->status) == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                            <option value="Pindah" {{ old('status', $siswa->status) == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                            <option value="Dikeluarkan" {{ old('status', $siswa->status) == 'Dikeluarkan' ? 'selected' : '' }}>Dikeluarkan</option>
                        </select>
                        @error('status')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </form>
            </div>
        </div>
    </section>
@endsection