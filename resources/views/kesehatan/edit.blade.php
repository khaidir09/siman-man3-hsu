@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Usaha Kesehatan Sekolah</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Perbarui Data Usaha Kesehatan Sekolah</h4>
            </div>
            <div class="card-body">
                {{-- Mengarahkan form action ke route update untuk kesehatan, dengan ID data yang diedit --}}
                <form action="{{ route('kesehatan.update', $kesehatan->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Method spoofing untuk update --}}

                    <div class="form-group">
                        <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                        {{-- Helper old() akan menampilkan input baru jika validasi gagal, jika tidak, tampilkan data dari database --}}
                        <input name="tanggal" id="tanggal" type="date" class="form-control" value="{{ old('tanggal', $kesehatan->tanggal) }}">
                        @error('tanggal')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama_siswa">Nama Siswa <span class="text-danger">*</span></label>
                        <input name="nama_siswa" id="nama_siswa" type="text" class="form-control" value="{{ old('nama_siswa', $kesehatan->nama_siswa) }}">
                        @error('nama_siswa')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="rooms_id">Kelas <span class="text-danger">*</span></label>
                        <select name="rooms_id" id="rooms_id" class="form-control">
                            <option value="">Pilih Kelas</option>
                            @foreach ($rooms as $room)
                                {{-- Kondisi untuk memilih kelas yang sesuai --}}
                                <option value="{{ $room->id }}" {{ old('rooms_id', $kesehatan->rooms_id) == $room->id ? 'selected' : '' }} class="text-uppercase">
                                    {{ $room->tingkat }} {{ $room->rombongan }} {{ $room->major->nama_jurusan ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('rooms_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="keluhan">Keluhan <span class="text-danger">*</span></label>
                        <input name="keluhan" id="keluhan" type="text" class="form-control" value="{{ old('keluhan', $kesehatan->keluhan) }}">
                        @error('keluhan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="hasil_pemeriksaan">Hasil Pemeriksaan <span class="text-danger">*</span></label>
                        <textarea name="hasil_pemeriksaan" id="hasil_pemeriksaan" class="form-control" style="height: 100px;">{{ old('hasil_pemeriksaan', $kesehatan->hasil_pemeriksaan) }}</textarea>
                        @error('hasil_pemeriksaan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="orang_tua">Orang Tua/Wali yang Dihubungi <span class="text-danger">*</span></label>
                        <input name="orang_tua" id="orang_tua" type="text" class="form-control" value="{{ old('orang_tua', $kesehatan->orang_tua) }}">
                        @error('orang_tua')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" id="alamat" class="form-control" style="height: 100px;">{{ old('alamat', $kesehatan->alamat) }}</textarea>
                        @error('alamat')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </form>
            </div>
        </div>
    </section>
@endsection