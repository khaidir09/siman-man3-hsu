@extends('layouts.master')

@section('title', 'Riwayat Presensi Saya')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Riwayat Presensi Saya</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
            <div class="breadcrumb-item">Riwayat Presensi</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-filter mr-2"></i> Filter Riwayat Presensi</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('presensi.riwayat') }}" method="GET">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="bulan">Bulan</label>
                                <select name="bulan" id="bulan" class="form-control">
                                    {{-- Loop untuk menampilkan 12 bulan --}}
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ $bulan_terpilih == $i ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($i)->locale('id')->isoFormat('MMMM') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <select name="tahun" id="tahun" class="form-control">
                                    {{-- Loop untuk menampilkan 5 tahun terakhir --}}
                                    @for ($i = 0; $i < 5; $i++)
                                        @php $tahun_loop = date('Y') - $i; @endphp
                                        <option value="{{ $tahun_loop }}" {{ $tahun_terpilih == $tahun_loop ? 'selected' : '' }}>
                                            {{ $tahun_loop }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">Tampilkan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tabel Rincian Kehadiran --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Rincian Kehadiran</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Jam Pelajaran</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($riwayat_presensi as $presensi)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($presensi->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
                                            <td>{{ $presensi->schedule->learning->subject->nama_mapel ?? 'N/A' }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($presensi->schedule->timeSlot->waktu_mulai)->format('H:i') }}
                                                -
                                                {{ \Carbon\Carbon::parse($presensi->schedule->timeSlot->waktu_selesai)->format('H:i') }}
                                            </td>
                                            <td>
                                                @if($presensi->status == 'hadir')
                                                    <div class="badge badge-success">Hadir</div>
                                                @elseif($presensi->status == 'izin')
                                                    <div class="badge badge-info">Izin</div>
                                                @elseif($presensi->status == 'sakit')
                                                    <div class="badge badge-warning">Sakit</div>
                                                @else
                                                    <div class="badge badge-danger">Alfa</div>
                                                @endif
                                            </td>
                                            <td>{{ $presensi->notes ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                Tidak ada data presensi untuk periode yang dipilih.
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
    </div>
</section>
@endsection