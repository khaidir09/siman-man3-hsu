@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kelas</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Perbarui Kelas</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('kelas.update', $room->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Tingkat</label>
                        <input name="tingkat" type="text" value="{{ $room->tingkat }}" class="form-control" >
                        @error('tingkat')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Rombongan</label>
                        <input name="rombongan" type="text" value="{{ $room->rombongan }}" class="form-control" >
                        @error('rombongan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="role" class="mt-3">Jurusan</label>
                        <select name="majors_id" id="majors_id" class="form-control">
                            <option value="">Tidak ada jurusan</option>
                            @foreach ($majors as $major)
                                <option value="{{ $major->id }}" {{-- Cek apakah ID jurusan saat ini sama dengan majors_id pada kelas yang diedit --}}
                                    {{ $room->majors_id == $major->id ? 'selected' : '' }}>
                                    {{ $major->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                        @error('majors_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </form>
            </div>
        </div>
    </section>
@endsection