@extends('layouts.master')

@section('title', 'Mata Pelajaran yang Diampu')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Mata Pelajaran</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Daftar Mata Pelajaran yang Anda Ampu</h4>
            {{-- Tombol Tambah hanya muncul untuk admin/wakasek --}}
            @if(Auth::user()->hasRole('wakamad kurikulum'))
                <div class="card-header-action">
                    <a href="#" class="btn btn-primary">Tambah Data</a>
                </div>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table-sub">
                    <thead>
                        <tr>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Periode Ajaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($learnings as $learning)
                        <tr>
                            <td>{{ $learning->subject->nama_mapel }}</td>
                            <td>{{ $learning->room->tingkat }}-{{ $learning->room->rombongan }} {{ $learning->room->nama_jurusan ?? '' }}</td>
                            <td>{{ $learning->academicPeriod->semester }} {{ $learning->academicPeriod->tahun_ajaran }}</td>
                            <td>
                                {{-- Tombol Input Nilai Akhir --}}
                                <a href="{{ route('nilai-akhir.edit', $learning->id) }}" class="btn btn-primary btn-sm mr-2">Input Nilai</a>
                                
                                {{-- TOMBOL BARU: Kelola Tujuan Pembelajaran --}}
                                <a href="{{ route('tujuan-pembelajaran.index', $learning->id) }}" class="btn btn-info btn-sm">Kelola TP</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script>
        $("#table-sub").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [1]
            }],
            "order": [[0, "desc"]]
        });
    </script>
@endpush