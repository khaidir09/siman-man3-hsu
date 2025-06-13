@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Mata Pelajaran</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Perbarui Data Mata Pelajaran</h4>
            </div>
            <div class="card-body">
                {{-- Mengarahkan form action ke route update untuk mata pelajaran --}}
                <form action="{{ route('mapel.update', $subject->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Method spoofing untuk update --}}

                    <div class="form-group">
                        <label for="nama_mapel">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                        {{-- Helper old() akan menampilkan input baru jika validasi gagal, jika tidak, tampilkan data dari database --}}
                        <input name="nama_mapel" id="nama_mapel" type="text" class="form-control" value="{{ old('nama_mapel', $subject->nama_mapel) }}">
                        @error('nama_mapel')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kode_mapel">Kode Mata Pelajaran (Opsional)</label>
                        <input name="kode_mapel" id="kode_mapel" type="text" class="form-control" value="{{ old('kode_mapel', $subject->kode_mapel) }}">
                        @error('kode_mapel')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kelompok_mapel">Kelompok Mata Pelajaran <span class="text-danger">*</span></label>
                        <select name="kelompok_mapel" id="kelompok_mapel" class="form-control">
                            <option value="">Pilih Kelompok</option>
                            {{-- Kondisi untuk memilih kelompok yang sesuai --}}
                            <option value="A" {{ old('kelompok_mapel', $subject->kelompok_mapel) == 'A' ? 'selected' : '' }}>A - Umum</option>
                            <option value="B" {{ old('kelompok_mapel', $subject->kelompok_mapel) == 'B' ? 'selected' : '' }}>B - Kejuruan</option>
                            <option value="C" {{ old('kelompok_mapel', $subject->kelompok_mapel) == 'C' ? 'selected' : '' }}>C - Peminatan</option>
                        </select>
                        @error('kelompok_mapel')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </form>
            </div>
        </div>
    </section>
@endsection