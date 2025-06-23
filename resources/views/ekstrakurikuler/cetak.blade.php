<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rangkuman Ekstrakurikuler</title>
    <style>
        /* Mengatur dasar halaman - Sesuai style Anda */
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt; /* Sedikit lebih kecil agar muat di landscape */
            margin: 0;
            padding: 0; /* Menambahkan padding agar ada margin saat dicetak */
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
            font-size: 14pt;
        }
        
        .header-container .titles .sub-title {
            font-size: 16pt;
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
            margin-bottom: 20px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Tabel Laporan - Sesuai style Anda */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt; /* Ukuran font tabel lebih kecil */
        }

        .report-table th, .report-table td {
            border: 1px solid black;
            padding: 6px;
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
            height: 70px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
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
            <p class="main-title">KEMENTERIAN AGAMA REPUBLIK INDONESIA</p>
            <p class="main-title">KANTOR KEMENTERIAN AGAMA KABUPATEN HULU SUNGAI UTARA</p>
            <p class="sub-title">MADRASAH ALIYAH NEGERI 3 HULU SUNGAI UTARA</p>
        </div>
    </div>
    <hr class="double-line">
    
    {{-- JUDUL LAPORAN --}}
    <div class="report-title-section">
        LAPORAN RANGKUMAN KEGIATAN EKSTRAKURIKULER<br>
        {{ $periode }}
    </div>
    
    {{-- TABEL RANGKUMAN --}}
    <table class="report-table">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th>Nama Ekstrakurikuler</th>
                <th>Nama Pembina</th>
                <th width="15%">Jadwal</th>
                <th width="10%">Jumlah Anggota</th>
                <th width="10%">Jumlah Prestasi</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ekstrakurikuler as $item)
                <tr>
                    <td class="col-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_ekskul }}</td>
                    <td>{{ $item->pembina->name ?? 'N/A' }}</td>
                    <td>{{ $item->jadwal_hari }}, {{ \Carbon\Carbon::parse($item->jadwal_waktu)->format('H:i') }}</td>
                    <td class="col-center">{{ $item->students_count }}</td>
                    <td class="col-center">{{ $item->achievements_count }}</td>
                    <td class="col-center">{{ $item->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="col-center">Tidak ada data ekstrakurikuler untuk ditampilkan pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <div class="signature-section">
        <table>
            <tr>
                <td>
                    Mengetahui,<br>
                    Wakamad Kesiswaan
                    <div class="signature-space"></div>
                    <div class="signature-name">{{ $wakamad_kesiswaan->name }}</div>
                    <div>NIP. {{ $wakamad_kesiswaan->nip }}</div>
                </td>
                <td>
                    Amuntai, {{ $tanggal_cetak }}<br>
                    Kepala Madrasah
                    <div class="signature-space"></div>
                    <div class="signature-name">{{ $kepala_madrasah->name ?? '(Nama Kepala Madrasah)' }}</div>
                    <div>NIP. {{ $kepala_madrasah->nip }}</div>
                </td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>
