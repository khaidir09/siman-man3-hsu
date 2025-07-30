@extends('layouts.master')

@push('style')
{{-- Style tambahan untuk membuat tabel jadwal lebih rapi --}}
<style>
    .schedule-table th, .schedule-table td {
        text-align: center;
        vertical-align: middle !important;
        min-width: 150px; /* Lebar minimum per kolom hari */
    }
    .schedule-table .time-col {
        min-width: 120px; /* Lebar kolom waktu */
        font-weight: bold;
        background-color: #f8f9fa;
    }
    .schedule-entry {
        background-color: #e9f5ff;
        border-radius: 5px;
        padding: 8px;
        margin: auto;
        font-size: 13px;
        position: relative;
    }
    .schedule-entry .subject {
        font-weight: bold;
        display: block;
        color: #0d6efd;
    }
    .schedule-entry .teacher {
        font-size: 12px;
        display: block;
        color: #6c757d;
    }
    .schedule-actions {
        position: absolute;
        top: 2px;
        right: 2px;
    }
    .schedule-actions .btn {
        padding: 0.1rem 0.3rem;
        font-size: 0.7rem;
    }
    .modal-backdrop {
        position: relative;
    }
</style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Jadwal Pelajaran</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Jadwal Pelajaran per Kelas</h4>
                <div class="card-header-action">
                    {{-- TODO: Tambahkan logika filter tahun ajaran di sini --}}
                    {{-- <select class="form-control">
                        @foreach ($academicPeriods as $period)
                            <option value="{{ $period->id }}">{{ $period->tahun_ajaran }}</option>
                        @endforeach
                    </select> --}}
                    @if (Auth::user()->hasRole('wakamad kurikulum'))
                    <a href="{{ route('jadwal.create') }}" class="btn btn-primary ml-2">
                        <i class="fas fa-plus"></i> Buat Jadwal Baru
                    </a>
                    @endif
                </div>
            </div>

            <div class="card-body">
                {{-- Navigasi Tabs untuk Setiap Kelas --}}
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @foreach ($rooms as $room)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $room->id }}" data-toggle="tab" href="#content-{{ $room->id }}" role="tab" aria-controls="content-{{ $room->id }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                Kelas {{ $room->tingkat }}-{{ $room->rombongan }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                {{-- Konten untuk Setiap Tab --}}
                <div class="tab-content" id="myTabContent">
                    @foreach ($rooms as $room)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="content-{{ $room->id }}" role="tabpanel" aria-labelledby="tab-{{ $room->id }}">
                            <div class="p-3">
                                <h5>Wali Kelas: {{ $room->waliKelas->name ?? 'Belum Ditentukan' }}</h5>
                                <div>
                                    <a href="#" class="btn btn-dark print-schedule-btn" 
                                       data-toggle="modal" 
                                       data-target="#cetakJadwalModal"
                                       data-room-id="{{ $room->id }}">
                                        <i class="fas fa-print"></i> Cetak Jadwal Kelas
                                    </a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered schedule-table">
                                    <thead>
                                        <tr>
                                            <th class="time-col">Jam / Waktu</th>
                                            @foreach ($days as $day)
                                                <th>{{ $day }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($timeSlots as $timeSlot)
                                            <tr>
                                                <td class="time-col">
                                                    Jam Ke-{{ $timeSlot->jam_ke }}<br>
                                                    <small>({{ \Carbon\Carbon::parse($timeSlot->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($timeSlot->waktu_selesai)->format('H:i') }})</small>
                                                </td>
                                                @foreach ($days as $day)
                                                    <td>
                                                        @if(isset($generalEvents[$day][$timeSlot->id]))
                                                            <div class="schedule-entry" style="background-color: #fff3cd;"> {{-- Beri warna berbeda --}}
                                                                <span class="subject">{{ $generalEvents[$day][$timeSlot->id] }}</span>
                                                                <span class="teacher"></span>
                                                            </div>

                                                        {{-- 2. Jika tidak ada, baru cek Jadwal Pelajaran biasa --}}
                                                        @elseif(isset($schedules[$room->id][$day][$timeSlot->id]))
                                                            @php
                                                                $schedule = $schedules[$room->id][$day][$timeSlot->id]->first();
                                                            @endphp
                                                            <div class="schedule-entry">
                                                                <span class="subject">{{ $schedule->learning->subject->nama_mapel ?? 'N/A' }}</span>
                                                                <span class="teacher">{{ $schedule->learning->user->name ?? 'N/A' }}</span>
                                                                @if (Auth::user()->hasRole('wakamad kurikulum'))
                                                                <div class="schedule-actions">
                                                                    <a href="{{ route('jadwal.edit', $schedule->id) }}" class="btn btn-sm btn-light" title="Edit"><i class="fas fa-pencil-alt"></i></a>

                                                                    {{-- Tombol Clone (di dalam form) --}}
                                                                    <form action="{{ route('jadwal.clone', $schedule->id) }}" method="POST" class="d-inline-block">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-sm btn-light" title="Clone">
                                                                            <i class="fas fa-clone"></i>
                                                                        </button>
                                                                    </form>

                                                                    <a href="{{ route('jadwal.destroy', $schedule->id) }}" class="btn btn-sm btn-light delete-item" title="Hapus"><i class="fas fa-trash-alt"></i></a>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            
                                                        @else
                                                            {{-- Jika slot kosong --}}
                                                            -
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" tabindex="-1" role="dialog" id="cetakJadwalModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cetak Jadwal Pelajaran Kelas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- Form ini akan mengirim parameter ke controller cetak --}}
                <form action="{{ route('cetak-jadwal-kelas') }}" method="POST" target="_blank">
                    @csrf
                    <div class="modal-body">
                        <p>Silakan pilih parameter untuk laporan yang ingin dicetak.</p>
                        
                        {{-- Input tersembunyi untuk mengirim ID kelas, nilainya akan diisi oleh JavaScript --}}
                        <input type="hidden" name="room_id" id="modal_room_id" value="">
    
                        <div class="form-group">
                            <label>Pilih Tahun Ajaran / Semester <span class="text-danger">*</span></label>
                            {{-- Dropdown ini menggunakan $academicPeriods yang sudah ada di controller index --}}
                            <select name="academic_period_id" class="form-control" required>
                                <option value="">-- Pilih Periode --</option>
                                @foreach ($academicPeriods as $period)
                                    <option value="{{ $period->id }}">{{ $period->tahun_ajaran }} - {{ $period->semester }}</option>
                                @endforeach
                            </select>
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
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            // Gunakan event delegation pada elemen statis yang lebih tinggi, misal 'body' atau '.card'
            $('body').on('click', '.print-schedule-btn', function(e) {
                e.preventDefault(); 

                const roomId = $(this).data('room-id');

                // Set nilai pada SATU-SATUNYA input modal yang ada
                $('#modal_room_id').val(roomId);
            });
        });
    </script>
@endpush