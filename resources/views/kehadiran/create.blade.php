@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kehadiran</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Buat Kehadiran</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('kehadiran.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Bulan <span class="text-danger">*</span></label>
                        <input name="bulan" type="month" class="form-control" >
                        @error('bulan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        @if (Auth::user()->hasRole('wali kelas'))
                            <input type="hidden" name="rooms_id" value="{{ Auth::user()->roomClass->id }}">
                        @else
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
                        @endif

                        <label for="" class="mt-3">Izin <span class="text-danger">*</span></label>
                        <input name="izin" type="number" class="form-control" >
                        @error('izin')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Sakit <span class="text-danger">*</span></label>
                        <input name="sakit" type="number" class="form-control" >
                        @error('sakit')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Alpa <span class="text-danger">*</span></label>
                        <input name="alpa" type="number" class="form-control" >
                        @error('alpa')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Hari Efektif <span class="text-danger">*</span></label>
                        <input name="hari_efektif" type="number" class="form-control" >
                        @error('hari_efektif')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Jumlah Siswa <span class="text-danger">*</span></label>
                        <input name="jumlah_siswa" type="number" class="form-control">
                        @error('jumlah_siswa')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        
                    </div>
                    <button type="submit" class="btn btn-primary">Buat</button>
                </form>
            </div>
        </div>
    </section>
@endsection