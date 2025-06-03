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
                        <input name="nama_siswa" type="text" class="form-control" value="{{ $terlambat->nama_siswa }}">
                        @error('nama_siswa')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Kelas</label>
                        <select name="rooms_id" class="form-control">
                            <option value="">Pilih Kelas</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" {{-- Cek apakah ID jurusan saat ini sama dengan majors_id pada kelas yang diedit --}}
                                    {{ $terlambat->rooms_id == $room->id ? 'selected' : '' }}>
                                    {{ $room->tingkat }} {{ $room->rombongan }} {{ $room->nama_jurusan }}
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