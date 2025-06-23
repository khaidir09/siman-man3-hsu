@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Anggota Ekstrakurikuler</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Buat Data Anggota Ekstrakurikuler Baru</h4>
            </div>
            <div class="card-body">
                {{-- Menambahkan enctype="multipart/form-data" untuk upload foto --}}
                <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nisn">Nomor Induk Siswa Nasional (NISN) <span class="text-danger">*</span></label>
                        <input name="nisn" id="nisn" type="text" class="form-control" value="{{ old('nisn') }}">
                        @error('nisn') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                        <input name="nama_lengkap" id="nama_lengkap" type="text" class="form-control" value="{{ old('nama_lengkap') }}">
                        @error('nama_lengkap') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status Siswa <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control">
                            <option value="Aktif" {{ old('status', 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Lulus" {{ old('status') == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                            <option value="Pindah" {{ old('status') == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                            <option value="Dikeluarkan" {{ old('status') == 'Dikeluarkan' ? 'selected' : '' }}>Dikeluarkan</option>
                        </select>
                        @error('status') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                     <div class="form-group">
                        <label for="room_id">Kelas <span class="text-danger">*</span></label>
                        <select name="room_id" id="room_id" class="form-control">
                            <option value="">Pilih Kelas</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }} class="text-uppercase">
                                    {{ $room->tingkat }} {{ $room->rombongan }} {{ $room->major->nama_jurusan ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('room_id') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Buat</button>
                </form>
            </div>
        </div>
    </section>
@endsection