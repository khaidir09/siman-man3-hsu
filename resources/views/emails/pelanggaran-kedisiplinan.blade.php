<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Pelanggaran Kedisiplinan</title>
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
            color: #c0392b;
            margin-bottom: 20px;
            text-align: center;
            border-bottom: 2px solid #eeeeee;
            padding-bottom: 10px;
        }
        .content p {
            font-size: 16px;
        }
        .content strong {
            color: #555555;
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
        <h1 class="header">Peringatan Pelanggaran Kedisiplinan</h1>
        <div class="content">
            <p>
                Halo, <strong>{{ $lateArrival->nama_siswa }}</strong>,
            </p>
            <p>
                Sistem mencatat adanya pelanggaran kedisiplinan (keterlambatan) atas nama Anda dengan rincian sebagai berikut:
            </p>

            <table class="details-table">
                <tr>
                    <td>Tanggal</td>
                    <td>{{ \Carbon\Carbon::parse($lateArrival->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
                </tr>
                <tr>
                    <td>Waktu Datang</td>
                    <td>{{ $lateArrival->waktu_datang }}</td>
                </tr>
                <tr>
                    <td>Dicatat oleh</td>
                    <td>{{ $lateArrival->guru_piket }}</td>
                </tr>
            </table>

            <p style="margin-top: 20px;">
                Mohon untuk lebih memperhatikan kedisiplinan di waktu yang akan datang.
            </p>
        </div>
        <div class="footer">
            <p>Ini adalah email yang dikirim secara otomatis oleh SIMAN. Mohon untuk tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>