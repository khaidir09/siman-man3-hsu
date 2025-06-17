@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Alumni</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Perbarui Data Alumni</h4>
            </div>
            <div class="card-body">
                {{-- Mengarahkan form action ke route update untuk alumni --}}
                <form action="{{ route('alumni.update', $alumni->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Method spoofing untuk update --}}

                    <div class="form-group">
                        <label for="no_induk">Nomor Induk</label>
                        {{-- Helper old() akan menampilkan input baru jika validasi gagal, jika tidak, tampilkan data dari database --}}
                        <input name="no_induk" id="no_induk" type="text" class="form-control" value="{{ old('no_induk', $alumni->no_induk) }}">
                        @error('no_induk')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama_siswa">Nama Siswa</label>
                        <input name="nama_siswa" id="nama_siswa" type="text" class="form-control" value="{{ old('nama_siswa', $alumni->nama_siswa) }}">
                        @error('nama_siswa')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input name="tempat_lahir" id="tempat_lahir" type="text" class="form-control" value="{{ old('tempat_lahir', $alumni->tempat_lahir) }}">
                        @error('tempat_lahir')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        {{-- Karena 'tanggal_lahir' di-cast sebagai objek Carbon, kita perlu format ke Y-m-d --}}
                        <input name="tanggal_lahir" type="date" value="{{ \Carbon\Carbon::parse($alumni->tanggal_lahir)->translatedFormat('Y-m-d') }}" class="form-control" >
                        @error('tanggal_lahir')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="rooms_id">Kelas Terakhir</label>
                        <select name="rooms_id" id="rooms_id" class="form-control">
                            <option value="">Pilih Kelas</option>
                            @foreach ($rooms as $room)
                                {{-- Kondisi untuk memilih kelas yang sesuai --}}
                                <option value="{{ $room->id }}" {{ old('rooms_id', $alumni->rooms_id) == $room->id ? 'selected' : '' }} class="text-uppercase">
                                    {{ $room->tingkat }} {{ $room->rombongan }} {{ $room->major->nama_jurusan ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('rooms_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="academic_periods_id">Tahun Lulus</label>
                        <select name="academic_periods_id" id="academic_periods_id" class="form-control">
                            <option value="">Pilih Tahun Lulus</option>
                            @foreach ($academicPeriods as $period)
                                {{-- Kondisi untuk memilih tahun lulus yang sesuai --}}
                                <option value="{{ $period->id }}" {{ old('academic_periods_id', $alumni->academic_periods_id) == $period->id ? 'selected' : '' }}>
                                    {{ $period->tahun_ajaran }} {{ $period->semester }}
                                </option>
                            @endforeach
                        </select>
                        @error('academic_periods_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="mt-3 mb-1">
                            <label for="melanjutkan">Melanjutkan</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="melanjutkan" id="" value="Kuliah" {{ $alumni->melanjutkan === 'Kuliah' ? 'checked' : '' }}>
                            <label class="form-check-label">Kuliah</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="melanjutkan" id="" value="Bekerja" {{ $alumni->melanjutkan === 'Bekerja' ? 'checked' : '' }}>
                            <label class="form-check-label">Bekerja</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="melanjutkan" id="" value="Tidak Ada" {{ $alumni->melanjutkan === 'Tidak Ada' ? 'checked' : '' }}>
                            <label class="form-check-label">Tidak Ada</label>
                        </div>
                        @error('melanjutkan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                        

                     <div class="form-group">
                        <label for="nama_tempat">Nama Tempat</label>
                        <input name="nama_tempat" id="nama_tempat" type="text" class="form-control" value="{{ old('nama_tempat', $alumni->nama_tempat) }}">
                        @error('nama_tempat')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </form>
            </div>
        </div>
    </section>
@endsection