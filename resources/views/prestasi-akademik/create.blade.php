@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Prestasi Akademik</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Buat Prestasi Akademik</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('prestasi-akademik.store') }}" method="POST">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li> {{ $error }} </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @csrf
                    <div class="form-group">
                        <label for="">NISN <span class="text-danger">*</span></label>
                        <input name="nisn" type="number" class="form-control" >
                        @error('nisn')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Nama <span class="text-danger">*</span></label>
                        <input name="nama" type="text" class="form-control" >
                        @error('nama')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Orang Tua <span class="text-danger">*</span></label>
                        <input name="ortu" type="text" class="form-control" >
                        @error('ortu')
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

                        <label for="" class="mt-3">Jumlah Nilai <span class="text-danger">*</span></label>
                        <input name="jumlah_nilai" type="number" class="form-control" >
                        @error('jumlah_nilai')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Nilai rata-rata <span class="text-danger">*</span></label>
                        <input name="rata_rata" type="text" class="form-control" placeholder="Gunakan titik sebagai pemisah desimal (contoh: 89.93)">
                        @error('rata_rata')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Ranking <span class="text-danger">*</span></label>
                        <select name="ranking" class="form-control">
                            <option value="">Pilih Ranking</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                        @error('ranking')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">TP/Semester <span class="text-danger">*</span></label>
                        <select name="academic_periods_id" class="form-control">
                            <option value="">Pilih TP/Semester</option>
                            @foreach ($periods as $period)
                                <option value="{{ $period->id }}" class="text-uppercase">{{ $period->tahun_ajaran }} {{ $period->semester }}</option>
                            @endforeach
                        </select>
                        @error('academic_periods_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                    <button type="submit" class="btn btn-primary">Buat</button>
                </form>
            </div>
        </div>
    </section>
@endsection