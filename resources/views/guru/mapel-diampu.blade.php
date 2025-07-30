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
            @if(Auth::user()->hasRole('wakasek kurikulum'))
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