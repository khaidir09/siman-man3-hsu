@extends('layouts.master')
@section('title', 'Finalisasi Nilai Akhir')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Finalisasi Nilai Akhir</h1>
    </div>
    <div class="card card-primary">
        <div class="card-header">
            <h4>
                {{-- Gunakan $learning --}}
                {{ $learning->subject->nama_mapel }} - Kelas {{ $learning->room->tingkat }}-{{ $learning->room->rombongan }} {{ $learning->room->nama_jurusan ?? '' }}
                <br><small class="text-muted">{{ $learning->academicPeriod->semester }} {{ $learning->academicPeriod->tahun_ajaran }}</small>
            </h4>
        </div>
        <div class="card-body">
        {{-- Arahkan ke route yang benar dengan parameter $learning --}}
        <form action="{{ route('nilai-akhir.store', $learning->id) }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th class="text-center">Nilai Akhir</th>
                            <th>Capaian Kompetensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                        @php
                            $currentDetail = $existingDetails->firstWhere('reportCard.student_id', $student->id);
                            $selectedTpIds = $currentDetail ? $currentDetail->learningObjectives->pluck('id')->toArray() : [];
                        @endphp
                        <tr>
                            <td>{{ $student->nama_lengkap }}</td>
                            <td>
                                <input type="number" name="nilai_akhir[{{$student->id}}]" class="form-control" 
                                        value="{{ $currentDetail->nilai_akhir ?? '' }}" placeholder="Input nilai (0-100)">
                            </td>
                            <td>
                                @forelse ($learningObjectives as $tp)
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="capaian[{{ $student->id }}][]" value="{{ $tp->id }}" 
                                            class="custom-control-input" id="tp-{{$student->id}}-{{$tp->id}}"
                                            {{ in_array($tp->id, $selectedTpIds) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="tp-{{$student->id}}-{{$tp->id}}">{{ $tp->deskripsi }}</label>
                                </div>
                                @empty
                                <small class="text-muted">Tidak ada TP untuk pembelajaran ini.</small>
                                @endforelse
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Nilai Akhir & Capaian</button>
        </form>
        </div>
    </div>
</section>
@endsection