@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Jadwal Pelajaran</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Perbarui Jadwal Pelajaran</h4>
            </div>
            <div class="card-body">
                {{-- Mengarahkan form action ke route update untuk jadwal --}}
                <form action="{{ route('jadwal.update', $schedule->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Method spoofing untuk update --}}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="academic_period_id">Tahun Ajaran <span class="text-danger">*</span></label>
                                <select name="academic_period_id" id="academic_period_id" class="form-control">
                                    <option value="">Pilih Tahun Ajaran</option>
                                    @foreach ($academicPeriods as $period)
                                        {{-- Helper old() akan menampilkan input baru jika validasi gagal, jika tidak, tampilkan data dari database --}}
                                        <option value="{{ $period->id }}" {{ old('academic_period_id', $schedule->academic_period_id) == $period->id ? 'selected' : '' }}>
                                            {{ $period->tahun_ajaran }} - {{ $period->semester }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('academic_period_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hari">Hari <span class="text-danger">*</span></label>
                                <select name="hari" id="hari" class="form-control">
                                    <option value="">Pilih Hari</option>
                                    @foreach ($days as $day)
                                        <option value="{{ $day }}" {{ old('hari', $schedule->hari) == $day ? 'selected' : '' }}>{{ $day }}</option>
                                    @endforeach
                                </select>
                                @error('hari')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="room_id">Kelas <span class="text-danger">*</span></label>
                                <select name="room_id" id="room_id" class="form-control">
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}" {{ old('room_id', $schedule->room_id) == $room->id ? 'selected' : '' }} class="text-uppercase">
                                            {{ $room->tingkat }}-{{ $room->rombongan }} {{ $room->major->nama_jurusan ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="form-group">
                                <label for="time_slot_id">Jam Pelajaran <span class="text-danger">*</span></label>
                                <select name="time_slot_id" id="time_slot_id" class="form-control">
                                    <option value="">Pilih Jam Pelajaran</option>
                                     @foreach ($timeSlots as $timeSlot)
                                        <option value="{{ $timeSlot->id }}" {{ old('time_slot_id', $schedule->time_slot_id) == $timeSlot->id ? 'selected' : '' }}>
                                            Jam Ke-{{ $timeSlot->jam_ke }} ({{ \Carbon\Carbon::parse($timeSlot->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($timeSlot->waktu_selesai)->format('H:i') }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('time_slot_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                         <div class="col-md-6">
                            <div class="form-group">
                                <label for="subject_id">Mata Pelajaran <span class="text-danger">*</span></label>
                                <select name="subject_id" id="subject_id" class="form-control">
                                    <option value="">Pilih Mata Pelajaran</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ old('subject_id', $schedule->subject_id) == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->nama_mapel }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="form-group">
                                <label for="user_id">Guru Pengajar <span class="text-danger">*</span></label>
                                <select name="user_id" id="user_id" class="form-control">
                                    <option value="">Pilih Guru</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ old('user_id', $schedule->user_id) == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Perbarui Jadwal</button>
                </form>
            </div>
        </div>
    </section>
@endsection