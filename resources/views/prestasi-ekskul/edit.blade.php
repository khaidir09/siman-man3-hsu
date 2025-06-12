@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Prestasi Ekstrakurikuler</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Perbarui Data Prestasi</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('prestasi-ekskul.update', $prestasi->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="extracurricular_id">Ekstrakurikuler</label>
                        <select name="extracurricular_id" id="extracurricular_id" class="form-control">
                            <option value="">Pilih Ekstrakurikuler</option>
                            @foreach ($ekstrakurikuler as $ekskul)
                                <option value="{{ $ekskul->id }}" {{ old('extracurricular_id', $prestasi->extracurricular_id) == $ekskul->id ? 'selected' : '' }}>
                                    {{ $ekskul->nama_ekskul }}
                                </option>
                            @endforeach
                        </select>
                        @error('extracurricular_id') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="student_id">Siswa Peraih Prestasi</label>
                        <select name="student_id" id="student_id" class="form-control">
                            <option value="">-- Pilih Ekstrakurikuler Terlebih Dahulu --</option>
                        </select>
                        @error('student_id') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama_lomba">Nama Lomba / Kegiatan</label>
                        <input name="nama_lomba" id="nama_lomba" type="text" class="form-control" value="{{ old('nama_lomba', $prestasi->nama_lomba) }}">
                        @error('nama_lomba') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="peringkat">Peringkat / Juara yang Diraih</label>
                        <select name="peringkat" id="peringkat" class="form-control">
                            <option value="Juara 1" {{ old('peringkat', $prestasi->peringkat) == 'Juara 1' ? 'selected' : '' }}>Juara 1</option>
                            <option value="Juara 2" {{ old('peringkat', $prestasi->peringkat) == 'Juara 2' ? 'selected' : '' }}>Juara 2</option>
                            <option value="Juara 3" {{ old('peringkat', $prestasi->peringkat) == 'Juara 3' ? 'selected' : '' }}>Juara 3</option>
                            <option value="Juara Harapan 1" {{ old('peringkat', $prestasi->peringkat) == 'Juara Harapan 1' ? 'selected' : '' }}>Juara Harapan 1</option>
                            <option value="Juara Harapan 2" {{ old('peringkat', $prestasi->peringkat) == 'Juara Harapan 2' ? 'selected' : '' }}>Juara Harapan 2</option>
                            <option value="Juara Harapan 3" {{ old('peringkat', $prestasi->peringkat) == 'Juara Harapan 3' ? 'selected' : '' }}>Juara Harapan 3</option>
                            <option value="Medali Emas" {{ old('peringkat', $prestasi->peringkat) == 'Medali Emas' ? 'selected' : '' }}>Medali Emas</option>
                            <option value="Medali Perak" {{ old('peringkat', $prestasi->peringkat) == 'Medali Perak' ? 'selected' : '' }}>Medali Perak</option>
                            <option value="Medali Perunggu" {{ old('peringkat', $prestasi->peringkat) == 'Medali Perunggu' ? 'selected' : '' }}>Medali Perunggu</option>
                            <option value="Peserta" {{ old('peringkat', $prestasi->peringkat) == 'Peserta' ? 'selected' : '' }}>Peserta / Partisipasi</option>
                        </select>
                        @error('peringkat') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="tingkat">Tingkat</label>
                        <select name="tingkat" id="tingkat" class="form-control">
                            <option value="Kabupaten" {{ old('tingkat', $prestasi->tingkat) == 'Kabupaten' ? 'selected' : '' }}>Kabupaten</option>
                            <option value="Provinsi" {{ old('tingkat', $prestasi->tingkat) == 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                            <option value="Nasional" {{ old('tingkat', $prestasi->tingkat) == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                        </select>
                        @error('tingkat') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <input name="tahun" id="tahun" type="number" class="form-control" value="{{ old('tahun', $prestasi->tahun) }}">
                        @error('tahun') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="penyelenggara">Penyelenggara</label>
                        <input name="penyelenggara" id="penyelenggara" type="text" class="form-control" value="{{ old('penyelenggara', $prestasi->penyelenggara) }}">
                        @error('penyelenggara') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>Sertifikat Saat Ini</label>
                        <div>
                            @if ($prestasi->sertifikat)
                                <img src="{{ Storage::url($prestasi->sertifikat) }}" alt="Sertifikat" style="width: 200px; border-radius: 5px;">
                            @else
                                <p class="text-muted">Tidak ada sertifikat yang diunggah.</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="sertifikat">Ganti Gambar Sertifikat (Opsional)</label>
                        <input name="sertifikat" id="sertifikat" type="file" class="form-control">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah sertifikat. Format: JPG, PNG. Ukuran Maksimal: 2MB.</small>
                        @error('sertifikat') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Perbarui Prestasi</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ekskulSelect = document.getElementById('extracurricular_id');
        const siswaSelect = document.getElementById('student_id');
        
        // Ambil ID siswa yang saat ini tersimpan di database
        const currentStudentId = "{{ old('student_id', $prestasi->student_id) }}";

        function fetchMembers(ekskulId, selectedStudentId) {
            if (!ekskulId) {
                siswaSelect.innerHTML = '<option value="">-- Pilih Ekstrakurikuler Terlebih Dahulu --</option>';
                siswaSelect.disabled = true;
                return;
            }

            siswaSelect.innerHTML = '<option value="">Memuat data siswa...</option>';
            siswaSelect.disabled = true;

            fetch(`{{ url('/get-ekskul-members') }}/${ekskulId}`)
                .then(response => response.json())
                .then(data => {
                    siswaSelect.innerHTML = '<option value="">Pilih Siswa</option>';
                    
                    if (data.length > 0) {
                        data.forEach(function (member) {
                            const option = document.createElement('option');
                            option.value = member.id;
                            option.textContent = member.nama_lengkap;
                            // Pilih siswa yang sesuai dengan data dari database
                            if (member.id == selectedStudentId) {
                                option.selected = true;
                            }
                            siswaSelect.appendChild(option);
                        });
                        siswaSelect.disabled = false;
                    } else {
                        siswaSelect.innerHTML = '<option value="">-- Tidak ada anggota di ekskul ini --</option>';
                        siswaSelect.disabled = true;
                    }
                })
                .catch(error => console.error('Error fetching members:', error));
        }

        ekskulSelect.addEventListener('change', function () {
            // Saat ekskul diganti, kita tidak memilih siswa manapun secara default
            fetchMembers(this.value, null);
        });
        
        // Saat halaman pertama kali dimuat, panggil fungsi dengan ID ekskul dan ID siswa yang sudah ada
        if (ekskulSelect.value) {
            fetchMembers(ekskulSelect.value, currentStudentId);
        }
    });
</script>
@endpush