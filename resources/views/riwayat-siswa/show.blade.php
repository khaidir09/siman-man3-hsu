{{-- resources/views/riwayat-siswa/show.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Riwayat {{ $student->nama_lengkap }}</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/components.css') }}">
</head>
<body>
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <div class="login-brand">
                    <img src="{{ asset('images/kemenag.png') }}" alt="" class="img-fluid logo" style="width: 100px; height: 100px;">
                    <h6>Sistem Informasi Manajemen MAN 3 HSU (SIMAN)</h6>
                </div>
                <div class="card card-primary p-5">
                    <h3>Riwayat Siswa</h3>
                    <p class="mb-0"><strong>Nama:</strong> {{ $student->nama_lengkap }}</p>
                    <p><strong>Kelas Saat Ini:</strong> {{ $student->room->tingkat }}-{{ $student->room->rombongan }} {{ $student->room->nama_jurusan }}</p>

                    <hr>

                    <h4>Pelanggaran Kedisiplinan</h4>
                    <table class="table table-bordered table-striped">
                        <thead><tr><th>Tanggal</th><th>Pelanggaran</th><th>Dicatat Oleh</th></tr></thead>
                        <tbody>
                            @forelse($student->lateArrival as $pelanggaran)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($pelanggaran->tanggal)->locale('id')->translatedFormat('d F Y') }}</td>
                                <td>Keterlambatan (Datang Pukul {{ $pelanggaran->waktu_datang }})</td>
                                <td>{{ $pelanggaran->guru_piket }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center">Tidak ada data pelanggaran.</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    <h4 class="mt-4">Kesehatan</h4>
                    <table class="table table-bordered table-striped">
                        <thead><tr><th>Tanggal</th><th>Hasil Pemeriksaan</th><th>Keluhan</th></tr></thead>
                        <tbody>
                            @forelse($student->healthcare as $uks)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($uks->tanggal)->locale('id')->translatedFormat('d F Y') }}</td>
                                <td>{{ $uks->keluhan }}</td>
                                <td>{{ $uks->hasil_pemeriksaan }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center">Tidak ada data riwayat kesehatan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    <h4 class="mt-4">Prestasi Ekstrakurikuler</h4>
                    <table class="table table-bordered table-striped">
                        <thead><tr><th>Nama Prestasi</th><th>Tingkat</th><th>Tahun</th><th>Nama Ekstrakurikuler</th></tr></thead>
                        <tbody>
                            @forelse($student->achievements as $prestasi)
                            <tr>
                                <td>{{ $prestasi->peringkat }} {{ $prestasi->nama_lomba }}</td>
                                <td>{{ $prestasi->tingkat }}</td>
                                <td>{{ $prestasi->tahun }}</td>
                                <td>{{ $prestasi->extracurricular->nama_ekskul ?? 'N/A' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center">Tidak ada data prestasi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Tambahkan tabel lain untuk data Bimbingan Konseling jika perlu --}}
                </div>
            </div>
        </div>    
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('admin/assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/stisla.js') }}"></script>

    <!-- JS Libraies -->

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="{{ asset('admin/assets/js/scripts.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom.js') }}"></script>
</body>
</html>