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
            <h1>Data Ekstrakurikuler</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Semua Data Ekstrakurikuler</h4>
                <div class="card-header-action">
                    <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#cetakRangkumanModal">
                        <i class="fas fa-print"></i> Cetak Laporan
                    </a>
                    {{-- Mengarahkan ke route untuk membuat data ekstrakurikuler baru --}}
                    <a href="{{ route('ekstrakurikuler.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat baru
                    </a>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="cetakRangkumanModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Cetak Laporan Rangkuman Ekskul</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('cetak-rangkuman-ekskul') }}" method="POST" target="_blank">
                            @csrf
                            <div class="modal-body">
                                <p>Silakan pilih parameter untuk laporan yang ingin dicetak.</p>
                                
                                <div class="form-group">
                                    <label>Pilih Tahun Ajaran / Semester <span class="text-danger">*</span></label>
                                    <select name="academic_period_id" class="form-control" required>
                                        <option value="">-- Pilih Periode --</option>
                                        {{-- Asumsi Anda mengirimkan variabel $academicPeriods dari controller --}}
                                        @foreach ($academicPeriods as $period)
                                            <option value="{{ $period->id }}">{{ $period->tahun_ajaran }} - {{ $period->semester }}</option>
                                        @endforeach
                                    </select>
                                </div>
            
                                <div class="form-group">
                                    <label>Nomor Surat (Opsional)</label>
                                    <input type="text" name="nomor_surat" class="form-control" placeholder="Contoh: 123/MAN3/EKS/2025">
                                </div>
            
                                <div class="form-group">
                                    <label>Tanggal Cetak <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_cetak" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
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

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-sub">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Ekskul</th>
                                <th>Pembina</th>
                                <th>Jadwal</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Tahun Ajaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Menggunakan variabel $ekstrakurikuler yang dikirim dari controller --}}
                            @foreach ($ekstrakurikuler as $item)
                                <tr>
                                    {{-- Menggunakan $loop->iteration untuk penomoran berurutan --}}
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_ekskul }}</td>
                                    {{-- Menampilkan nama dari relasi pembina --}}
                                    <td>{{ $item->pembina->name ?? 'N/A' }}</td>
                                    {{-- Menggabungkan hari dan waktu --}}
                                    <td>{{ $item->jadwal_hari }}, {{ \Carbon\Carbon::parse($item->jadwal_waktu)->format('H:i') }}</td>
                                    <td>{{ $item->lokasi }}</td>
                                    <td>
                                        {{-- Memberi warna berbeda untuk Status Aktif dan Tidak Aktif --}}
                                        @if ($item->status == 'Aktif')
                                            <span class="badge badge-success">{{ $item->status }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ $item->status }}</span>
                                        @endif
                                    </td>
                                    {{-- Menampilkan tahun ajaran dari relasi academicPeriod --}}
                                    <td>{{ $item->academicPeriod->tahun_ajaran }} {{ $item->academicPeriod->semester }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            {{-- Tombol Detail untuk melihat anggota dan prestasi --}}
                                            <a data-toggle="tooltip" data-placement="bottom" title="Detail" href="{{ route('ekstrakurikuler.show', $item->id) }}"
                                                class="btn btn-info rounded"><i class="fas fa-eye"></i>
                                            </a>
                                            {{-- Tombol Edit --}}
                                            <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ route('ekstrakurikuler.edit', $item->id) }}"
                                                class="btn btn-primary rounded ml-2"><i class="fas fa-edit"></i>
                                            </a>
                                            {{-- Tombol Hapus --}}
                                            <a data-toggle="tooltip" data-placement="bottom" title="Hapus" href="{{ route('ekstrakurikuler.destroy', $item->id) }}"
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
        // Inisialisasi DataTable
        $("#table-sub").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [7] // Menonaktifkan sorting untuk kolom 'Aksi' (kolom ke-8, index 7)
            }],
             // Mengurutkan berdasarkan Nama Ekskul (kolom kedua, index 1) secara ascending (A-Z)
            "order": [[ 1, "asc" ]]
        });
    </script>
@endpush