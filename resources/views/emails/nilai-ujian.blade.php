<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Informasi Nilai Ujian</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .header { font-size: 24px; color: #28a745; margin-bottom: 20px; text-align: center; }
        .score-box { background-color: #f0f0f0; border-left: 5px solid #28a745; padding: 15px; text-align: center; margin: 20px 0; }
        .score { font-size: 48px; font-weight: bold; color: #333; }
        .details-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .details-table td { padding: 10px; border: 1px solid #eee; }
        .details-table td:first-child { background-color: #f9f9f9; font-weight: bold; width: 150px; }
        .footer { margin-top: 20px; font-size: 12px; color: #777; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="header">Nilai Ujian Telah Dirilis</h1>
        <div class="content">
            {{-- Mengambil nama siswa dari relasi --}}
            <p>Halo, <strong>{{ $examScore->student->nama_lengkap }}</strong>,</p>
            <p>
                Guru telah menginput nilai Anda untuk ujian berikut:
            </p>

            <table class="details-table">
                <tr>
                    <td>Nama Ujian</td>
                    {{-- Mengambil detail ujian dari relasi --}}
                    <td>{{ $examScore->exam->name }}</td>
                </tr>
                <tr>
                    <td>Mata Pelajaran</td>
                    <td>{{ $examScore->exam->subject->nama_mapel }}</td>
                </tr>
            </table>

            <div class="score-box">
                <p style="margin:0; padding:0; font-size: 16px;">Nilai Anda:</p>
                <div class="score">{{ $examScore->score }}</div>
            </div>

            <p>
                Anda dapat melihat rincian lebih lanjut dengan login ke sistem.
            </p>
        </div>
        <div class="footer">
            <p>Email ini dikirim otomatis oleh SIMAN. Mohon tidak membalas.</p>
        </div>
    </div>
</body>
</html>