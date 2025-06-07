@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Ekstrakurikuler</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Perbarui Data Ekstrakurikuler</h4>
            </div>
            <div class="card-body">
                {{-- Mengarahkan form action ke route update untuk ekstrakurikuler --}}
                <form action="{{ route('ekstrakurikuler.update', $ekstrakurikuler->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="kelompok">Kelompok Ekstrakurikuler <span class="text-danger">*</span></label>
                        <select name="kelompok" id="kelompok" class="form-control">
                             <option value="">Pilih Kelompok</option>
                             <option value="Olahraga" {{ old('kelompok', $ekstrakurikuler->kelompok) == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                             <option value="Seni" {{ old('kelompok', $ekstrakurikuler->kelompok) == 'Seni' ? 'selected' : '' }}>Seni</option>
                             <option value="Paskibra" {{ old('kelompok', $ekstrakurikuler->kelompok) == 'Paskibra' ? 'selected' : '' }}>Paskibra</option>
                        </select>
                        @error('kelompok')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama_ekskul">Nama Ekstrakurikuler <span class="text-danger">*</span></label>
                        {{-- Helper old() akan menampilkan input baru jika validasi gagal, jika tidak, tampilkan data dari database --}}
                        <input name="nama_ekskul" id="nama_ekskul" type="text" class="form-control" value="{{ old('nama_ekskul', $ekstrakurikuler->nama_ekskul) }}">
                        @error('nama_ekskul')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="pembina_id">Pembina <span class="text-danger">*</span></label>
                        <select name="pembina_id" id="pembina_id" class="form-control">
                            <option value="">Pilih Pembina</option>
                            @foreach ($pembina as $user)
                                {{-- Kondisi untuk memilih pembina yang sesuai --}}
                                <option value="{{ $user->id }}" {{ old('pembina_id', $ekstrakurikuler->pembina_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('pembina_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control">
                            <option value="">Pilih Status</option>
                            <option value="Aktif" {{ old('status', $ekstrakurikuler->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status', $ekstrakurikuler->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jadwal_hari">Hari Latihan Rutin <span class="text-danger">*</span></label>
                        <select name="jadwal_hari" id="jadwal_hari" class="form-control">
                             <option value="">Pilih Hari</option>
                             <option value="Senin" {{ old('jadwal_hari', $ekstrakurikuler->jadwal_hari) == 'Senin' ? 'selected' : '' }}>Senin</option>
                             <option value="Selasa" {{ old('jadwal_hari', $ekstrakurikuler->jadwal_hari) == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                             <option value="Rabu" {{ old('jadwal_hari', $ekstrakurikuler->jadwal_hari) == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                             <option value="Kamis" {{ old('jadwal_hari', $ekstrakurikuler->jadwal_hari) == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                             <option value="Jumat" {{ old('jadwal_hari', $ekstrakurikuler->jadwal_hari) == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                             <option value="Sabtu" {{ old('jadwal_hari', $ekstrakurikuler->jadwal_hari) == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                             <option value="Minggu" {{ old('jadwal_hari', $ekstrakurikuler->jadwal_hari) == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                        </select>
                        @error('jadwal_hari')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jadwal_waktu">Waktu Latihan (Mulai) <span class="text-danger">*</span></label>
                        <input name="jadwal_waktu" id="jadwal_waktu" type="time" class="form-control" value="{{ old('jadwal_waktu', $ekstrakurikuler->jadwal_waktu) }}">
                        @error('jadwal_waktu')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="lokasi">Lokasi Latihan <span class="text-danger">*</span></label>
                        <input name="lokasi" id="lokasi" type="text" class="form-control" value="{{ old('lokasi', $ekstrakurikuler->lokasi) }}">
                        @error('lokasi')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tahun_ajaran_id">Tahun Ajaran <span class="text-danger">*</span></label>
                        <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-control">
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach ($academicPeriods as $period)
                                <option value="{{ $period->id }}" {{ old('tahun_ajaran_id', $ekstrakurikuler->tahun_ajaran_id) == $period->id ? 'selected' : '' }}>
                                    {{ $period->tahun_ajaran }} {{ $period->semester }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" style="height: 100px;">{{ old('deskripsi', $ekstrakurikuler->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </form>
            </div>
        </div>
    </section>
@endsection