@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Pelanggaran Kedisiplinan</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Buat Pelanggaran Kedisiplinan</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('terlambat.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Tanggal <span class="text-danger">*</span></label>
                        <input name="tanggal" type="date" class="form-control" >
                        @error('tanggal')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Waktu Datang <span class="text-danger">*</span></label>
                        <input name="waktu_datang" type="time" class="form-control" >
                        @error('waktu_datang')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        @if (Auth::user()->hasRole('kepala madrasah') || Auth::user()->hasRole('wakamad kesiswaan') )
                        <label for="guru_piket" class="mt-3">Guru Piket <span class="text-danger">*</span></label>
                        <select name="guru_piket" id="guru_piket" class="form-control">
                            <option value="">Pilih Guru Piket</option>
                            @foreach ($guru as $user)
                                <option value="{{ $user->name }}" {{ old('guru_piket') == $user->name ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('guru_piket')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        @else
                            <input type="hidden" name="guru_piket" value="{{ Auth::user()->name }}">
                        @endif

                        <label for="" class="mt-3">Nama Siswa <span class="text-danger">*</span></label>
                        <select name="student_id" class="form-control">
                            <option value="">Pilih Siswa</option>
                            @foreach ($siswa as $siswa)
                                <option value="{{ $siswa->id }}" class="text-uppercase">{{ $siswa->nama_lengkap }} ({{ $siswa->room->tingkat }} {{ $siswa->room->rombongan }} {{ $siswa->room->nama_jurusan }})</option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Buat</button>
                </form>
            </div>
        </div>
    </section>
@endsection