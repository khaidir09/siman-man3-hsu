@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Koperasi</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Buat Transaksi Koperasi</h4>
            </div>
            <div class="card-body">
                {{-- Mengarahkan form action ke route store untuk koperasi --}}
                <form action="{{ route('unit-usaha.store') }}" method="POST">
                    @csrf

                    {{-- Menampilkan informasi saldo kas terakhir untuk membantu user --}}
                    <div class="alert alert-info">
                        Saldo Kas Saat Ini: <strong>Rp {{ number_format($kasTerakhir ?? 0, 0, ',', '.') }}</strong>
                    </div>

                    <div class="form-group">
                        <label for="tanggal">Tanggal Transaksi <span class="text-danger">*</span></label>
                        {{-- Memberi nilai default tanggal hari ini --}}
                        <input name="tanggal" id="tanggal" type="date" class="form-control" value="{{ old('tanggal', now()->format('Y-m-d')) }}">
                        @error('tanggal')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jenis_transaksi">Jenis Transaksi <span class="text-danger">*</span></label>
                        <select name="jenis_transaksi" id="jenis_transaksi" class="form-control">
                            <option value="">Pilih Jenis</option>
                            <option value="Pemasukan" {{ old('jenis_transaksi') == 'Pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="Pengeluaran" {{ old('jenis_transaksi') == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                        @error('jenis_transaksi')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="total">Nominal Transaksi (Rp) <span class="text-danger">*</span></label>
                        {{-- Menggunakan type="number" untuk input angka --}}
                        <input name="total" id="total" type="number" class="form-control" value="{{ old('total') }}" placeholder="Contoh: 50000">
                        @error('total')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        {{-- Menggunakan textarea untuk keterangan --}}
                        <textarea name="keterangan" id="keterangan" class="form-control" style="height: 100px;" placeholder="Makanan/Minuman/dll">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Buat</button>
                </form>
            </div>
        </div>
    </section>
@endsection