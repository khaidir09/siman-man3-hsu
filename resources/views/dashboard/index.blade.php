@extends('layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dasbor</h1>
        </div>
        <div class="row">
            @if (Auth::user()->hasRole('kepala madrasah'))
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                        <h4>Guru</h4>
                        </div>
                        <div class="card-body">
                        {{ $guru }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-archive"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                        <h4>Jurusan</h4>
                        </div>
                        <div class="card-body">
                        {{ $jurusan }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-archive"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                        <h4>Kelas</h4>
                        </div>
                        <div class="card-body">
                        {{ $kelas }}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if (Auth::user()->hasRole('kepala madrasah') || Auth::user()->hasRole('wakamad kesiswaan'))
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                        <h4>Prestasi Akademik</h4>
                        </div>
                        <div class="card-body">
                            {{ $prestasiAkademik }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-secondary bg-secondary">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                        <h4>Pelanggaran</h4>
                        </div>
                        <div class="card-body">
                            {{ $pelanggaran }}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if (Auth::user()->hasRole('kepala madrasah') || Auth::user()->hasRole('guru bk'))
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                        <h4>Konseling</h4>
                        </div>
                        <div class="card-body">
                            {{ $konseling }}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            @if (Auth::user()->hasRole('kepala madrasah') || Auth::user()->hasRole('tata usaha'))
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-secondary bg-secondary">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                        <h4>Alumni</h4>
                        </div>
                        <div class="card-body">
                            {{ $alumni }}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            @if (Auth::user()->hasRole('kepala madrasah') || Auth::user()->hasRole('wakamad sarpras'))
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-secondary bg-secondary">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                        <h4>Realisasi Inventaris</h4>
                        </div>
                        <div class="card-body">
                            {{ $inventaris }}
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if (Auth::user()->hasRole('kepala madrasah') || Auth::user()->hasRole('uks'))
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-secondary bg-secondary">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                        <h4>Siswa Sakit</h4>
                        </div>
                        <div class="card-body">
                            {{ $uks }}
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if (Auth::user()->hasRole('kepala madrasah') || Auth::user()->hasRole('koperasi'))
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-secondary bg-secondary">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                        <h4>Sisa Kas Koperasi</h4>
                        </div>
                        <div class="card-body">
                            Rp. {{ number_format($sisaKas, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if (Auth::user()->hasRole('kepala madrasah') || Auth::user()->hasRole('pembina ekskul'))
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-secondary bg-secondary">
                        <i class="fas fa-medal"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                        <h4>Ekstrakurikuler</h4>
                        </div>
                        <div class="card-body">
                            {{ $jumlahEkskul }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-secondary bg-secondary">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                        <h4>Anggota Ekstrakurikuler</h4>
                        </div>
                        <div class="card-body">
                            {{ $jumlahAnggotaEkskul }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-secondary bg-secondary">
                        <i class="fas fa-medal"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                        <h4>Prestasi Ekstrakurikuler</h4>
                        </div>
                        <div class="card-body">
                            {{ $jumlahPrestasiEkskul }}
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        @if (Auth::user()->hasRole('guru') && isset($today_schedules))
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-calendar-day mr-2"></i> Jadwal Mengajar Hari Ini ({{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }})</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 15%;">Jam</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Kelas</th>
                                            <th style="width: 20%;" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($today_schedules as $schedule)
                                            <tr>
                                                <td>
                                                    <div class="badge badge-secondary">
                                                        {{-- Menampilkan data dari relasi timeSlot --}}
                                                        {{ \Carbon\Carbon::parse($schedule->timeSlot->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->timeSlot->waktu_selesai)->format('H:i') }}
                                                    </div>
                                                </td>
                                                <td>{{ $schedule->learning->subject->nama_mapel }}</td>
                                                <td>{{ $schedule->learning->room->tingkat }}-{{ $schedule->learning->room->rombongan }} {{ $schedule->learning->room->nama_jurusan }}</td>
                                                <td class="text-center">
                                                    {{-- Menggunakan properti baru presence_taken --}}
                                                    @if ($schedule->presence_taken)
                                                        <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i> Presensi Sudah Diambil</span>
                                                    @else
                                                        {{-- Arahkan ke route untuk mengambil presensi --}}
                                                        <a href="{{ route('presences.create', $schedule->id) }}" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-edit mr-1"></i> Ambil Presensi
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    Tidak ada jadwal mengajar hari ini. Selamat beristirahat!
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Periksa apakah ada data statistik yang dikirim --}}
        @if (isset($stats_rata_rata))
            {{-- BAGIAN 1: KARTU STATISTIK UTAMA --}}
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary"><i class="fas fa-percent"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>Rata-rata Kehadiran (Bulan Ini)</h4></div>
                            <div class="card-body">{{ number_format($stats_rata_rata, 2) }}%</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning"><i class="fas fa-procedures"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>Sakit</h4></div>
                            <div class="card-body">{{ $stats_sakit }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info"><i class="fas fa-envelope-open-text"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>Izin</h4></div>
                            <div class="card-body">{{ $stats_izin }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger"><i class="fas fa-user-slash"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>Alpa</h4></div>
                            <div class="card-body">{{ $stats_alpa }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BAGIAN 2: GRAFIK --}}
            <div class="row">
                {{-- Grafik Tren Kehadiran (Selalu Tampil) --}}
                <div class="col-lg-8 col-md-12">
                    <div class="card">
                        <div class="card-header"><h4>Tren Kehadiran (6 Bulan Terakhir)</h4></div>
                        <div class="card-body">
                            <canvas id="attendanceTrendChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Grafik Samping (Tergantung Peran) --}}
                <div class="col-lg-4 col-md-12">
                    @if (Auth::user()->hasRole('wali kelas'))
                        {{-- Grafik Rincian Absen untuk Wali Kelas --}}
                        <div class="card">
                            <div class="card-header"><h4>Rincian Absensi Kelas Anda (Bulan Ini)</h4></div>
                            <div class="card-body">
                                <canvas id="absenceBreakdownChart"></canvas>
                            </div>
                        </div>
                    @elseif (Auth::user()->hasRole('kepala madrasah'))
                        {{-- Grafik Perbandingan Kelas untuk Kepala Madrasah (jika ada data) --}}
                        @if (isset($class_comparison_labels) && count($class_comparison_labels) > 0)
                            <div class="card">
                                <div class="card-header"><h4>Kehadiran per Kelas (Bulan Ini)</h4></div>
                                <div class="card-body">
                                    <canvas id="classComparisonChart"></canvas>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        @endif

        @if (Auth::user()->hasRole('siswa'))
            {{-- Kartu Rekap Kehadiran --}}
            <h2 class="section-title">Rekap kehadiran bulan {{ \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM') }}</h2>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success"><i class="fas fa-user-check"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>Hadir</h4></div>
                            <div class="card-body">{{ $rekap_hadir ?? 0 }} JP</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info"><i class="fas fa-envelope-open-text"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>Izin</h4></div>
                            <div class="card-body">{{ $rekap_izin ?? 0 }} JP</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning"><i class="fas fa-procedures"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>Sakit</h4></div>
                            <div class="card-body">{{ $rekap_sakit ?? 0 }} JP</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger"><i class="fas fa-user-slash"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>Tanpa Keterangan</h4></div>
                            <div class="card-body">{{ $rekap_alfa ?? 0 }} JP</div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (Auth::user()->hasRole(['wakamad kurikulum', 'kepala madrasah']))
        <div class="row">
            {{-- Grafik Ekstrakurikuler Paling Populer --}}
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Ekstrakurikuler Terpopuler (Berdasarkan Jumlah Anggota)</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="popularEkskulChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Grafik Partisipasi Siswa per Kelas --}}
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Partisipasi Ekskul Tertinggi (Berdasarkan Kelas)</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="classParticipationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </section>
@endsection

@push('scripts')
{{-- Pastikan Chart.js sudah dimuat --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    // Hanya jalankan script jika elemen canvas ada
    if ($('#attendanceTrendChart').length) {
        var ctxTrend = document.getElementById('attendanceTrendChart').getContext('2d');
        new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: {!! json_encode($trend_labels ?? []) !!},
                datasets: [{
                    label: 'Rata-rata Kehadiran (%)',
                    data: {!! json_encode($trend_data ?? []) !!},
                    borderColor: '#6777ef',
                    backgroundColor: 'rgba(103, 119, 239, 0.2)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: { scales: { y: { beginAtZero: true, max: 100 } } }
        });
    }
    
    @if (Auth::user()->hasRole('wali kelas'))
    if ($('#absenceBreakdownChart').length) {
        var ctxAbsence = document.getElementById('absenceBreakdownChart').getContext('2d');
        new Chart(ctxAbsence, {
            type: 'doughnut',
            data: {
                labels: ['Sakit', 'Izin', 'Alpa'],
                datasets: [{
                    data: {!! json_encode($absence_breakdown_data ?? [0,0,0]) !!},
                    backgroundColor: ['#ffc107', '#17a2b8', '#dc3545'],
                }]
            }
        });
    }
    @elseif (Auth::user()->hasRole('kepala madrasah'))
    if ($('#classComparisonChart').length) {
        var ctxClass = document.getElementById('classComparisonChart').getContext('2d');
        new Chart(ctxClass, {
            type: 'bar',
            data: {
                labels: {!! json_encode($class_comparison_labels ?? []) !!},
                datasets: [{
                    label: 'Kehadiran (%)',
                    data: {!! json_encode($class_comparison_data ?? []) !!},
                    backgroundColor: '#6777ef',
                }]
            },
            options: {
                indexAxis: 'y', // Membuat bar menjadi horizontal agar nama kelas muat
                scales: { x: { beginAtZero: true, max: 100 } }
            }
        });
    }
    @endif

    @if (Auth::user()->hasRole(['wakamad kurikulum', 'kepala madrasah']))
    
    // Grafik Ekstrakurikuler Populer (Pie Chart)
    if ($('#popularEkskulChart').length) {
        var ctxPopular = document.getElementById('popularEkskulChart').getContext('2d');
        new Chart(ctxPopular, {
            type: 'pie',
            data: {
                labels: {!! json_encode($popular_ekskul_labels ?? []) !!},
                datasets: [{
                    data: {!! json_encode($popular_ekskul_data ?? []) !!},
                    backgroundColor: ['#6777ef', '#ffc107', '#28a745', '#dc3545', '#17a2b8'],
                }]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
            }
        });
    }

    // Grafik Partisipasi Kelas (Bar Chart)
    if ($('#classParticipationChart').length) {
        var ctxParticipation = document.getElementById('classParticipationChart').getContext('2d');
        new Chart(ctxParticipation, {
            type: 'bar',
            data: {
                labels: {!! json_encode($class_participation_labels ?? []) !!},
                datasets: [{
                    label: 'Jumlah Siswa yang Ikut Ekskul',
                    data: {!! json_encode($class_participation_data ?? []) !!},
                    backgroundColor: '#6777ef',
                    borderColor: '#6777ef',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1 // Pastikan sumbu Y adalah bilangan bulat
                        }
                    }]
                }
            }
        });
    }

    @endif
});
</script>
@endpush