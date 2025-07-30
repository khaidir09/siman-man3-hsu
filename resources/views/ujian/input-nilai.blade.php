@extends('layouts.master')

@section('title', 'Input Nilai Ujian')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Input Nilai Ujian</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
            <div class="breadcrumb-item"><a href="{{ route('ujian.index') }}">Data Ujian</a></div>
            <div class="breadcrumb-item">Input Nilai</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div>
                    <h4>Formulir Nilai: {{ $exam->name }}</h4>
                    <p class="mb-0 text-muted">
                        Mata Pelajaran: <strong>{{ $exam->learning->subject->nama_mapel }}</strong> |
                        Kelas: <strong>{{ $exam->learning->room->tingkat }}-{{ $exam->learning->room->rombongan }} {{ $exam->learning->room->nama_jurusan }}</strong> |
                        Tanggal: <strong>{{ \Carbon\Carbon::parse($exam->exam_date)->locale('id')->translatedFormat('d F Y') }}</strong>
                    </p>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('simpan-nilai-ujian', $exam->id) }}" method="POST">
                    @csrf
                    @method('PATCH') {{-- Method untuk route update --}}

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 5%;">No</th>
                                    <th>Nama Siswa</th>
                                    <th style="width: 20%;">Nilai (0-100)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $student->nama_lengkap }}</td>
                                    <td>
                                        <input type="number"
                                               name="scores[{{ $student->id }}]"
                                               class="form-control text-center"
                                               min="0"
                                               max="100"
                                               step="0.5"
                                               placeholder="0.00"
                                               {{-- Mengisi nilai yang sudah ada jika sedang mengedit --}}
                                               value="{{ $existingScores[$student->id] ?? '' }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan Semua Nilai
                        </button>
                        <a href="{{ route('ujian.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection