<!DOCTYPE html>
<html>
<head>
    <title>Pembaruan Nilai Ekstrakurikuler</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 90%; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .header { font-size: 24px; color: #444; margin-bottom: 20px; }
        .content { font-size: 16px; }
        .footer { margin-top: 20px; font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="header">Notifikasi Nilai Ekstrakurikuler</h1>
        <div class="content">
            <p>Halo, <strong>{{ $user->name }}</strong>,</p>
            <p>
                Pembina telah memperbarui nilai Anda untuk kegiatan ekstrakurikuler
                <strong>{{ $extracurricular->nama_ekskul }}</strong>.
            </p>
            <p>
                Nilai baru Anda adalah: <h2>{{ $grade }}</h2>
            </p>
            <p>
                Terima kasih atas partisipasi aktif Anda.
            </p>
        </div>
        <div class="footer">
            <p>Ini adalah email otomatis. Mohon untuk tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>