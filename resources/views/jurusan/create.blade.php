@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Jurusan</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Buat Jurusan</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('jurusan.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Nama Jurusan <span class="text-danger">*</span></label>
                        <input name="nama_jurusan" type="text" class="form-control" >
                        @error('nama_jurusan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Singkatan <span class="text-danger">*</span></label>
                        <input name="singkatan" type="text" class="form-control" >
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