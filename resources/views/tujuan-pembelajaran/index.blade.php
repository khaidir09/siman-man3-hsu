@extends('layouts.master')

@section('title', 'Kelola Tujuan Pembelajaran')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Tujuan Pembelajaran</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Daftar Tujuan Pembelajaran</h4>
            <div class="card-header-action">
                <a href="{{ route('tujuan-pembelajaran.create', $learning->id) }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Baru
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table-sub">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Periode Ajaran</th>
                            <th>Deskripsi Tujuan Pembelajaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($learningObjectives as $item)
                            <tr>
                                <td class="text-center">
                                    {{ $learningObjectives->firstItem() + $loop->index }}
                                </td>
                                <td>{{ $item->learning->subject->nama_mapel ?? 'N/A' }}</td>
                                <td>{{ $item->learning->room->tingkat }}-{{ $item->learning->room->rombongan }} {{ $item->learning->room->nama_jurusan ?? '' }}</td>
                                <td>{{ $item->learning->academicPeriod->semester ?? 'N/A' }} {{ $item->learning->academicPeriod->tahun_ajaran ?? 'N/A' }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        {{-- Tombol Edit dan Hapus hanya untuk role tertentu --}}
                                        @if (Auth::user()->hasRole('wakamad kurikulum') || Auth::user()->hasRole('guru'))
                                        {{-- Tombol Edit --}}
                                        <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ route('tujuan-pembelajaran.edit', ['learning' => $learning->id, 'tujuan_pembelajaran' => $item->id]) }}"
                                            class="btn btn-primary rounded ml-2"><i class="fas fa-edit"></i>
                                        </a>
                                        {{-- Tombol Hapus dengan konfirmasi --}}
                                        <a data-toggle="tooltip" data-placement="bottom" title="Hapus" href="{{ route('tujuan-pembelajaran.destroy', ['learning' => $learning->id, 'tujuan_pembelajaran' => $item->id]) }}"
                                            class="btn btn-danger delete-item rounded ml-2"><i
                                                class="fas fa-trash-alt"></i>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    Data tujuan pembelajaran belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="float-right">
                {{ $learningObjectives->links() }}
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script>
        $("#table-sub").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [1]
            }],
            "order": [[0, "desc"]]
        });
    </script>
@endpush