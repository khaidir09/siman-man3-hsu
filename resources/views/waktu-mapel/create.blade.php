@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Jam Pelajaran</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Buat Jam Pelajaran Baru</h4>
            </div>
            <div class="card-body">
                {{-- Mengarahkan form action ke route store untuk jam pelajaran --}}
                <form action="{{ route('waktu-mapel.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jam_ke">Jam Ke- <span class="text-danger">*</span></label>
                                <input name="jam_ke" id="jam_ke" type="number" class="form-control" value="{{ old('jam_ke') }}" placeholder="Contoh: 1">
                                @error('jam_ke')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="waktu_mulai">Waktu Mulai <span class="text-danger">*</span></label>
                                <input name="waktu_mulai" id="waktu_mulai" type="time" class="form-control" value="{{ old('waktu_mulai') }}">
                                @error('waktu_mulai')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan (Opsional)</label>
                        <input name="keterangan" id="keterangan" type="text" class="form-control" value="{{ old('keterangan') }}">
                        @error('keterangan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="alert alert-light">
                        <strong>Info:</strong> Waktu selesai akan dihitung secara otomatis (+42 menit dari Waktu Mulai).
                    </div>

                    <button type="submit" class="btn btn-primary">Buat</button>
                </form>
            </div>
        </div>
    </section>
@endsection
