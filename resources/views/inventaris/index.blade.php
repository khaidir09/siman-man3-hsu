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
            <h1>Inventaris</h1>
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
                        <h5 class="modal-title">Cetak Laporan Inventaris</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- Form untuk mengirim data filter cetak --}}
                    <form action="{{ route('inventaris.cetak') }}" method="POST" target="_blank">
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
                <h4>Semua Inventaris</h4>
                <div class="card-header-action">
                    @if (Auth::user()->hasRole('wakamad sarpras'))
                    <a href="{{ route('inventaris.create') }}" class="btn btn-primary">
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
                                <th>Jenis Kegiatan</th>
                                <th>Item</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Total Biaya</th>
                                @if (Auth::user()->hasRole('wakamad sarpras'))
                                <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($infrastructures as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->jenis_kegiatan }}</td>
                                    <td>{{ $item->item }}</td>
                                    <td>{{ $item->jumlah }} {{ $item->satuan }}</td>
                                    <td>Rp. {{ number_format($item->biaya, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($item->total_biaya, 0, ',', '.') }}</td>
                                    @if (Auth::user()->hasRole('wakamad sarpras'))
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ route('inventaris.edit', $item->id) }}"
                                                class="btn btn-primary rounded"><i class="fas fa-edit"></i>
                                            </a>
                                            <a data-toggle="tooltip" data-placement="bottom" title="Hapus" href="{{ route('inventaris.destroy', $item->id) }}"
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