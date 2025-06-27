@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Jadwal Umum</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Semua Data Jadwal Umum</h4>
                <div class="card-header-action">
                    @if (Auth::user()->hasRole('wakamad kurikulum'))
                    <a href="{{ route('jadwal-umum.create') }}" class="btn btn-primary">
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
                                <th>No.</th>
                                <th>Nama Kegiatan</th>
                                <th>Hari</th>
                                <th>Waktu</th>
                                <th>Tahun Ajaran</th>
                                <th>Keterangan</th>
                                @if (Auth::user()->hasRole('wakamad kurikulum'))
                                <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($generalSchedules as $schedule)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $schedule->nama_kegiatan }}</td>
                                    <td>{{ $schedule->hari }}</td>
                                    {{-- Menggabungkan waktu mulai dan selesai --}}
                                    <td>
                                        {{ \Carbon\Carbon::parse($schedule->startTimeSlot->waktu_mulai)->format('H:i') ?? '' }}
                                        -
                                        {{ \Carbon\Carbon::parse($schedule->endTimeSlot->waktu_selesai)->format('H:i') ?? '' }}
                                    </td>
                                    <td>{{ $schedule->academicPeriod->tahun_ajaran ?? 'N/A' }} {{ $schedule->academicPeriod->semester }}</td>
                                    <td>{{ $schedule->keterangan ?? '-' }}</td>
                                    @if (Auth::user()->hasRole('wakamad kurikulum'))
                                    <td>
                                        <div class="btn-group" role="group">
                                            {{-- Tombol Edit --}}
                                            <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ route('jadwal-umum.edit', $schedule->id) }}"
                                                class="btn btn-primary rounded"><i class="fas fa-edit"></i>
                                            </a>
                                            {{-- Tombol Hapus (akan memicu SweetAlert) --}}
                                            <a data-toggle="tooltip" data-placement="bottom" title="Hapus" href="{{ route('jadwal-umum.destroy', $schedule->id) }}"
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
        // Inisialisasi DataTable
        $("#table-sub").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [6] // Menonaktifkan sorting untuk kolom 'Aksi' (kolom ke-7, index 6)
            }],
            // Mengurutkan berdasarkan ID atau data lain yang relevan
            "order": [[ 0, "asc" ]]
        });
    </script>
@endpush