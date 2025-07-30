@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Presensi</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Buat Presensi</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('presences.store', $schedule->id) }}" method="POST">
                    @csrf
                    <h3>Presensi untuk: {{ $schedule->learning->subject->nama_mapel }} Kelas {{ $schedule->learning->room->tingkat }}-{{ $schedule->learning->room->rombongan }} {{ $schedule->learning->room->nama_jurusan }}</h3>
                    <p>
                        Hari/Tanggal: {{ $schedule->hari }}, {{ now()->locale('id')->isoFormat('D MMMM YYYY') }} <br>
                        Waktu: {{ \Carbon\Carbon::parse($schedule->timeSlot->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->timeSlot->waktu_selesai)->format('H:i') }}
                    </p>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Siswa</th>
                                <th colspan="4">Status Kehadiran</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->nama_lengkap }}</td>
                                <td>
                                    <input type="radio" name="presences[{{ $student->id }}][status]" value="Hadir" checked> Hadir
                                </td>
                                <td>
                                    <input type="radio" name="presences[{{ $student->id }}][status]" value="Izin"> Izin
                                </td>
                                <td>
                                    <input type="radio" name="presences[{{ $student->id }}][status]" value="Sakit"> Sakit
                                </td>
                                <td>
                                    <input type="radio" name="presences[{{ $student->id }}][status]" value="Alfa"> Alfa
                                </td>
                                <td>
                                    <input type="text" name="presences[{{ $student->id }}][notes]" class="form-control" placeholder="Catatan jika perlu...">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-primary">Simpan Presensi</button>
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