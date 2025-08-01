@extends('layouts.master')

@section('title', 'Manajemen Rapor Kelas')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Manajemen Rapor</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Daftar Siswa - Kelas {{ $room->tingkat }}-{{ $room->rombongan }} {{ $room->nama_jurusan ?? '' }}</h4>
            <div class="card-header-action">
                <div class="badge badge-info">Periode: {{ $active_period->semester }} {{ $active_period->tahun_ajaran }}</div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th class="text-center">Status Rapor</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                            @php
                                $reportCard = $reportCards->get($student->id);
                                $status = $reportCard ? $reportCard->status : 'Belum Diproses';
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->nisn }}</td>
                                <td>{{ $student->nama_lengkap }}</td>
                                <td class="text-center">
                                    @if($status == 'Final')
                                        <span class="badge badge-success">Final</span>
                                    @elseif($status == 'Draft')
                                        <span class="badge badge-warning">Draft</span>
                                    @else
                                        <span class="badge badge-secondary">{{ $status }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('rapor.process', ['student' => $student->id, 'period' => $active_period->id]) }}" 
                                        class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit mr-1"></i> 
                                        {{ $status == 'Draft' ? 'Lanjutkan Proses' : 'Proses Rapor' }}
                                    </a>

                                    @if($status == 'Final')
                                    <a href="{{ route('raport.print', $reportCard->id) }}" class="btn btn-info btn-sm ml-2" target="_blank">
                                        <i class="fas fa-print mr-1"></i>
                                        Cetak
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    Tidak ada data siswa di kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection