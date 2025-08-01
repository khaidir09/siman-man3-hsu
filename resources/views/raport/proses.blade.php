@extends('layouts.master')
@section('title', 'Proses Rapor ' . $student->nama_lengkap)

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Proses Rapor: {{ $student->nama_lengkap }}</h1>
    </div>

    <div class="section-body">
        <form action="{{ route('rapor.finalize', $reportCard->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="card">
                <div class="card-header">
                    <h4>Pratinjau Rapor | Status <span class="badge badge-warning">{{ $reportCard->status }}</span></h4>
                </div>
                <div class="card-body">
                    {{-- Bagian A: Nilai Akademik --}}
                    <h5>A. Nilai Akademik</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th>Mata Pelajaran</th>
                                    <th>Nilai Akhir</th>
                                    <th>Capaian Kompetensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($details as $detail)
                                    <tr>
                                        <td>{{ $detail->subject->nama_mapel }}</td>
                                        <td class="text-center">{{ $detail->nilai_akhir }}</td>
                                        <td>{{ $detail->deskripsi_capaian }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada nilai akhir yang diinput oleh Guru Mata Pelajaran.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <hr>

                    {{-- Bagian B & C: Ekstrakurikuler dan Kehadiran --}}
                    <div class="row">
                        <div class="col-md-6">
                            <h5>B. Ekstrakurikuler</h5>
                            <ul class="list-group">
                                @forelse($ekskul as $e)
                                    <li class="list-group-item">{{ $e->nama_ekskul }} - (Nilai: {{ $e->pivot->nilai ?? 'Belum ada nilai' }})</li>
                                @empty
                                    <li class="list-group-item">Tidak mengikuti kegiatan ekstrakurikuler.</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>C. Ketidakhadiran</h5>
                            <div class="form-group row">
                                <label for="sakit" class="col-sm-4 col-form-label">Sakit</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="number" name="sakit" id="sakit" class="form-control" value="{{ old('sakit', $reportCard->sakit) }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">hari</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="izin" class="col-sm-4 col-form-label">Izin</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="number" name="izin" id="izin" class="form-control" value="{{ old('izin', $reportCard->izin) }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">hari</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alfa" class="col-sm-4 col-form-label">Tanpa Keterangan</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="number" name="alfa" id="alfa" class="form-control" value="{{ old('alfa', $reportCard->alfa) }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">hari</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    {{-- Bagian D: Catatan Wali Kelas & Finalisasi --}}
                    <div class="form-group">
                        <label for="homeroom_teacher_notes"><h5>D. Catatan Wali Kelas</h5></label>
                        <textarea name="homeroom_teacher_notes" class="form-control" rows="4" 
                                placeholder="Masukkan catatan pengembangan, motivasi, atau masukan untuk siswa..." 
                                {{ $reportCard->status == 'Final' ? 'disabled' : '' }}>{{ $reportCard->homeroom_teacher_notes }}</textarea>
                    </div>
                </div>
            </div>
            @if($reportCard->status == 'Draft')
                <button type="submit" class="btn btn-success btn-lg"><i class="fas fa-check-circle"></i> Finalisasi & Kunci Rapor</button>
            @else
                <div class="alert alert-info d-inline-block">Rapor ini sudah difinalisasi pada {{ $reportCard->updated_at->isoFormat('D MMMM YYYY') }}.</div>
            @endif
        </form>
    </div>
</section>
@endsection