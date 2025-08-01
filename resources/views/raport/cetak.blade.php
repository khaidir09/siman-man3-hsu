<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rapor {{ $reportCard->student->nama_lengkap }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12px; }
        .kop-surat { text-align: center; padding-bottom: 10px; }
        .kop-surat h3, .kop-surat h4 { margin: 0; }
        .table-identity, .table-scores { width: 100%; border-collapse: collapse; }
        .table-identity td { padding: 2px; }
        .table-scores th, .table-scores td { border: 1px solid black; padding: 5px; }
        .table-scores th { background-color: #f2f2f2; }
        h4.section-title { margin-top: 20px; }
        /* Tambahkan style lain sesuai kebutuhan */
    </style>
</head>
<body>
    <div class="kop-surat">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents($imagePath)) }}" alt="Logo Kemenag" height="70">
        <h3>KEMENTERIAN AGAMA REPUBLIK INDONESIA</h3>
        <h4>MADRASAH ALIYAH NEGERI 3 HULU SUNGAI UTARA</h4>
        <small>Jl. Gaya Baru No. 13 Desa Simpang Tiga, Kec. Amuntai Selatan</small>
    </div>

    <table class="table-identity" style="border-bottom: 2px solid black; border-top: 2px solid black;">
        <tr>
            <td width="15%">Nama</td>
            <td width="1%">:</td>
            <td width="34%">{{ $reportCard->student->nama_lengkap }}</td>
            <td width="15%">Kelas</td>
            <td width="1%">:</td>
            <td width="34%">{{ $reportCard->room->tingkat }}-{{ $reportCard->room->rombongan }} {{ $reportCard->room->nama_jurusan }}</td>
        </tr>
        <tr>
            <td>NISN</td>
            <td>:</td>
            <td>{{ $reportCard->student->nisn }}</td>
            <td>Semester</td>
            <td>:</td>
            <td>{{ $reportCard->academicPeriod->semester }}</td>
        </tr>
        <tr>
            <td>Madrasah</td>
            <td>:</td>
            <td>MAN 3 HULU SUNGAI UTARA</td>
            <td>Tahun Pelajaran</td>
            <td>:</td>
            <td>{{ $reportCard->academicPeriod->tahun_ajaran }}</td>
        </tr>
    </table>

    <h4 style="text-align:center;">CAPAIAN HASIL BELAJAR</h4>
    
    <table class="table-scores">
        <thead style="text-align: center;">
            <tr>
                <th width="5%">No</th>
                <th>Mata Pelajaran</th>
                <th width="15%">Nilai Akhir</th>
                <th>Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            {{-- Loop langsung ke detail tanpa pengelompokan --}}
            @forelse ($reportCard->details as $detail)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $detail->subject->nama_mapel }}</td>
                    <td style="text-align: center;">
                        {{ $detail->nilai_akhir }}
                    </td>
                    <td style="text-align: justify;">{{ $detail->deskripsi_capaian }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada data nilai yang difinalisasi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h4 class="section-title">Ekstrakurikuler</h4>
    <table class="table-scores">
        <thead style="text-align: center;">
            <tr>
                <th width="5%">No</th>
                <th>Kegiatan Ekstrakurikuler</th>
                <th width="15%">Nilai</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reportCard->student->extracurriculars as $e)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $e->nama_ekskul }}</td>
                    <td style="text-align: center;">{{ $e->pivot->nilai ?? 'Belum ada nilai' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">Tidak mengikuti kegiatan ekstrakurikuler.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h4 class="section-title">Prestasi</h4>
    <table class="table-scores">
        <thead style="text-align: center;">
            <tr>
                <th width="5%">No</th>
                <th>Nama Prestasi / Lomba</th>
                <th>Juara</th>
                <th>Tingkat</th>
            </tr>
        </thead>
        <tbody>
            {{-- Loop data prestasi dari relasi yang sudah di-load --}}
            @forelse ($reportCard->student->achievements as $prestasi)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $prestasi->nama_lomba }}</td>
                    <td>{{ $prestasi->peringkat }}</td>
                    <td style="text-align: center;">{{ $prestasi->tingkat }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 10px;">
                        Belum ada data prestasi yang tercatat pada semester ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h4 class="section-title">Ketidakhadiran</h4>
    <table class="table-scores">
        <tr>
            <td style="font-weight: 600;">Sakit</td>
            <td style="text-align: center;">{{ $reportCard->sakit }}</td>
            <td>Hari</td>
        </tr>
        <tr>
            <td style="font-weight: 600;">Izin</td>
            <td style="text-align: center;">{{ $reportCard->izin }}</td>
            <td>Hari</td>
        </tr>
        <tr>
            <td style="font-weight: 600;">Alpa</td>
            <td style="text-align: center;">{{ $reportCard->alfa }}</td>
            <td>Hari</td>
        </tr>
    </table>

    <h4 class="section-title">Catatan Wali Kelas</h4>
    <table class="table-scores">
        <tr>
            <td colspan="3" style="text-align: justify;">
                {{ $reportCard->homeroom_teacher_notes ?? 'Tidak ada catatan wali kelas.' }}
            </td>
        </tr>
    </table>

    <h4 class="section-title">Tanggapan Orang Tua/Wali</h4>
    <table class="table-scores">
        <tr>
            <td style="color: #fff;">
                Tes
            </td>
        </tr>
    </table>

    <div style="margin-top: 10px;">
        {{-- Baris Tanda Tangan Pertama --}}
        <table style="width: 100%; text-align: center;">
            <tr>
                <td style="width: 50%;">
                    <p>Orang Tua/Wali,</p>
                    <br><br><br><br>
                    <p><strong>________________________</strong></p>
                </td>
                <td style="width: 50%;">
                    <p>Hulu Sungai Utara, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}</p>
                    <p>Wali Kelas,</p>
                    <br><br><br><br>
                    <p>
                        <strong>{{ $reportCard->homeroomTeacher->name }}</strong>
                    </p>
                </td>
            </tr>
        </table>

        {{-- Baris Tanda Tangan Kedua --}}
        <table style="width: 100%; text-align: center; margin-top: 40px;">
            <tr>
                <td>
                    <p>Mengetahui,</p>
                    <p>Kepala Madrasah,</p>
                    <br><br><br><br>
                    <p>
                        {{-- Ganti dengan nama Kepala Madrasah yang sebenarnya --}}
                        <strong>Dr. Hj. Raudlatul Munawarah, M.M.</strong>
                    </p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>