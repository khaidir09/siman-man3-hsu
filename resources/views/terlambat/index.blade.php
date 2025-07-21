@extends('layouts.master')

@push('style')
    <style>
        .modal-backdrop {
            position: relative;
        }
    </style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Pelanggaran Kedisiplinan</h1>
            <div class="section-header-action ml-auto">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#printModal">
                    <i class="fas fa-print"></i> Cetak Laporan
                </a>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="printModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cetak Laporan Pelanggaran Kedisiplinan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- Form untuk mengirim data filter cetak --}}
                    <form action="{{ route('kedisiplinan.cetak') }}" method="POST" target="_blank">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Bulan</label>
                                <input type="month" name="bulan" id="" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Cetak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Semua Data Pelanggaran Kedisiplinan</h4>
                <div class="card-header-action">
                    @if (Auth::user()->hasRole('wakamad kesiswaan') || Auth::user()->hasRole('guru'))
                    <a href="{{ route('terlambat.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat baru
                    </a>
                    @endif
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
                                <th>Tanggal</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Waktu Datang</th>
                                <th>Guru Piket</th>
                                @if (Auth::user()->hasRole('wakamad kesiswaan') || Auth::user()->hasRole('guru'))
                                <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($arrivals as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d F Y') }}</td>
                                    <td>{{ $item->nama_siswa }}</td>
                                    <td>{{ $item->kelas }}</td>
                                    <td>{{ $item->waktu_datang }}</td>
                                    <td>{{ $item->guru_piket }}</td>
                                    @if (Auth::user()->hasRole('wakamad kesiswaan') || Auth::user()->hasRole('guru'))
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ route('terlambat.edit', $item->id) }}"
                                                class="btn btn-primary rounded"><i class="fas fa-edit"></i>
                                            </a>
                                            <a data-toggle="tooltip" data-placement="bottom" title="Hapus" href="{{ route('terlambat.destroy', $item->id) }}"
                                                class="btn btn-danger delete-item rounded ml-2"><i
                                                    class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                    @endif
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