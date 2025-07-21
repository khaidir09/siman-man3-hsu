<!DOCTYPE html>
<html>
<head>
    <title>Notifikasi Bimbingan Konseling</title>
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