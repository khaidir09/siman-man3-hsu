@extends('layouts.master')

@section('title', 'Edit Data Pembelajaran')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Data Pembelajaran</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
            <div class="breadcrumb-item"><a href="{{ route('pembelajaran.index') }}">Data Pembelajaran</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Formulir Edit Data Pembelajaran</h4>
            </div>
            <div class="card-body">
                {{-- Arahkan form ke route 'update' dan gunakan method PATCH --}}
                <form action="{{ route('pembelajaran.update', $pembelajaran->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="row">
                        <div class="col-md-6">
                            {{-- Input untuk memilih Mata Pelajaran --}}
                            <div class="form-group">
                                <label for="subject_id">Mata Pelajaran <span class="text-danger">*</span></label>
                                <select name="subject_id" id="subject_id" class="form-control">
                                    <option value="">Pilih Mata Pelajaran</option>
                                    @foreach ($subjects as $mapel)
                                        {{-- Logika untuk memilih opsi yang sesuai --}}
                                        <option value="{{ $mapel->id }}" {{ old('subject_id', $pembelajaran->subject_id) == $mapel->id ? 'selected' : '' }}>
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
                                    @foreach ($teachers as $guru)
                                        <option value="{{ $guru->id }}" {{ old('user_id', $pembelajaran->user_id) == $guru->id ? 'selected' : '' }}>
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
                                    @foreach ($rooms as $rombel)
                                        <option value="{{ $rombel->id }}" {{ old('room_id', $pembelajaran->room_id) == $rombel->id ? 'selected' : '' }}>
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
                                    @foreach ($academicPeriods as $semester)
                                        <option value="{{ $semester->id }}" {{ old('academic_period_id', $pembelajaran->academic_period_id) == $semester->id ? 'selected' : '' }}>
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

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('pembelajaran.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection