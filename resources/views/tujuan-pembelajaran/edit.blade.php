@extends('layouts.master')

@section('title', 'Edit Tujuan Pembelajaran')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Tujuan Pembelajaran</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Formulir Edit Tujuan Pembelajaran</h4>
            </div>
            <div class="card-body">
                {{-- Arahkan form ke route 'update' dan gunakan method PATCH --}}
                <form action="{{ route('tujuan-pembelajaran.update', ['learning' => $learning->id, 'tujuan_pembelajaran' => $tujuan_pembelajaran->id]) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Tujuan Pembelajaran <span class="text-danger">*</span></label>
                        {{-- Isi textarea dengan data yang sudah ada --}}
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi', $tujuan_pembelajaran->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection