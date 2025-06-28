@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Pengguna</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Buat Pengguna</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('pengguna.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Nama <span class="text-danger">*</span></label>
                        <input name="name" type="text" class="form-control" >
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Alamat Email <span class="text-danger">*</span></label>
                        <input name="email" type="email" class="form-control" >
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Kata Sandi <span class="text-danger">*</span></label>
                        <input name="password" type="password" class="form-control" >
                        @error('password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Peran <span class="text-danger">*</span></label>
                        <select name="role" class="form-control">
                            <option value="">Pilih Peran</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" class="text-uppercase">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">NIP</label>
                        <input name="nip" type="number" class="form-control" >
                        @error('nip')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Buat</button>
                </form>
            </div>
        </div>
    </section>
@endsection