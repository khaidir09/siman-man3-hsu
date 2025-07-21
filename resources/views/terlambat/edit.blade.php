@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Pelanggaran Kedisiplinan</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Perbarui Pelanggaran Kedisiplinan</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('terlambat.update', $terlambat->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Tanggal</label>
                        <input name="tanggal" type="date" value="{{ $terlambat->tanggal }}" class="form-control" >
                        @error('tanggal')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Waktu Datang</label>
                        <input name="waktu_datang" type="time" value="{{ $terlambat->waktu_datang }}" class="form-control" >
                        @error('waktu_datang')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Guru Piket</label>
                        <input name="guru_piket" type="text" class="form-control" value="{{ $terlambat->guru_piket }}">
                        @error('guru_piket')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Nama Siswa</label>
                        <select name="student_id" class="form-control">
                            <option value="">Pilih Siswa</option>
                            @foreach ($siswa as $siswa)
                                <option value="{{ $siswa->id }}" {{ old('student_id', $terlambat->student_id) == $siswa->id ? 'selected' : '' }} class="text-uppercase">
                                    {{ $siswa->nama_lengkap }} ({{ $siswa->room->tingkat }} {{ $siswa->room->rombongan }} {{ $siswa->room->nama_jurusan }})
                                </option>
                            @endforeach
                        </select>
                        @error('rooms_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </form>
            </div>
        </div>
    </section>
@endsection