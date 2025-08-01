<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <h2>Halo, {{ $counseling->nama_siswa }}</h2>
    <p>Anda telah menerima catatan bimbingan konseling baru pada tanggal <strong>{{ \Carbon\Carbon::parse($counseling->tanggal)->locale('id')->translatedFormat('d F Y') }}</strong>.</p>
    <p>Berikut adalah detailnya:</p>
    <ul>
        <li><strong>Uraian Masalah:</strong> {{ $counseling->uraian_masalah }}</li>
        <li><strong>Pemecahan Masalah:</strong> {{ $counseling->pemecahan_masalah }}</li>
    </ul>
    <p>
        Jenis Bimbingan:
        @if($counseling->is_pribadi) Pribadi @endif
        @if($counseling->is_sosial) Sosial @endif
        @if($counseling->is_belajar) Belajar @endif
        @if($counseling->is_karir) Karir @endif
    </p>
    <p>Silakan hubungi Guru BK Anda jika ada pertanyaan lebih lanjut.</p>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Informasi Pemeriksaan Kesehatan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            font-size: 24px;
            color: #27ae60; /* Warna hijau untuk kesehatan */
            margin-bottom: 20px;
            text-align: center;
            border-bottom: 2px solid #eeeeee;
            padding-bottom: 10px;
        }
        .content p {
            font-size: 16px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .details-table td {
            padding: 10px;
            border: 1px solid #eeeeee;
        }
        .details-table td:first-child {
            background-color: #f9f9f9;
            font-weight: bold;
            width: 150px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="header">Notifikasi Bimbingan Konseling</h1>
        <div class="content">
            <p>
                Halo, <strong>{{ $counseling->nama_siswa }}</strong>,
            </p>
            <p>
                Guru BK telah mencatat bimbingan konseling baru atas nama Anda dengan rincian sebagai berikut:
            </p>

            <table class="details-table">
                <tr>
                    <td>Tanggal</td>
                    <td>{{ \Carbon\Carbon::parse($counseling->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
                </tr>
                <tr>
                    <td>Uraian Masalah</td>
                    <td>{{ $counseling->uraian_masalah }}</td>
                </tr>
                <tr>
                    <td>Pemecahan Masalah</td>
                    <td>{{ $counseling->pemecahan_masalah }}</td>
                </tr>
                <tr>
                    <td>Jenis Bimbingan</td>
                    <td>
                        @if($counseling->is_pribadi) Pribadi @endif
                        @if($counseling->is_sosial) Sosial @endif
                        @if($counseling->is_belajar) Belajar @endif
                        @if($counseling->is_karir) Karir @endif
                    </td>
                </tr>
            </table>

            <p style="margin-top: 20px;">
                Silakan hubungi Guru BK Anda jika ada pertanyaan lebih lanjut.
            </p>
        </div>
        <div class="footer">
            <p>Ini adalah email yang dikirim secara otomatis oleh SIMAN. Mohon untuk tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>