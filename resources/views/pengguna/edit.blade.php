@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Pengguna</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Perbarui Pengguna</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('pengguna.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input name="name" type="text" value="{{ $user->name }}" class="form-control" >
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Alamat Email</label>
                        <input name="email" type="email" value="{{ $user->email }}" class="form-control" >
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Kata Sandi</label>
                        <input name="password" type="password" class="form-control" >
                        @error('password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="role" class="mt-3">Peran Pengguna</label>
                        <select name="role" id="role" class="form-control">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{-- Ambil role pertama user (jika ada) dan bandingkan ID-nya --}}
                                    {{ $user->roles->isNotEmpty() && $user->roles->first()->id == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <label for="" class="mt-3">Kelas</label>
                        <select name="classes_id" class="form-control">
                            <option value="">Tidak ada kelas</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}"
                                    {{-- Ambil role pertama user (jika ada) dan bandingkan ID-nya --}}
                                    {{ $user->classes_id == $room->id ? 'selected' : '' }}>
                                    {{ $room->tingkat}} {{ $room->rombongan}} {{ $room->nama_jurusan}}
                                </option>
                            @endforeach
                        </select>
                        @error('classes_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Buat</button>
                </form>
            </div>
        </div>
    </section>
@endsection