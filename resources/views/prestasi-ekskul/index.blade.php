@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Prestasi Ekstrakurikuler</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Semua Prestasi Ekstrakurikuler</h4>
                <div class="card-header-action">
                    <a href="{{ route('prestasi-ekskul.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat baru
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-sub">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tahun</th>
                                <th>Nama Prestasi</th>
                                <th>Siswa</th>
                                <th>Tingkat</th>
                                <th>Penyelenggara</th>
                                <th>Bidang Ekstrakurikuler</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($achievements as $achievement)
                                <tr>
                                <td>{{ $loop->iteration }}</td>
                                    <td>{{ $achievement->tahun }}</td>
                                    <td>{{ $achievement->peringkat }} {{ $achievement->nama_lomba }}</td>
                                    <td>{{ $achievement->student->nama_lengkap }} ({{ $achievement->student->room->tingkat }}-{{ $achievement->student->room->rombongan }} {{ $achievement->student->room->major->nama_jurusan }})</td>
                                    <td>{{ $achievement->tingkat }}</td>
                                    <td>{{ $achievement->penyelenggara }}</td>
                                    <td>{{ $achievement->extracurricular->nama_ekskul }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @if ($achievement->sertifikat)
                                            <a href="#" class="btn btn-info view-sertifikat-btn" 
                                                data-image-url="{{ Storage::url($achievement->sertifikat) }}" 
                                                data-toggle="modal" 
                                                data-target="#sertifikatModal"
                                                data-placement="bottom" title="Lihat Sertifikat">
                                                    <i class="fas fa-image"></i>
                                                </a>
                                            @endif
                                            {{-- Tombol Edit --}}
                                            <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ route('prestasi-ekskul.edit', $achievement->id) }}"
                                                class="btn btn-primary rounded ml-2"><i class="fas fa-edit"></i>
                                            </a>
                                            {{-- Tombol Hapus --}}
                                            <a data-toggle="tooltip" data-placement="bottom" title="Hapus" href="{{ route('prestasi-ekskul.destroy', $achievement->id) }}"
                                                class="btn btn-danger delete-item rounded ml-2"><i
                                                    class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada prestasi yang dicatat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" tabindex="-1" role="dialog" id="sertifikatModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sertifikat Prestasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    {{-- Gambar akan dimasukkan di sini oleh JavaScript --}}
                    <img src="" id="modalImage" class="img-fluid">
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
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

        // Script baru untuk handle modal gambar
        $(document).ready(function() {
            $('.view-sertifikat-btn').on('click', function(e) {
                e.preventDefault(); // Mencegah link default berjalan

                // 1. Ambil URL gambar dari atribut data-image-url
                var imageUrl = $(this).data('image-url');

                // 2. Set atribut 'src' pada gambar di dalam modal
                $('#modalImage').attr('src', imageUrl);

                // 3. Tampilkan modal (Bootstrap akan menanganinya via data-toggle,
                //    tapi ini cara manual jika diperlukan)
                // $('#sertifikatModal').modal('show');
            });
        });
    </script>
@endpush