@extends('layouts.master')
@section('title', 'Manajemen Kenaikan Kelas')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Manajemen Kenaikan Kelas</h1>
    </div>
    <div class="section-body">
        <form action="{{ route('kenaikan-kelas.store') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h4>Proses Kenaikan Kelas: {{ $sourceRoom->tingkat }}-{{ $sourceRoom->rombongan }} {{ $sourceRoom->nama_jurusan }}</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        Pilih kelas tujuan, kemudian hapus centang pada siswa yang tidak naik kelas.
                    </div>
                    
                    {{-- Dropdown untuk memilih kelas tujuan --}}
                    <div class="form-group">
                        <label><b>Pindahkan Semua Siswa Terpilih Ke Kelas Tujuan:</b></label>
                        <select name="destination_room_id" class="form-control" required>
                            <option value="">-- Pilih Kelas Tujuan --</option>
                            @foreach($destinationRooms as $destRoom)
                                {{-- Jangan tampilkan kelas asal sebagai pilihan tujuan --}}
                                @if($destRoom->id !== $sourceRoom->id)
                                    <option value="{{ $destRoom->id }}">{{ $destRoom->tingkat }}-{{ $destRoom->rombongan }} {{ $destRoom->nama_jurusan }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <hr>

                    {{-- Checklist untuk memilih siswa --}}
                    <h6><b>Pilih Siswa yang Naik Kelas:</b></h6>
                    <div class="mt-3">
                        @forelse($sourceRoom->students as $student)
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" class="custom-control-input" id="student-{{$student->id}}" checked>
                                <label class="custom-control-label" for="student-{{$student->id}}">{{ $student->nama_lengkap }} (NISN: {{ $student->nisn }})</label>
                            </div>
                        @empty
                            <p class="text-muted">Tidak ada siswa di kelas ini.</p>
                        @endforelse
                    </div>

                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Proses Kenaikan Kelas</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection