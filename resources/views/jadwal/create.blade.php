@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Jadwal Pelajaran</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Buat Jadwal Pelajaran Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('jadwal.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="learning_id">Pembelajaran <span class="text-danger">*</span></label>
                                <select name="learning_id" id="learning_id" class="form-control">
                                    <option value="">Pilih Pembelajaran</option>
                                    @foreach ($learnings as $item)
                                        <option value="{{ $item->id }}" {{ old('learning_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->subject->nama_mapel }} - {{ $item->user->name}} ({{ $item->room->tingkat }}-{{ $item->room->rombongan }} {{ $item->room->nama_jurusan }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('learning_id')
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
                                        <option value="{{ $timeSlot->id }}" {{ old('time_slot_id') == $timeSlot->id ? 'selected' : '' }}>
                                            Jam Ke-{{ $timeSlot->jam_ke }} ({{ \Carbon\Carbon::parse($timeSlot->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($timeSlot->waktu_selesai)->format('H:i') }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('time_slot_id')
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
                                        <option value="{{ $day }}" {{ old('hari') == $day ? 'selected' : '' }}>{{ $day }}</option>
                                    @endforeach
                                </select>
                                @error('hari')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Buat Jadwal</button>
                </form>
            </div>
        </div>
    </section>
@endsection