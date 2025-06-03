@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kehadiran Siswa</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Perbarui Kehadiran Siswa</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('kehadiran.update', $kehadiran->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Bulan</label>
                        <input name="bulan" type="month" value="{{ \Carbon\Carbon::parse($kehadiran->bulan)->translatedFormat('Y-m') }}" class="form-control" >
                        @error('bulan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Kelas</label>
                        <select name="rooms_id" class="form-control">
                            <option value="">Pilih Kelas</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" {{-- Cek apakah ID jurusan saat ini sama dengan majors_id pada kelas yang diedit --}}
                                    {{ $kehadiran->rooms_id == $room->id ? 'selected' : '' }}>
                                    {{ $room->tingkat }} {{ $room->rombongan }} {{ $room->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                        @error('rooms_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Izin</label>
                        <input name="izin" type="number" class="form-control" value="{{ $kehadiran->izin }}">
                        @error('izin')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Sakit</label>
                        <input name="sakit" type="number" class="form-control" value="{{ $kehadiran->sakit }}">
                        @error('sakit')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Alpa</label>
                        <input name="alpa" type="number" class="form-control" value="{{ $kehadiran->alpa }}">
                        @error('alpa')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Hari Efektif</label>
                        <input name="hari_efektif" type="number" class="form-control" value="{{ $kehadiran->hari_efektif }}">
                        @error('hari_efektif')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Jumlah Siswa</label>
                        <input name="jumlah_siswa" type="number" class="form-control" value="{{ $kehadiran->jumlah_siswa }}">
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