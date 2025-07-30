<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pelajaran - {{ $room->tingkat }}-{{ $room->rombongan }} {{ $room->nama_jurusan }}</title>
    <style>
        /* Mengatur dasar halaman - Sesuai style Anda */
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10pt; /* Font dibuat lebih kecil agar tabel muat */
            margin: 0;
            padding: 0;
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
            margin-top: 20px;
            margin-bottom: 15px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14pt;
        }

        /* Tabel Info Kelas & Wali Kelas */
        .info-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 12pt;
        }

        /* Tabel Jadwal Utama */
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
        }

        .schedule-table th, .schedule-table td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
            vertical-align: middle;
        }

        .schedule-table th {
            background-color: #e9ecef;
            font-weight: bold;
        }

        .schedule-table .time-col {
            font-weight: bold;
            width: 12%;
        }

        .schedule-entry {
            font-size: 9pt;
            line-height: 1.2;
        }
        .schedule-entry .subject {
            font-weight: bold;
            display: block;
        }
        .schedule-entry .teacher {
            font-style: italic;
        }

        .general-event {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        
        /* Bagian Tanda Tangan - Sesuai style Anda */
        .signature-section {
            margin-top: 30px;
        }
        
        .signature-section table {
            width: 100%;
        }
        
        .signature-section td {
            width: 33%;
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
        JADWAL PELAJARAN {{ $academic_period_text }}
    </div>
    
    {{-- INFORMASI KELAS & WALI KELAS --}}
    <table class="info-table">
        <tr>
            <td width="15%"><strong>KELAS</strong></td>
            <td width="2%">:</td>
            <td width="58%"><strong>{{ $room->tingkat }}-{{ $room->rombongan }} {{ $room->major->nama_jurusan ?? '' }}</strong></td>
        </tr>
         <tr>
            <td><strong>WALI KELAS</strong></td>
            <td>:</td>
            <td><strong>{{ $room->waliKelas->name ?? 'Belum Ditentukan' }}</strong></td>
        </tr>
    </table>

    {{-- TABEL JADWAL MINGGUAN --}}
    <table class="schedule-table">
        <thead>
            <tr>
                <th class="time-col">Waktu</th>
                @foreach ($days as $day)
                    <th>{{ $day }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($timeSlots as $timeSlot)
                <tr>
                    <td class="time-col">{{ \Carbon\Carbon::parse($timeSlot->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($timeSlot->waktu_selesai)->format('H:i') }}</td>
                    
                    @foreach ($days as $day)
                        <td>
                            {{-- Cek dulu apakah ada Jadwal Umum di slot ini --}}
                            @if(isset($generalSchedules[$day][$timeSlot->id]))
                                <div class="general-event">
                                    {{ $generalSchedules[$day][$timeSlot->id] }}
                                </div>
                            
                            {{-- Jika tidak ada, baru cek Jadwal Pelajaran biasa --}}
                            @elseif(isset($schedules[$day][$timeSlot->id]))
                                @php
                                    $schedule = $schedules[$day][$timeSlot->id]->first();
                                @endphp
                                <div class="schedule-entry">
                                    <span class="subject">{{ $schedule->learning->subject->nama_mapel ?? 'N/A' }}</span>
                                    <span class="teacher">{{ $schedule->learning->user->name ?? 'N/A' }}</span>
                                </div>
                            @else
                                {{-- Jika slot kosong --}}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <div class="signature-section">
        <table>
            <tr>
                <td>
                    Mengetahui,<br>
                    Wakamad Kurikulum
                    <div class="signature-space"></div>
                    <div class="signature-name">{{ $wakamad_kurikulum->name ?? '(..................)' }}</div>
                    <div>NIP. {{ $wakamad_kurikulum->nip ?? '..................' }}</div>
                </td>
                <td style="width: 34%;"></td>
                <td>
                    Amuntai, {{ $tanggal_cetak }}<br>
                    Kepala Madrasah
                    <div class="signature-space"></div>
                    <div class="signature-name">{{ $kepala_madrasah->name ?? '(..................)' }}</div>
                    <div>NIP. {{ $kepala_madrasah->nip ?? '..................' }}</div>
                </td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>
