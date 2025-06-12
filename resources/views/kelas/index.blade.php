@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kelas</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Semua Kelas</h4>
                <div class="card-header-action">
                    <a href="{{ route('kelas.create') }}" class="btn btn-primary">
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
                                <th>Tingkat</th>
                                <th>Rombongan</th>
                                <th>Jurusan</th>
                                <th>Wali Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rooms as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->tingkat }}</td>
                                    <td>{{ $item->rombongan }}</td>
                                    <td>{{ $item->major?->nama_jurusan ?? '-' }}</td>
                                    <td>{{ $item->waliKelas?->name ?? '-' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ route('kelas.edit', $item->id) }}"
                                                class="btn btn-primary rounded"><i class="fas fa-edit"></i>
                                            </a>
                                            <a data-toggle="tooltip" data-placement="bottom" title="Hapus" href="{{ route('kelas.destroy', $item->id) }}"
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