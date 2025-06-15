@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Jadwal Umum</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Buat Jadwal Umum Baru</h4>
            </div>
            <div class="card-body">
                {{-- Mengarahkan form action ke route store untuk jadwal umum --}}
                <form action="{{ route('jadwal-umum.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="nama_kegiatan">Nama Kegiatan <span class="text-danger">*</span></label>
                        <input name="nama_kegiatan" id="nama_kegiatan" type="text" class="form-control" value="{{ old('nama_kegiatan') }}" placeholder="Contoh: Upacara Bendera">
                        @error('nama_kegiatan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="row">
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="academic_period_id">Tahun Ajaran <span class="text-danger">*</span></label>
                                <select name="academic_period_id" id="academic_period_id" class="form-control">
                                    <option value="">Pilih Tahun Ajaran</option>
                                    @foreach ($academicPeriods as $period)
                                        <option value="{{ $period->id }}" {{ old('academic_period_id') == $period->id ? 'selected' : '' }}>
                                            {{ $period->tahun_ajaran }} - {{ $period->semester }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('academic_period_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="time_slot_id_mulai">Jam Mulai <span class="text-danger">*</span></label>
                                <select name="time_slot_id_mulai" id="time_slot_id_mulai" class="form-control">
                                    <option value="">Pilih Jam Mulai</option>
                                    @foreach ($timeSlots as $timeSlot)
                                        <option value="{{ $timeSlot->id }}" {{ old('time_slot_id_mulai') == $timeSlot->id ? 'selected' : '' }}>
                                            Jam Ke-{{ $timeSlot->jam_ke }} ({{ \Carbon\Carbon::parse($timeSlot->waktu_mulai)->format('H:i') }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('time_slot_id_mulai')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="time_slot_id_selesai">Jam Selesai <span class="text-danger">*</span></label>
                                <select name="time_slot_id_selesai" id="time_slot_id_selesai" class="form-control">
                                    <option value="">Pilih Jam Selesai</option>
                                    @foreach ($timeSlots as $timeSlot)
                                        <option value="{{ $timeSlot->id }}" {{ old('time_slot_id_selesai') == $timeSlot->id ? 'selected' : '' }}>
                                            Jam Ke-{{ $timeSlot->jam_ke }} ({{ \Carbon\Carbon::parse($timeSlot->waktu_selesai)->format('H:i') }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('time_slot_id_selesai')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan (Opsional)</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" style="height: 100px;">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Buat Jadwal Umum</button>
                </form>
            </div>
        </div>
    </section>
@endsection
