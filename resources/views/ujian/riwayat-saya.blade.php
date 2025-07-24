@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Ujian</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header"><h4>Riwayat Nilai Ujian Saya</h4></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Ujian</th>
                                    <th>Guru Mapel</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Tanggal Ujian</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($scores as $score)
                                    <tr>
                                        <td>{{ $score->exam->name }} {{ $score->exam->academicPeriod->semester }} {{ $score->exam->academicPeriod->tahun_ajaran }}</td>
                                        <td>{{ $score->exam->teacher->name }}</td>
                                        <td>{{ $score->exam->subject->nama_mapel }}</td>
                                        <td>{{ \Carbon\Carbon::parse($score->exam->exam_date)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                        <td>
                                            <div class="badge badge-primary" style="font-size: 14px;">{{ $score->score }}</div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada data nilai ujian.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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