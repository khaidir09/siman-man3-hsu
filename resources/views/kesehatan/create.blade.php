@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Usaha Kesehatan Sekolah</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Buat Data Usaha Kesehatan Sekolah</h4>
            </div>
            <div class="card-body">
                {{-- Mengarahkan form action ke route store untuk kesehatan --}}
                <form action="{{ route('kesehatan.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                        {{-- Menambahkan helper old() untuk menjaga input jika ada error validasi --}}
                        <input name="tanggal" id="tanggal" type="date" class="form-control" value="{{ old('tanggal') }}">
                        @error('tanggal')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama_siswa">Nama Siswa <span class="text-danger">*</span></label>
                        <input name="nama_siswa" id="nama_siswa" type="text" class="form-control" value="{{ old('nama_siswa') }}">
                        @error('nama_siswa')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="rooms_id">Kelas <span class="text-danger">*</span></label>
                        {{-- Select untuk kelas tetap sama --}}
                        <select name="rooms_id" id="rooms_id" class="form-control">
                            <option value="">Pilih Kelas</option>
                            @foreach ($rooms as $room)
                                {{-- Menambahkan logika 'selected' dengan helper old() --}}
                                <option value="{{ $room->id }}" {{ old('rooms_id') == $room->id ? 'selected' : '' }} class="text-uppercase">
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
                        <input name="keluhan" id="keluhan" type="text" class="form-control" value="{{ old('keluhan') }}">
                        @error('keluhan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="hasil_pemeriksaan">Hasil Pemeriksaan <span class="text-danger">*</span></label>
                        {{-- Menggunakan textarea untuk input teks yang lebih panjang --}}
                        <textarea name="hasil_pemeriksaan" id="hasil_pemeriksaan" class="form-control" style="height: 100px;">{{ old('hasil_pemeriksaan') }}</textarea>
                        @error('hasil_pemeriksaan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="orang_tua">Orang Tua/Wali yang Dihubungi <span class="text-danger">*</span></label>
                        <input name="orang_tua" id="orang_tua" type="text" class="form-control" value="{{ old('orang_tua') }}">
                        @error('orang_tua')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" id="alamat" class="form-control" style="height: 100px;">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Buat</button>
                </form>
            </div>
        </div>
    </section>
@endsection