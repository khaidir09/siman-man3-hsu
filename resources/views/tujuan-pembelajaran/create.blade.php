@extends('layouts.master')

@section('title', 'Tambah Tujuan Pembelajaran')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Tujuan Pembelajaran</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Formulir Tujuan Pembelajaran Baru</h4>
        </div>
        <div class="card-body">
            {{-- Form action sekarang menyertakan ID learning --}}
            <form action="{{ route('tujuan-pembelajaran.store', $learning->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Deskripsi Tujuan Pembelajaran <span class="text-danger">*</span></label>
                    <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                <a href="{{ route('tujuan-pembelajaran.index', $learning->id) }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</section>
@endsection