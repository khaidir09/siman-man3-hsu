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
                        <select name="role" id="role" class="form-control">
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

                    <div id="student-fields" style="display: none;">
                        <hr>
                        <h5>Data Detail Siswa</h5>
                        <div class="form-group">
                            <label for="nisn">NISN <span class="text-danger">*</span></label>
                            <input name="nisn" id="nisn" type="number" class="form-control" value="{{ old('nisn') }}">
                            @error('nisn')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="room_id">Kelas <span class="text-danger">*</span></label>
                            <select name="room_id" id="room_id" class="form-control">
                                <option value="">Pilih Kelas</option>
                                {{-- Asumsi variabel $rooms dikirim dari controller --}}
                                @foreach ($rooms as $room) 
                                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                        {{ $room->tingkat }} {{ $room->rombongan }} {{ $room->major->nama_jurusan ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                             @error('rooms_id')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control">
                                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                             @error('status')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Buat</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const studentFields = document.getElementById('student-fields');

        // Fungsi untuk menampilkan/menyembunyikan form siswa
        function toggleStudentFields() {
            // Mengubah nilai ke huruf kecil untuk perbandingan yang konsisten
            if (roleSelect.value.toLowerCase() === 'siswa') {
                studentFields.style.display = 'block';
            } else {
                studentFields.style.display = 'none';
            }
        }

        // Jalankan fungsi saat halaman dimuat (untuk menangani error validasi)
        toggleStudentFields();

        // Tambahkan event listener untuk memantau perubahan
        roleSelect.addEventListener('change', toggleStudentFields);
    });
</script>
@endpush