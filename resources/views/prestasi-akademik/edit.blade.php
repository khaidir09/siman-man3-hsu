@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Prestasi Akademik</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Perbarui Prestasi Akademik</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('prestasi-akademik.update', $prestasi->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">NISN</label>
                        <input name="nisn" type="number" class="form-control" value="{{ $prestasi->nisn }}">
                        @error('nisn')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Nama</label>
                        <input name="nama" type="text" class="form-control" value="{{ $prestasi->nama }}">
                        @error('nama')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Orang Tua</label>
                        <input name="ortu" type="text" class="form-control" value="{{ $prestasi->ortu }}">
                        @error('ortu')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Kelas</label>
                        <select name="rooms_id" class="form-control">
                            <option value="">Pilih Kelas</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" {{-- Cek apakah ID jurusan saat ini sama dengan majors_id pada kelas yang diedit --}}
                                    {{ $prestasi->rooms_id == $room->id ? 'selected' : '' }}>
                                    {{ $room->tingkat }} {{ $room->rombongan }} {{ $room->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                        @error('rooms_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Jumlah Nilai</label>
                        <input name="jumlah_nilai" type="number" class="form-control" value="{{ $prestasi->jumlah_nilai }}">
                        @error('jumlah_nilai')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Nilai rata-rata</label>
                        <input name="rata_rata" type="text" class="form-control" placeholder="Gunakan titik sebagai pemisah desimal (contoh: 89.93)" value="{{ $prestasi->rata_rata }}">
                        @error('rata_rata')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Ranking</label>
                        <select name="ranking" class="form-control">
                            <option value="{{ $prestasi->ranking }}">{{ $prestasi->ranking }}</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                        @error('ranking')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">TP/Semester</label>
                        <select name="academic_periods_id" class="form-control">
                            <option value="">Pilih TP/Semester</option>
                            @foreach ($periods as $period)
                                <option value="{{ $period->id }}" {{-- Cek apakah ID jurusan saat ini sama dengan majors_id pada kelas yang diedit --}}
                                    {{ $prestasi->academic_periods_id == $period->id ? 'selected' : '' }}>
                                    {{ $period->tahun_ajaran }} {{ $period->semester }}
                                </option>
                            @endforeach
                        </select>
                        @error('academic_periods_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </form>
            </div>
        </div>
    </section>
@endsection