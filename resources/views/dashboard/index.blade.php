@extends('layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dasbor</h1>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-archive"></i>
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
            <div class="col-lg-4 col-md-4 col-sm-12">
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
            <div class="col-lg-4 col-md-4 col-sm-12">
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
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-archive"></i>
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
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-archive"></i>
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
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-archive"></i>
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
        </div>
    </section>
@endsection