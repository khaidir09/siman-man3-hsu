@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Inventaris</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Perbarui Inventaris</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('inventaris.update', $infrastructure->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Jenis Kegiatan</label>
                        <select name="jenis_kegiatan" class="form-control">
                            <option value="{{ $infrastructure->jenis_kegiatan }}">{{ $infrastructure->jenis_kegiatan }}</option>
                            <option value="Pengadaan">Pengadaan</option>
                            <option value="Penambahan">Penambahan</option>
                            <option value="Perbaikan">Perbaikan</option>
                            <option value="Hibah">Hibah</option>
                        </select>
                        @error('jenis_kegiatan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="">Item</label>
                        <input name="item" type="text" value="{{ $infrastructure->item }}" class="form-control" >
                        @error('item')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Jumlah</label>
                        <input name="jumlah" type="number" class="form-control" value="{{ $infrastructure->jumlah }}">
                        @error('jumlah')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Biaya</label>
                        <input name="biaya" type="number" class="form-control" value="{{ $infrastructure->biaya }}">
                        @error('biaya')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </form>
            </div>
        </div>
    </section>
@endsection