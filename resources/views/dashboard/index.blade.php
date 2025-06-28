@extends('layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dasbor</h1>
        </div>
        <div class="row">
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
        </div>
    </section>
@endsection