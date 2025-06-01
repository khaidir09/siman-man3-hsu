@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Jurusan</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Perbarui Jurusan</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('jurusan.update', $major->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Nama Jurusan</label>
                        <input name="nama_jurusan" type="text" value="{{ $major->nama_jurusan }}" class="form-control" >
                        @error('nama_jurusan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Singkatan</label>
                        <input name="singkatan" type="text" value="{{ $major->singkatan }}" class="form-control" >
                        @error('singkatan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Buat</button>
                </form>
            </div>
        </div>
    </section>
@endsection