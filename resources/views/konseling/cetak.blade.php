<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bimbingan Konseling</title>
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
        DAFTAR BIMBINGAN KONSELING SISWA-SISWI MAN 3 HULU SUNGAI UTARA<br>
        PERIODE {{ $periode }}
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th width="15%">Tanggal</th>
                <th>Nama Siswa</th>
                <th width="10%">Kelas</th>
                <th>Uraian Masalah</th>
                <th>Pemecahan Masalah</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($konseling as $item)
                <tr>
                    <td class="col-center">{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d F Y') }}</td>
                    <td>{{ $item->nama_siswa }}</td>
                    <td class="col-center">{{ $item->kelas }}</td>
                    <td>{{ $item->uraian_masalah }}</td>
                    <td>{{ $item->pemecahan_masalah }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="col-center">Tidak ada data bimbingan konseling untuk periode ini.</td>
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
