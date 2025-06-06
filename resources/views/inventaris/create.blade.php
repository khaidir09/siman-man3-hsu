@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Inventaris</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Buat Inventaris</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('inventaris.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Jenis Kegiatan <span class="text-danger">*</span></label>
                        <select name="jenis_kegiatan" class="form-control">
                            <option value="">Pilih Jenis Kegiatan</option>
                            <option value="Pengadaan">Pengadaan</option>
                            <option value="Penambahan">Penambahan</option>
                            <option value="Perbaikan">Perbaikan</option>
                            <option value="Hibah">Hibah</option>
                        </select>
                        @error('jenis_kegiatan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Item <span class="text-danger">*</span></label>
                        <input name="item" type="text" class="form-control" >
                        @error('item')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Jumlah <span class="text-danger">*</span></label>
                        <input name="jumlah" type="number" class="form-control" >
                        @error('jumlah')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Biaya <span class="text-danger">*</span></label>
                        <input name="biaya" type="number" class="form-control" placeholder="Masukkan angka tanpa tanda Rp / pemisah titik">
                        @error('biaya')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Buat</button>
                </form>
            </div>
        </div>
    </section>
@endsection