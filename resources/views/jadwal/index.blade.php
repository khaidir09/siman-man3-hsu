@extends('layouts.master')

@push('styles')
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
                    <a href="{{ route('jadwal.create') }}" class="btn btn-primary ml-2">
                        <i class="fas fa-plus"></i> Buat Jadwal Baru
                    </a>
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
                                                        {{-- Cek apakah ada jadwal di slot ini --}}
                                                        @if(isset($schedules[$room->id][$day][$timeSlot->id]))
                                                            @php
                                                                // Ambil data jadwal pertama (seharusnya hanya ada satu)
                                                                $schedule = $schedules[$room->id][$day][$timeSlot->id]->first();
                                                            @endphp
                                                            <div class="schedule-entry">
                                                                <span class="subject">{{ $schedule->subject->nama_mapel ?? 'N/A' }}</span>
                                                                <span class="teacher">{{ $schedule->teacher->name ?? 'N/A' }}</span>

                                                                {{-- Tombol Aksi untuk Jadwal Spesifik Ini --}}
                                                                <div class="schedule-actions">
                                                                    <div class="btn-group" role="group">
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
                                                                </div>
                                                            </div>
                                                        @else
                                                            {{-- Jika slot kosong, tampilkan strip --}}
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
@endsection