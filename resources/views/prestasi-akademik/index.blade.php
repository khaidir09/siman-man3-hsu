@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Prestasi Akademik</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Semua Prestasi Akademik</h4>
                <div class="card-header-action">
                    <a href="{{ route('prestasi-akademik.create') }}" class="btn btn-primary">
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
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>Bin/Binti</th>
                                <th>Kelas</th>
                                <th>Jumlah Nilai</th>
                                <th>Nilai rata-rata</th>
                                <th>Ranking</th>
                                <th>TP/Semester</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($academic_achievements as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->nisn }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->ortu }}</td>
                                    <td>{{ $item->room->tingkat}}-{{ $item->room->rombongan}} {{ $item->nama_jurusan}}</td>
                                    <td>{{ $item->jumlah_nilai }}</td>
                                    <td>{{ $item->rata_rata }}</td>
                                    <td>{{ $item->ranking }}</td>
                                    <td>{{ $item->period->tahun_ajaran }} / {{ $item->period->semester }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ route('prestasi-akademik.edit', $item->id) }}"
                                                class="btn btn-primary rounded"><i class="fas fa-edit"></i>
                                            </a>
                                            <a data-toggle="tooltip" data-placement="bottom" title="Hapus" href="{{ route('prestasi-akademik.destroy', $item->id) }}"
                                                class="btn btn-danger delete-item rounded ml-2"><i
                                                    class="fas fa-trash-alt"></i>
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