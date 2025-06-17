@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Alumni</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Buat Data Alumni Baru</h4>
            </div>
            <div class="card-body">
                {{-- Mengarahkan form action ke route store untuk alumni --}}
                <form action="{{ route('alumni.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="no_induk">Nomor Induk <span class="text-danger">*</span></label>
                        {{-- Menambahkan helper old() untuk menjaga input jika ada error validasi --}}
                        <input name="no_induk" id="no_induk" type="text" class="form-control" value="{{ old('no_induk') }}">
                        @error('no_induk')
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
                        <label for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                        <input name="tempat_lahir" id="tempat_lahir" type="text" class="form-control" value="{{ old('tempat_lahir') }}">
                        @error('tempat_lahir')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input name="tanggal_lahir" id="tanggal_lahir" type="date" class="form-control" value="{{ old('tanggal_lahir') }}">
                        @error('tanggal_lahir')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="rooms_id">Kelas Terakhir <span class="text-danger">*</span></label>
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
                        <label for="academic_periods_id">Tahun Lulus <span class="text-danger">*</span></label>
                        <select name="academic_periods_id" id="academic_periods_id" class="form-control">
                            <option value="">Pilih Tahun Lulus</option>
                            @foreach ($academicPeriods as $period)
                                {{-- Menambahkan logika 'selected' dengan helper old() --}}
                                <option value="{{ $period->id }}" {{ old('academic_periods_id') == $period->id ? 'selected' : '' }}>
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
                            <label for="melanjutkan">Melanjutkan <span class="text-danger">*</span></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="melanjutkan" id="" value="Kuliah" checked>
                            <label class="form-check-label">Kuliah</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="melanjutkan" id="" value="Bekerja">
                            <label class="form-check-label">Bekerja</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="melanjutkan" id="" value="Tidak Ada">
                            <label class="form-check-label">Tidak Ada</label>
                        </div>
                        @error('melanjutkan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama_tempat">Nama Tempat</label>
                        <input name="nama_tempat" id="nama_tempat" type="text" class="form-control" value="{{ old('nama_tempat') }}">
                        @error('nama_tempat')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Buat</button>
                </form>
            </div>
        </div>
    </section>
@endsection