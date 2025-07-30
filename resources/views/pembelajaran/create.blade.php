@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Pembelajaran</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Buat Data Pembelajaran Baru</h4>
            </div>
            <div class="card-body">
                {{-- Mengarahkan form action ke route store untuk pembelajaran --}}
                <form action="{{ route('pembelajaran.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            {{-- Input untuk memilih Mata Pelajaran --}}
                            <div class="form-group">
                                <label for="mapel_id">Mata Pelajaran <span class="text-danger">*</span></label>
                                <select name="subject_id" id="subject_id" class="form-control">
                                    <option value="">Pilih Mata Pelajaran</option>
                                    {{-- Asumsi Anda mengirimkan variabel $mataPelajaran dari controller --}}
                                    @foreach ($subjects as $mapel)
                                        <option value="{{ $mapel->id }}" {{ old('subject_id') == $mapel->id ? 'selected' : '' }}>
                                            {{ $mapel->nama_mapel }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            {{-- Input untuk memilih Guru Pengampu --}}
                            <div class="form-group">
                                <label for="user_id">Guru Pengampu <span class="text-danger">*</span></label>
                                <select name="user_id" id="user_id" class="form-control">
                                    <option value="">Pilih Guru</option>
                                    {{-- Asumsi Anda mengirimkan variabel $gurus dari controller --}}
                                    @foreach ($teachers as $guru)
                                        <option value="{{ $guru->id }}" {{ old('user_id') == $guru->id ? 'selected' : '' }}>
                                            {{ $guru->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {{-- Input untuk memilih Rombongan Belajar (Kelas) --}}
                            <div class="form-group">
                                <label for="room_id">Kelas (Rombongan Belajar) <span class="text-danger">*</span></label>
                                <select name="room_id" id="room_id" class="form-control">
                                    <option value="">Pilih Kelas</option>
                                     {{-- Asumsi Anda mengirimkan variabel $rombels dari controller --}}
                                    @foreach ($rooms as $rombel)
                                        <option value="{{ $rombel->id }}" {{ old('room_id') == $rombel->id ? 'selected' : '' }}>
                                            {{ $rombel->tingkat }}-{{ $rombel->rombongan }} {{ $rombel->nama_jurusan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            {{-- Input untuk memilih Periode Akademik --}}
                            <div class="form-group">
                                <label for="academic_period_id">Tahun Ajaran / Semester <span class="text-danger">*</span></label>
                                <select name="academic_period_id" id="academic_period_id" class="form-control">
                                    <option value="">Pilih Periode</option>
                                    {{-- Asumsi Anda mengirimkan variabel $semesters dari controller --}}
                                    @foreach ($academicPeriods as $semester)
                                        <option value="{{ $semester->id }}" {{ old('academic_period_id') == $semester->id ? 'selected' : '' }}>
                                            {{ $semester->tahun_ajaran }} - {{ $semester->semester }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('academic_period_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('pembelajaran.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </section>
@endsection
