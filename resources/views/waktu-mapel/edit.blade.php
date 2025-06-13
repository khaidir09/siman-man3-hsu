@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Jam Pelajaran</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Perbarui Jam Pelajaran</h4>
            </div>
            <div class="card-body">
                {{-- Mengarahkan form action ke route update untuk jam pelajaran --}}
                <form action="{{ route('waktu-mapel.update', $time_slot->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Method spoofing untuk update --}}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jam_ke">Jam Ke- <span class="text-danger">*</span></label>
                                {{-- Helper old() akan menampilkan input baru jika validasi gagal, jika tidak, tampilkan data dari database --}}
                                <input name="jam_ke" id="jam_ke" type="number" class="form-control" value="{{ old('jam_ke', $time_slot->jam_ke) }}">
                                @error('jam_ke')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="waktu_mulai">Waktu Mulai <span class="text-danger">*</span></label>
                                <input name="waktu_mulai" id="waktu_mulai" type="time" class="form-control" value="{{ old('waktu_mulai', $time_slot->waktu_mulai) }}">
                                @error('waktu_mulai')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan (Opsional)</label>
                        <input name="keterangan" id="keterangan" type="text" class="form-control" value="{{ old('keterangan', $time_slot->keterangan) }}">
                        @error('keterangan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="alert alert-light">
                        <strong>Info:</strong> Waktu selesai akan dihitung secara otomatis (+42 menit dari Waktu Mulai).
                    </div>

                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </form>
            </div>
        </div>
    </section>
@endsection
