@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Ujian</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Semua Ujian</h4>
                <div class="card-header-action">
                    <a href="{{ route('ujian.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat baru
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-sub">
                        <thead>
                            <tr>
                                <th>
                                    No.
                                </th>
                                <th>Nama Ujian</th>
                                <th>Guru Penanggung Jawab</th>
                                <th>Mata Pelajaran</th>
                                <th>Kelas</th>
                                <th>Periode Akademik</th>
                                <th>Tanggal Ujian</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($exams as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->teacher->name }}</td>
                                    <td>{{ $item->subject->nama_mapel }}</td>
                                    <td>{{ $item->room->tingkat }}-{{ $item->room->rombongan }} {{ $item->room->nama_jurusan }}</td>
                                    <td>{{ $item->academicPeriod->semester }} {{ $item->academicPeriod->tahun_ajaran }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_ujian)->locale('id')->translatedFormat('d F Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a data-toggle="tooltip" data-placement="bottom" title="Edit Jadwal Ujian" href="{{ route('ujian.edit', $item->id) }}"
                                                class="btn btn-primary rounded">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <a data-toggle="tooltip" data-placement="bottom" title="Input Nilai" href="{{ route('input-nilai-ujian', $item->id) }}"
                                                class="btn btn-success rounded ml-2">
                                                <i class="fas fa-keyboard"></i>
                                            </a>

                                            <a data-toggle="tooltip" data-placement="bottom" title="Hapus Jadwal Ujian" href="{{ route('ujian.destroy', $item->id) }}"
                                                class="btn btn-danger delete-item rounded ml-2">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
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