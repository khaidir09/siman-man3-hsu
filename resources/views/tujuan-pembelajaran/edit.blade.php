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
                <form action="{{ route('tujuan-pembelajaran.update', $tujuan_pembelajaran->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="learning_id">Pembelajaran <span class="text-danger">*</span></label>
                        <select name="learning_id" id="learning_id" class="form-control" required>
                            <option value="">-- Pilih Pembelajaran --</option>
                            @foreach ($learnings as $item)
                                {{-- Logika untuk memilih opsi yang sesuai dengan data lama atau data dari DB --}}
                                <option value="{{ $item->id }}" {{ old('learning_id', $tujuan_pembelajaran->learning_id) == $item->id ? 'selected' : '' }}>
                                    {{ $item->subject->nama_mapel }} - {{ $item->user->name }} (Kelas {{ $item->room->tingkat }}-{{ $item->room->rombongan }} {{ $item->room->major->nama_jurusan ?? '' }})
                                </option>
                            @endforeach
                        </select>
                        @error('learning_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Tujuan Pembelajaran <span class="text-danger">*</span></label>
                        {{-- Isi textarea dengan data yang sudah ada --}}
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi', $tujuan_pembelajaran->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('tujuan-pembelajaran.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection