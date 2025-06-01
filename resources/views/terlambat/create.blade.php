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

                        <label for="" class="mt-3">Guru Piket <span class="text-danger">*</span></label>
                        <input name="guru_piket" type="text" class="form-control" >
                        @error('guru_piket')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Nama Siswa <span class="text-danger">*</span></label>
                        <input name="nama_siswa" type="text" class="form-control" >
                        @error('nama_siswa')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Kelas <span class="text-danger">*</span></label>
                        <select name="rooms_id" class="form-control">
                            <option value="">Pilih Kelas</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" class="text-uppercase">{{ $room->tingkat }} {{ $room->rombongan }} {{ $room->nama_jurusan }}</option>
                            @endforeach
                        </select>
                        @error('rooms_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Buat</button>
                </form>
            </div>
        </div>
    </section>
@endsection