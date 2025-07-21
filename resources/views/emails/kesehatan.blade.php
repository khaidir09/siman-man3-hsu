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
        <h1 class="header">Informasi Kesehatan UKS</h1>
        <div class="content">
            <p>
                Halo, <strong>{{ $healthCare->nama_siswa }}</strong>,
            </p>
            <p>
                Petugas UKS telah mencatat data pemeriksaan kesehatan atas nama Anda dengan rincian sebagai berikut:
            </p>

            <table class="details-table">
                <tr>
                    <td>Tanggal</td>
                    <td>{{ \Carbon\Carbon::parse($healthCare->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
                </tr>
                <tr>
                    <td>Keluhan</td>
                    <td>{{ $healthCare->keluhan }}</td>
                </tr>
                <tr>
                    <td>Hasil Pemeriksaan</td>
                    <td>{{ $healthCare->hasil_pemeriksaan }}</td>
                </tr>
            </table>

            <p style="margin-top: 20px;">
                Semoga lekas sembuh dan dapat kembali beraktivitas seperti sedia kala.
            </p>
        </div>
        <div class="footer">
            <p>Ini adalah email yang dikirim secara otomatis oleh SIMAN. Mohon untuk tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>