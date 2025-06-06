@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Bimbingan Konseling</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Perbarui Bimbingan Konseling</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('konseling.update', $konseling->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Tanggal</label>
                        <input name="tanggal" type="date" value="{{ $konseling->tanggal }}" class="form-control" >
                        @error('tanggal')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Nama Siswa</label>
                        <input name="nama_siswa" type="text" value="{{ $konseling->nama_siswa }}" class="form-control" >
                        @error('nama_siswa')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Kelas</label>
                        <select name="rooms_id" class="form-control">
                            <option value="">Pilih Kelas</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" {{-- Cek apakah ID jurusan saat ini sama dengan majors_id pada kelas yang diedit --}}
                                    {{ $konseling->rooms_id == $room->id ? 'selected' : '' }}>
                                    {{ $room->tingkat }} {{ $room->rombongan }} {{ $room->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                        @error('rooms_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Uraian Masalah</label>
                        <textarea class="form-control" name="uraian_masalah" id="" cols="30" rows="10">{!! $konseling->uraian_masalah !!}</textarea>
                        @error('uraian_masalah')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Pemecahan Masalah</label>
                        <textarea class="form-control" name="pemecahan_masalah" id="" cols="30" rows="10">{!! $konseling->pemecahan_masalah !!}</textarea>
                        @error('pemecahan_masalah')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="control-label">Pribadi</div>
                                <label class="custom-switch mt-2">
                                    <input {{ $konseling->is_pribadi == 1 ? 'checked' : '' }} value="1" type="checkbox" name="is_pribadi" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="control-label">Sosial</div>
                                <label class="custom-switch mt-2">
                                    <input {{ $konseling->is_sosial == 1 ? 'checked' : '' }} value="1" type="checkbox" name="is_sosial"
                                        class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="control-label">Belajar</div>
                                <label class="custom-switch mt-2">
                                    <input {{ $konseling->is_belajar == 1 ? 'checked' : '' }} value="1" type="checkbox" name="is_belajar" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">

                            <div class="form-group">
                                <div class="control-label">Karir</div>
                                <label class="custom-switch mt-2">
                                    <input {{ $konseling->is_karir == 1 ? 'checked' : '' }} value="1" type="checkbox" name="is_karir"
                                        class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>

                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </form>
            </div>
        </div>
    </section>
@endsection