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
            <h1>Prestasi Akademik</h1>
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
                        <h5 class="modal-title">Cetak Laporan Prestasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- Form untuk mengirim data filter cetak --}}
                    <form action="{{ route('prestasi.cetak') }}" method="POST" target="_blank">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Pilih Tahun Ajaran</label>
                                <select name="academic_periods_id" class="form-control" required>
                                    @foreach ($academicPeriods as $period)
                                        <option value="{{ $period->id }}">{{ $period->tahun_ajaran }} - {{ $period->semester }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nomor Surat</label>
                                <input type="text" name="nomor_surat" id="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Waktu Rapat</label>
                                <input type="date" name="waktu_rapat" id="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Ditetapkan Tanggal</label>
                                <input type="date" name="ditetapkan_tanggal" id="" class="form-control">
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
                <h4>Semua Prestasi Akademik</h4>
                <div class="card-header-action">
                    @if (Auth::user()->hasRole('wakamad kurikulum'))
                    <a href="{{ route('prestasi-akademik.create') }}" class="btn btn-primary">
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
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>Bin/Binti</th>
                                <th>Kelas</th>
                                <th>Jumlah Nilai</th>
                                <th>Nilai rata-rata</th>
                                <th>Ranking</th>
                                <th>TP/Semester</th>
                                @if (Auth::user()->hasRole('wakamad kurikulum'))
                                <th>Aksi</th>
                                @endif
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
                                    @if (Auth::user()->hasRole('wakamad kurikulum'))
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