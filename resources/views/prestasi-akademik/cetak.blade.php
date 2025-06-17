<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keputusan - Peserta Didik Berprestasi</title>
    <style>
        /* Mengatur dasar halaman */
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        /* Pengaturan tipografi umum */
        h2, h3, h4 {
            text-align: center;
            margin: 0;
            padding: 0;
            text-transform: uppercase;
        }

        h2 {
            font-size: 14pt;
        }

        h3 {
            font-size: 12pt;
        }

        hr {
            border: 0;
            border-top: 2px solid black;
            margin: 10px 0;
        }

        .text-center {
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }
        
        /* Layout untuk bagian menimbang, mengingat, dll. */
        .consideration-section {
            display: flex;
            margin-bottom: 10px;
        }

        .consideration-section .label {
            flex: 0 0 150px; /* Lebar tetap untuk label */
            vertical-align: top;
        }

        .consideration-section .colon {
            flex: 0 0 10px;
            vertical-align: top;
        }

        .consideration-section .content {
            flex: 1;
            vertical-align: top;
            text-align: justify;
        }

        .content ol {
            margin: 0;
            padding-left: 20px;
        }

        /* Bagian tanda tangan */
        .signature-section {
            width: 40%;
            margin-left: 60%;
            margin-top: 40px;
        }

        .signature-space {
            height: 80px;
        }

        .underlined {
            text-decoration: underline;
        }

        /* Lampiran dan Tabel */
        .attachment-header {
            font-size: 11pt;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 11pt;
        }

        .report-table th, .report-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .report-table th {
            text-align: center;
            background-color: #f2f2f2;
        }

        .report-table .col-center {
            text-align: center;
        }
        
        .report-table .col-right {
            text-align: right;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

<div class="page">
    <div class="text-center">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents($imagePath)) }}" alt="Logo Kemenag" height="70">
        <h2>KEPUTUSAN KEPALA MADRASAH ALIYAH NEGERI 3 <br> HULU SUNGAI UTARA</h2>
        <h4>Nomor : {{ $nomor_surat }}</h4>
    </div>
    <br>
    <div class="text-center">
        <h4 class="text-bold">TENTANG</h4>
        <h4 class="text-bold">PESERTA DIDIK BERPRESTASI AKADEMIK KELAS X, XI dan XII</h4>
        <h4 class="text-bold">MAN 3 HULU SUNGAI UTARA</h4>
        <h4 class="text-bold">TAHUN PELAJARAN {{ $academic_period->tahun_ajaran }}</h4>
    </div>
    <hr>
    
    <div class="text-center">
        <h4>DENGAN RAHMAT TUHAN YANG MAHA ESA</h4>
        <h4>KEPALA MADRASAH ALIYAH NEGERI 3 HULU SUNGAI UTARA,</h4>
    </div>
    <br>

    <div class="consideration-section">
        <div class="label">MENIMBANG :</div>
        <div class="content">
            <ol>
                <li>Bahwa untuk memberikan motivasi dan penghargaan kepada peserta didik agar terus terpacu untuk meraih prestasi baik di bidang akademik maupun non akademik perlu adanya reward yang berprestasi dibidang akademik.</li>
                <li>Bahwa perihal tersebut pada dictum pertama, maka bagi peserta didik yang berhasil meraih prestasi dibidang akademik dan non akademik perlu dibuatkan surat keputusan.</li>
            </ol>
        </div>
    </div>
    
    <div class="consideration-section">
        <div class="label">MENGINGAT :</div>
        <div class="content">
            <ol>
                <li>Undang-undang Nomor 20 Tahun 2003 tentang Sistem Pendidikan Nasional.</li>
                <li>Peraturan Pemerintah Nomor 55 Tahun 2007 tentang Pendidikan Agama dan Pendidikan Keagamaan.</li>
                <li>Keputusan Menteri Agama Nomor 347 Tahun 2022 tentang Pedoman Implementasi Kurikulum Merdeka pada Madrasah.</li>
                <li>Permendikbud No. 23 Tahun 2016 tentang Standar Penilaian.</li>
                <li>Permendikbud No. 4. Tahun 2018 tentang Penilaian Hasil Belajar.</li>
                <li>Keputusan Direktur Jenderal Pendidikan Islam Nomor 3751 Tahun 2018 tentang Penilaian Hasil Belajar pada Madrasah Aliyah.</li>
                <li>Hasil belajar peserta didik pada semester {{ $academic_period->semester }} tahun pelajaran {{ $academic_period->tahun_ajaran }}.</li>
            </ol>
        </div>
    </div>

    <div class="consideration-section">
        <div class="label">MEMPERHATIKAN :</div>
        <div class="content">
             Hasil keputusan Rapat Koordinasi Tenaga Pendidik dan Kependidikan Madrasah Aliyah Negeri 3 Hulu Sungai Utara hari {{ $tanggal_rapat }} tentang Penetapan Peserta Didik Berprestasi Akademik Tahun Pelajaran {{ $academic_period->tahun_ajaran }}.
        </div>
    </div>
    <br>

    <div class="page-break"></div>

    <div class="text-center">
        <h4 class="text-bold">MEMUTUSKAN</h4>
    </div>

    <div class="consideration-section">
        <div class="label">MENETAPKAN :</div>
        <div class="content text-bold text-center">
             KEPUTUSAN KEPALA MADRASAH ALIYAH NEGERI 3 HULU SUNGAI UTARA TENTANG PESERTA DIDIK BERPRESTASI BIDANG AKADEMIK KELAS X, XI, dan XII MAN 3 HULU SUNGAI UTARA SEMESTER {{ $academic_period->semester }} TAHUN PELAJARAN {{ $academic_period->tahun_ajaran }}.
        </div>
    </div>

    <div class="consideration-section">
        <div class="label">Pertama :</div>
        <div class="content">
            Nama-nama yang terlampir dalam surat keputusan ini dinyatakan sebagai peserta didik berprestasi di bidang akademik pada MAN 3 Hulu Sungai Utara Semester {{ $academic_period->semester }} Pelajaran {{ $academic_period->tahun_ajaran }}.
        </div>
    </div>

     <div class="consideration-section">
        <div class="label">Kedua :</div>
        <div class="content">
            Surat keputusan ini berlaku sejak tanggal ditetapkan dan apabila dikemudian hari terdapat kekeliruan maka akan diadakan perbaikan sebagaimana mestinya.
        </div>
    </div>
    <br>

    <div class="signature-section">
        Ditetapkan di : Amuntai <br>
        Pada tanggal : {{ $tanggal_ditetapkan }} <br>
        Kepala Madrasah,
        <div class="signature-space"></div>
        <div class="text-bold underlined">Dr. Hj. Raudlatul Munawwarah, M.M</div>
        <div>NIP. 196503141992032004</div>
    </div>

    {{-- Page Break untuk Lampiran --}}
    <div class="page-break"></div>

    <div class="attachment-header">
        Lampiran I : Surat Keputusan Kepala MAN 3 Hulu Sungai Utara <br>
        Nomor : {{ $nomor_surat }} <br>
        Tanggal : {{ $tanggal_ditetapkan }} <br>
        Tentang : PESERTA DIDIK BERPRESTASI BIDANG AKADEMIK KELAS X, XI, dan XII MAN 3 HULU SUNGAI UTARA SEMESTER {{ $academic_period->semester }} TAHUN PELAJARAN {{ $academic_period->tahun_ajaran }}
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th width="5%">NISN</th>
                <th>Nama</th>
                <th>Bin/Binti</th>
                <th>Kelas</th>
                <th>Jumlah Nilai</th>
                <th>Nilai Rata-rata</th>
                <th width="5%">Rangking</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prestasi as $item)
            <tr>
                <td class="col-center">{{ $loop->iteration }}</td>
                <td class="col-center">{{ $item->nisn }}</td>
                <td>{{ $item->nama }}</td>
                <td class="col-center">{{ $item->ortu }}</td>
                <td class="col-center">{{ $item->room->tingkat }}-{{ $item->room->rombongan }} @if ($item->room->nama_jurusan)
                    ({{ $item->room->nama_jurusan }})
                @endif</td>
                <td class="col-center">{{ $item->jumlah_nilai }}</td>
                <td class="col-center">{{ $item->rata_rata }}</td>
                <td class="col-center">{{ $item->ranking }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>