<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Detail Ekstrakurikuler - {{ $ekskul->nama_ekskul }}</title>
    <style>
        /* Mengatur dasar halaman - Sesuai style Anda */
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            margin: 0;
            padding: 2cm; /* Menambahkan padding agar ada margin saat dicetak */
        }

        /* Pengaturan Kop Surat - Sesuai style Anda */
        .header-container {
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 2px;
        }
        
        .header-container .titles {
            text-align: center;
            font-weight: bold;
        }

        .header-container .titles p {
            margin: 0;
            line-height: 1.2;
            text-transform: uppercase;
        }

        .header-container .titles .main-title {
            font-size: 16pt;
        }
        
        .header-container .titles .sub-title {
            font-size: 18pt;
        }

        hr.double-line {
            border: 0;
            border-top: 1px solid black;
            margin: 0;
        }

        /* Pengaturan Judul Laporan - Sesuai style Anda */
        .report-title-section {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 30px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Tabel Laporan - Sesuai style Anda */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12pt;
            margin-top: 1rem;
        }

        .report-table th, .report-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        .report-table th {
            text-align: center;
            background-color: #f2f2f2;
            font-weight: bold;
        }
        
        .report-table .col-center {
            text-align: center;
        }

        /* Bagian Tanda Tangan - Sesuai style Anda */
        .signature-section {
            margin-top: 40px;
        }
        
        .signature-section table {
            width: 100%;
        }
        
        .signature-section td {
            width: 50%;
            text-align: center;
        }

        .signature-space {
            height: 80px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }
        
        .text-bold {
            font-weight: bold;
        }
        
        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

<div>
    {{-- KOP SURAT --}}
    <div class="text-center">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents($imagePath)) }}" alt="Logo Kemenag" height="70">
    </div>
    <div class="header-container">
        <div class="titles">
            <p>KEMENTERIAN AGAMA REPUBLIK INDONESIA</p>
            <p>KANTOR KEMENTERIAN AGAMA KABUPATEN HULU SUNGAI UTARA</p>
            <p class="sub-title">MADRASAH ALIYAH NEGERI 3 HULU SUNGAI UTARA</p>
        </div>
    </div>
    <hr class="double-line">
    
    {{-- JUDUL LAPORAN --}}
    <div class="report-title-section">
        LAPORAN KEGIATAN EKSTRAKURIKULER {{ $ekskul->nama_ekskul }}<br>
        {{ $periode }}
    </div>

    {{-- INFORMASI UMUM --}}
    <div class="info-section">
        <h4 class="text-bold">A. Informasi Umum</h4>
        <table style="width: 50%;">
            <tr>
                <td style="text-align: left; padding: 2px 0;" width="40%"><strong>Pembina</strong></td>
                <td width="5%">:</td>
                <td style="text-align: left;">{{ $ekskul->pembina->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="text-align: left; padding: 2px 0;"><strong>Jadwal Rutin</strong></td>
                <td>:</td>
                <td style="text-align: left;">{{ $ekskul->jadwal_hari }}, Pukul {{ \Carbon\Carbon::parse($ekskul->jadwal_waktu)->format('H:i') }}</td>
            </tr>
        </table>
    </div>

    {{-- DAFTAR ANGGOTA --}}
    <div class="data-section" style="margin-top: 20px;">
        <h4 class="text-bold">B. Daftar Anggota</h4>
        <table class="report-table">
            <thead>
                <tr>
                    <th width="5%">No.</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th width="15%">Kelas</th>
                    <th width="20%">Jabatan</th>
                    <th width="10%">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($anggota as $item)
                    <tr>
                        <td class="col-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->nisn }}</td>
                        <td>{{ $item->nama_lengkap }}</td>
                        <td class="col-center">{{ $item->room->tingkat }} -{{ $item->room->rombongan }} @if ($item->room->nama_jurusan)
                            ({{ $item->room->nama_jurusan }})
                            @endif</td>
                        <td>{{ $item->pivot->jabatan }}</td>
                        <td class="col-center">{{ $item->pivot->nilai ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="col-center">Tidak ada anggota yang terdaftar pada periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{-- DAFTAR PRESTASI --}}
    <div class="data-section" style="margin-top: 20px;">
        <h4 class="text-bold">C. Daftar Prestasi</h4>
        <table class="report-table">
            <thead>
                <tr>
                    <th width="5%">No.</th>
                    <th>Nama Lomba/Kegiatan</th>
                    <th>Peringkat</th>
                    <th>Tingkat</th>
                    <th>Tahun</th>
                    <th>Siswa Peraih</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($prestasi as $item)
                    <tr>
                        <td class="col-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_lomba }}</td>
                        <td class="col-center">{{ $item->peringkat }}</td>
                        <td class="col-center">{{ $item->tingkat }}</td>
                        <td class="col-center">{{ $item->tahun }}</td>
                        <td>{{ $item->student->nama_lengkap ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="col-center">Tidak ada prestasi yang dicatat pada periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- TANDA TANGAN --}}
    <div class="signature-section">
        <table>
            <tr>
                <td>
                    Mengetahui,<br>
                    Kepala Madrasah
                    <div class="signature-space"></div>
                    <div class="signature-name">{{ $kepala_madrasah->name ?? 'Nama Kepala Madrasah' }}</div>
                    <div>NIP. {{ $kepala_madrasah->nip ?? 'NIP Kepala Madrasah' }}</div>
                </td>
                <td>
                    Amuntai, {{ $tanggal_cetak }}<br>
                    Pembina Ekstrakurikuler
                    <div class="signature-space"></div>
                    <div class="signature-name">{{ $ekskul->pembina->name ?? 'Nama Pembina' }}</div>
                    <div>NIP. {{ $ekskul->pembina->nip ?? 'NIP Pembina' }}</div>
                </td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>
