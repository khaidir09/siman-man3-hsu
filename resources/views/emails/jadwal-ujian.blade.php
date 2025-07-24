<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Informasi Jadwal Ujian Baru</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .header { font-size: 24px; color: #007bff; margin-bottom: 20px; text-align: center; }
        .details-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .details-table td { padding: 10px; border: 1px solid #eee; }
        .details-table td:first-child { background-color: #f9f9f9; font-weight: bold; width: 150px; }
        .footer { margin-top: 20px; font-size: 12px; color: #777; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="header">Informasi Ujian Baru</h1>
        <div class="content">
            <p>
                Halo Siswa/i,
            </p>
            <p>
                Telah ditambahkan jadwal ujian baru untuk kelas Anda. Mohon untuk mempersiapkan diri dengan baik.
            </p>

            <table class="details-table">
                <tr>
                    <td>Nama Ujian</td>
                    <td>{{ $exam->name }}</td>
                </tr>
                <tr>
                    <td>Mata Pelajaran</td>
                    <td>{{ $exam->subject->nama_mapel }}</td>
                </tr>
                 <tr>
                    <td>Kelas</td>
                    <td>{{ $exam->room->tingkat }}-{{ $exam->room->rombongan }} {{ $exam->room->nama_jurusan }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>{{ \Carbon\Carbon::parse($exam->exam_date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
                </tr>
                 <tr>
                    <td>Guru</td>
                    <td>{{ $exam->teacher->name }}</td>
                </tr>
            </table>

            <p style="margin-top: 20px;">
                Tetap semangat dan semoga sukses!
            </p>
        </div>
        <div class="footer">
            <p>Email ini dikirim otomatis oleh SIMAN. Mohon tidak membalas.</p>
        </div>
    </div>
</body>
</html>