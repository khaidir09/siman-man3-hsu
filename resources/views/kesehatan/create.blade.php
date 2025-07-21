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
                        <label for="">Nama Siswa <span class="text-danger">*</span></label>
                        <select name="student_id" class="form-control">
                            <option value="">Pilih Siswa</option>
                            @foreach ($siswa as $siswa)
                                <option value="{{ $siswa->id }}" class="text-uppercase">{{ $siswa->nama_lengkap }} ({{ $siswa->room->tingkat }} {{ $siswa->room->rombongan }} {{ $siswa->room->nama_jurusan }})</option>
                            @endforeach
                        </select>
                        @error('student_id')
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