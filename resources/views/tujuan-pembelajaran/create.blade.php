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
            <form action="{{ route('tujuan-pembelajaran.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="learning_id">Pembelajaran <span class="text-danger">*</span></label>
                    <select name="learning_id" id="learning_id" class="form-control" required>
                        <option value="">-- Pilih Pembelajaran --</option>
                        @foreach ($learnings as $item)
                            <option value="{{ $item->id }}" {{ old('learning_id') == $item->id ? 'selected' : '' }}>
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
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Buat</button>
            </form>
        </div>
    </div>
</section>
@endsection