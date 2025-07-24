@extends('layouts.master')

@section('title', 'Buat Data Ujian Baru')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Kelola Data Ujian</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
            <div class="breadcrumb-item"><a href="{{ route('ujian.index') }}">Data Ujian</a></div>
            <div class="breadcrumb-item">Buat Baru</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Formulir Pembuatan Ujian Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('ujian.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        {{-- Kolom Kiri --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="mt-3 mb-1">Nama Ujian <span class="text-danger">*</span></div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="name" id="" value="Ujian Akhir Semester">
                                    <label class="form-check-label">Ujian Akhir Semester</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="name" id="" value="Ujian Tengah Semester">
                                    <label class="form-check-label">Ujian Tengah Semester</label>
                                </div>
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="subject_id">Mata Pelajaran <span class="text-danger">*</span></label>
                                <select name="subject_id" id="subject_id" class="form-control" required>
                                    <option value="">-- Pilih Mata Pelajaran --</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->nama_mapel }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="room_id">Kelas <span class="text-danger">*</span></label>
                                <select name="room_id" id="room_id" class="form-control" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                            {{ $room->tingkat }}-{{ $room->rombongan }} {{ $room->nama_jurusan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Kolom Kanan --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="teacher_id">Guru Penanggung Jawab <span class="text-danger">*</span></label>
                                
                                @if(Auth::user()->hasRole('wakasek kurikulum'))
                                    {{-- JIKA WAKASEK: TAMPILKAN DROPDOWN --}}
                                    <select name="teacher_id" id="teacher_id" class="form-control" required>
                                        <option value="">-- Pilih Guru --</option>
                                        @foreach ($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                                {{ $teacher->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    {{-- JIKA GURU: TAMPILKAN NAMA SENDIRI & DISABLED --}}
                                    <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                                    {{-- KIRIM ID GURU SECARA TERSEMBUNYI --}}
                                    <input type="hidden" name="teacher_id" value="{{ Auth::user()->id }}">
                                @endif

                                @error('teacher_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                             <div class="form-group">
                                <label for="academic_period_id">Periode Ajaran <span class="text-danger">*</span></label>
                                <select name="academic_period_id" id="academic_period_id" class="form-control" required>
                                    <option value="">-- Pilih Periode Ajaran --</option>
                                    @foreach ($academicPeriods as $period)
                                        <option value="{{ $period->id }}" {{ old('academic_period_id') == $period->id ? 'selected' : '' }}>
                                            {{ $period->tahun_ajaran }} ({{ $period->semester }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('academic_period_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exam_date">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                                <input type="date" id="exam_date" name="exam_date" class="form-control" value="{{ old('exam_date') }}" required>
                                @error('exam_date')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('ujian.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection