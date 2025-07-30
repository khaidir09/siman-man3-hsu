@extends('layouts.master')

@section('title', 'Mata Pelajaran yang Diampu')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Mata Pelajaran</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dasbor</a></div>
            <div class="breadcrumb-item">Mata Pelajaran</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Mata Pelajaran yang Anda Ampu</h4>
                        {{-- Tombol Tambah hanya muncul untuk admin/wakasek --}}
                        @if(Auth::user()->hasRole('wakasek kurikulum'))
                            <div class="card-header-action">
                                <a href="#" class="btn btn-primary">Tambah Data</a>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Kelas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($groupedSubjects as $subjectName => $schedules)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>{{ $subjectName }}</td>
                                            <td>
                                                {{-- Loop dalam untuk setiap kelas di mana mapel ini diajarkan --}}
                                                @foreach ($schedules as $schedule)
                                                    <span class="badge badge-light">{{ $schedule->room->tingkat }} {{ $schedule->room->rombongan }}</span>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                Anda belum tercatat mengampu mata pelajaran apapun.
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