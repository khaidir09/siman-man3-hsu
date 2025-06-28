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
            <h1>Data Kehadiran</h1>
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
                        <h5 class="modal-title">Cetak Laporan Kehadiran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- Form untuk mengirim data filter cetak --}}
                    <form action="{{ route('kehadiran.cetak') }}" method="POST" target="_blank">
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
                <h4>Semua Data Kehadiran</h4>
                <div class="card-header-action">
                    <a href="{{ route('kehadiran.create') }}" class="btn btn-primary">
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
                                <th>Bulan</th>
                                <th>Kelas</th>
                                <th>Izin</th>
                                <th>Sakit</th>
                                <th>Alpa</th>
                                <th>Jumlah Absen</th>
                                <th>Hari Efektif</th>
                                <th>Jumlah Siswa</th>
                                <th>Rata-rata Kehadiran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendances as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->bulan)->locale('id')->translatedFormat('F Y') }}</td>
                                    <td>{{ $item->room->tingkat }}-{{ $item->room->rombongan }} {{ $item->room->nama_jurusan }}</td>
                                    <td>{{ $item->izin }}</td>
                                    <td>{{ $item->sakit }}</td>
                                    <td>{{ $item->alpa }}</td>
                                    <td>{{ $item->jumlah_absen }}</td>
                                    <td>{{ $item->hari_efektif }}</td>
                                    <td>{{ $item->jumlah_siswa }}</td>
                                    <td>{{ $item->rata_rata }} %</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ route('kehadiran.edit', $item->id) }}"
                                                class="btn btn-primary rounded"><i class="fas fa-edit"></i>
                                            </a>
                                            <a data-toggle="tooltip" data-placement="bottom" title="Hapus" href="{{ route('kehadiran.destroy', $item->id) }}"
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