@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Semester</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Buat Semester</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('semester.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Tahun Ajaran <span class="text-danger">*</span></label>
                        <input name="tahun_ajaran" type="text" class="form-control" >
                        @error('tahun_ajaran')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="mt-3 mb-1">Semester <span class="text-danger">*</span></div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="semester" id="" value="Ganjil" checked>
                            <label class="form-check-label">Ganjil</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="semester" id="" value="Genap">
                            <label class="form-check-label">Genap</label>
                        </div>
                        @error('semester')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Buat</button>
                </form>
            </div>
        </div>
    </section>
@endsection