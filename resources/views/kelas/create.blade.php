@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kelas</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Buat Kelas</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('kelas.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Tingkat <span class="text-danger">*</span></label>
                        <input name="tingkat" type="text" class="form-control" >
                        @error('tingkat')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Rombongan <span class="text-danger">*</span></label>
                        <input name="rombongan" type="text" class="form-control" >
                        @error('rombongan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Jurusan</label>
                        <select name="majors_id" class="form-control">
                            <option value="">Pilih Jurusan</option>
                            @foreach ($majors as $major)
                                <option value="{{ $major->id }}" class="text-uppercase">{{ $major->nama_jurusan }}</option>
                            @endforeach
                        </select>
                        @error('majors_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="wali_kelas_id">Wali Kelas</label>
                        <select name="wali_kelas_id" id="wali_kelas_id" class="form-control">
                            <option value="">-- Tidak Ada Wali Kelas --</option>
                            {{-- Loop data $teachers yang dikirim dari controller --}}
                            @foreach ($teachers as $teacher)
                                {{-- Kondisi untuk memilih guru yang saat ini menjadi wali kelas --}}
                                <option value="{{ $teacher->id }}">
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('wali_kelas_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Buat</button>
                </form>
            </div>
        </div>
    </section>
@endsection