@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Prestasi Ekstrakurikuler</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Buat Data Prestasi Baru</h4>
            </div>
            <div class="card-body">
                {{-- Mengarahkan form action ke route store untuk prestasi --}}
                <form action="{{ route('prestasi-ekskul.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="extracurricular_id">Ekstrakurikuler <span class="text-danger">*</span></label>
                        {{-- Dropdown ekskul akan menjadi pemicu --}}
                        <select name="extracurricular_id" id="extracurricular_id" class="form-control">
                            <option value="">Pilih Ekstrakurikuler</option>
                            @foreach ($ekstrakurikuler as $ekskul)
                                <option value="{{ $ekskul->id }}" {{ old('extracurricular_id') == $ekskul->id ? 'selected' : '' }}>
                                    {{ $ekskul->nama_ekskul }}
                                </option>
                            @endforeach
                        </select>
                        @error('extracurricular_id') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="student_id">Siswa Peraih Prestasi <span class="text-danger">*</span></label>
                        <select name="student_id" id="student_id" class="form-control" disabled>
                            <option value="">-- Pilih Ekstrakurikuler Terlebih Dahulu --</option>
                        </select>
                        @error('student_id') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama_lomba">Nama Lomba / Kegiatan <span class="text-danger">*</span></label>
                        <input name="nama_lomba" id="nama_lomba" type="text" class="form-control" value="{{ old('nama_lomba') }}">
                        @error('nama_lomba')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="peringkat">Peringkat / Juara yang Diraih <span class="text-danger">*</span></label>
                        <select name="peringkat" id="peringkat" class="form-control">
                            <option value="">Pilih Peringkat</option>
                            <option value="Juara 1" {{ old('peringkat') == 'Juara 1' ? 'selected' : '' }}>Juara 1</option>
                            <option value="Juara 2" {{ old('peringkat') == 'Juara 2' ? 'selected' : '' }}>Juara 2</option>
                            <option value="Juara 3" {{ old('peringkat') == 'Juara 3' ? 'selected' : '' }}>Juara 3</option>
                            <option value="Juara Harapan 1" {{ old('peringkat') == 'Juara Harapan 1' ? 'selected' : '' }}>Juara Harapan 1</option>
                            <option value="Juara Harapan 2" {{ old('peringkat') == 'Juara Harapan 2' ? 'selected' : '' }}>Juara Harapan 2</option>
                            <option value="Juara Harapan 3" {{ old('peringkat') == 'Juara Harapan 3' ? 'selected' : '' }}>Juara Harapan 3</option>
                            <option value="Medali Emas" {{ old('peringkat') == 'Medali Emas' ? 'selected' : '' }}>Medali Emas</option>
                            <option value="Medali Perak" {{ old('peringkat') == 'Medali Perak' ? 'selected' : '' }}>Medali Perak</option>
                            <option value="Medali Perunggu" {{ old('peringkat') == 'Medali Perunggu' ? 'selected' : '' }}>Medali Perunggu</option>
                            <option value="Peserta" {{ old('peringkat') == 'Peserta' ? 'selected' : '' }}>Peserta / Partisipasi</option>
                        </select>
                        @error('peringkat')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tingkat">Tingkat <span class="text-danger">*</span></label>
                        <select name="tingkat" id="tingkat" class="form-control">
                             <option value="">Pilih Tingkat</option>
                             <option value="Kabupaten" {{ old('tingkat') == 'Kabupaten' ? 'selected' : '' }}>Kabupaten</option>
                             <option value="Provinsi" {{ old('tingkat') == 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                             <option value="Nasional" {{ old('tingkat') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                        </select>
                        @error('tingkat')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tahun">Tahun Diraih <span class="text-danger">*</span></label>
                        {{-- Menggunakan type="number" untuk input tahun --}}
                        <input name="tahun" id="tahun" type="number" class="form-control" value="{{ old('tahun', date('Y')) }}" min="1990" max="{{ date('Y') }}">
                        @error('tahun')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="penyelenggara">Penyelenggara <span class="text-danger">*</span></label>
                        <input name="penyelenggara" id="penyelenggara" type="text" class="form-control" value="{{ old('penyelenggara') }}">
                        @error('penyelenggara')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="sertifikat">Gambar Sertifikat (Opsional)</label>
                        <input name="sertifikat" id="sertifikat" type="file" class="form-control">
                        <small class="form-text text-muted">Format: JPG, PNG. Ukuran Maksimal: 2MB.</small>
                        @error('sertifikat')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Prestasi</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Menunggu dokumen siap
    document.addEventListener('DOMContentLoaded', function () {
        const ekskulSelect = document.getElementById('extracurricular_id');
        const siswaSelect = document.getElementById('student_id');
        
        // Simpan nilai 'old' dari student_id jika ada (untuk kasus validation error)
        const oldStudentId = "{{ old('student_id') }}";

        // Fungsi untuk mengambil data anggota via AJAX
        function fetchMembers(ekskulId) {
            if (!ekskulId) {
                siswaSelect.innerHTML = '<option value="">-- Pilih Ekstrakurikuler Terlebih Dahulu --</option>';
                siswaSelect.disabled = true;
                return;
            }

            // Tampilkan status loading
            siswaSelect.innerHTML = '<option value="">Memuat data siswa...</option>';
            siswaSelect.disabled = true;

            // Panggil API endpoint
            fetch(`{{ url('/get-ekskul-members') }}/${ekskulId}`)
                .then(response => response.json())
                .then(data => {
                    siswaSelect.innerHTML = '<option value="">Pilih Siswa</option>'; // Opsi default
                    
                    if (data.length > 0) {
                        data.forEach(function (member) {
                            const option = document.createElement('option');
                            option.value = member.id;
                            option.textContent = member.nama_lengkap;
                            // Jika ada old value, pilih kembali opsi tersebut
                            if (member.id == oldStudentId) {
                                option.selected = true;
                            }
                            siswaSelect.appendChild(option);
                        });
                        siswaSelect.disabled = false; // Aktifkan dropdown
                    } else {
                        siswaSelect.innerHTML = '<option value="">-- Tidak ada anggota di ekskul ini --</option>';
                        siswaSelect.disabled = true;
                    }
                })
                .catch(error => {
                    console.error('Error fetching members:', error);
                    siswaSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                    siswaSelect.disabled = true;
                });
        }

        // Tambahkan event listener ke dropdown ekskul
        ekskulSelect.addEventListener('change', function () {
            fetchMembers(this.value);
        });
        
        // Panggil fungsi saat halaman pertama kali dimuat
        // Ini untuk menangani kasus jika ada validation error dan dropdown ekskul sudah terisi 'old()' value
        if (ekskulSelect.value) {
            fetchMembers(ekskulSelect.value);
        }
    });
</script>
@endpush