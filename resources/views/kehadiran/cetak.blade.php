<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kehadiran</title>
    <style>
        /* Mengatur dasar halaman */
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            margin: 0;
            padding: 0;
        }

        /* Pengaturan Kop Surat */
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

        /* Pengaturan Judul Laporan */
        .report-title-section {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 30px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Tabel Laporan */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12pt;
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

        /* Bagian Tanda Tangan */
        .signature-section {
            width: 40%;
            margin-left: 60%;
            margin-top: 40px;
        }

        .signature-space {
            height: 80px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }

        .text-center {
            text-align: center;
        }

        /* Styles untuk print */
        @media print {
            body, .page {
                margin: 0;
                box-shadow: none;
                background: white;
            }
        }
    </style>
</head>
<body>

<div class="page">
    <div class="text-center">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents($imagePath)) }}" alt="Logo Kemenag" height="70">
    </div>
    <div class="header-container">
        {{-- Ganti URL logo ini dengan logo Anda. Gunakan asset() untuk file di public folder --}}
        <div class="titles">
            <p>KEMENTERIAN AGAMA REPUBLIK INDONESIA</p>
            <p>KANTOR KEMENTERIAN AGAMA KABUPATEN HULU SUNGAI UTARA</p>
            <p class="sub-title">MADRASAH ALIYAH NEGERI 3 HULU SUNGAI UTARA</p>
        </div>
    </div>
    <hr class="double-line">
    
    <div class="report-title-section">
        KEADAAN PRESENTASE ABSENSI SISWA<br>
        PERIODE {{ $periode }}
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th width="10%">Kelas</th>
                <th>Wali Kelas</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpa</th>
                <th>Jumlah Absen</th>
                <th>Hari Efektif</th>
                <th>Jumlah Siswa</th>
                <th>Rata-rata</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kehadiran as $item)
                <tr>
                    <td class="col-center">{{ $loop->iteration }}</td>
                    <td class="col-center">{{ $item->room->tingkat }}-{{ $item->room->rombongan }} @if ($item->room->nama_jurusan)
                        ({{ $item->room->nama_jurusan }})
                        @endif
                    </td>
                    <td>{{ $item->room->waliKelas->name }}</td>
                    <td class="col-center">{{ $item->izin }}</td>
                    <td class="col-center">{{ $item->sakit }}</td>
                    <td class="col-center">{{ $item->alpa }}</td>
                    <td class="col-center">{{ $item->jumlah_absen }}</td>
                    <td class="col-center">{{ $item->hari_efektif }} Hari</td>
                    <td class="col-center">{{ $item->jumlah_siswa }} Orang</td>
                    <td class="col-center">{{ $item->rata_rata }}%</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="col-center">Tidak ada data kehadiran siswa untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="signature-section">
        Amuntai, {{ $tanggal_cetak }}<br>
        Kepala MAN 3 Hulu Sungai Utara,
        <div class="signature-space"></div>
        <div class="signature-name">Dr. Hj. Raudlatul Munawwarah, M.M</div>
        <div>NIP. 196503141992032004</div>
    </div>

</div>

</body>
</html>
