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
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="learning_id">Pembelajaran <span class="text-danger">*</span></label>
                                <select name="learning_id" id="learning_id" class="form-control" required>
                                    <option value="">-- Pilih Pembelajaran --</option>
                                    @foreach ($learnings as $item)
                                        <option value="{{ $item->id }}" {{ old('learning_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->subject->nama_mapel }} - {{ $item->user->name }} (Kelas {{ $item->room->tingkat }}-{{ $item->room->rombongan }} {{ $item->room->major->nama_jurusan ?? '' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('learning_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Kolom Kanan --}}
                        <div class="col-md-6">
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