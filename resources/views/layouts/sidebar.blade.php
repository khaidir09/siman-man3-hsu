<div class="navbar-bg"></div>
<!-- Navbar Start -->
@include('layouts.navbar')
<!-- Navbar End -->

<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="">SIMAN MAN3 HSU</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="">SIMAN</a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Route::is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dasbor</span></a>
            </li>

            @if (Auth::user()->hasRole('kepala madrasah'))
            <li class="dropdown {{ Route::is(['pengguna*', 'jurusan*', 'kelas*', 'semester*']) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-key"></i> <span>Data Master</span></a>
                <ul class="dropdown-menu" style="{{ Route::is('pengguna*') ? 'display: block;' : '' }}">
                    <li class="{{ Route::is('pengguna*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('pengguna.index') }}">Pengguna</a></li>
                    <li class="{{ Route::is('jurusan*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('jurusan.index') }}">Jurusan</a></li>
                    <li class="{{ Route::is('kelas*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('kelas.index') }}">Kelas</a></li>
                    <li class="{{ Route::is('semester*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('semester.index') }}">TP/Semester</a></li>
                </ul>
            </li>
            @endif

            @if (Auth::user()->hasRole('wakamad kesiswaan') || Auth::user()->hasRole('kepala madrasah'))
            <li class="{{ Route::is('prestasi-akademik*') ? 'active' : '' }}">
                <a href="{{ route('prestasi-akademik.index') }}" class="nav-link"><i class="fas fa-trophy"></i><span>Prestasi Akademik</span></a>
            </li>
            @endif

            @if (Auth::user()->hasRole('guru') || Auth::user()->hasRole('wakamad kesiswaan') || Auth::user()->hasRole('kepala madrasah'))
            <li class="{{ Route::is('terlambat*') ? 'active' : '' }}">
                <a href="{{ route('terlambat.index') }}" class="nav-link"><i class="fas fa-clock"></i><span>Pelanggaran Kedisiplinan</span></a>
            </li>
            @endif

            @if (Auth::user()->hasRole('tata usaha') || Auth::user()->hasRole('kepala madrasah'))
            <li class="{{ Route::is('alumni*') ? 'active' : '' }}">
                <a href="{{ route('alumni.index') }}" class="nav-link"><i class="fas fa-graduation-cap"></i><span>Alumni</span></a>
            </li>
            @endif

            @if (Auth::user()->hasRole('wali kelas') || Auth::user()->hasRole('kepala madrasah'))
            <li class="{{ Route::is('kehadiran*') ? 'active' : '' }}">
                <a href="{{ route('kehadiran.index') }}" class="nav-link"><i class="fas fa-check"></i><span>Kehadiran Siswa</span></a>
            </li>
            @endif

            @if (Auth::user()->hasRole('guru bk') || Auth::user()->hasRole('kepala madrasah'))
            <li class="{{ Route::is('konseling*') ? 'active' : '' }}">
                <a href="{{ route('konseling.index') }}" class="nav-link"><i class="fas fa-heart"></i><span>Bimbingan Konseling</span></a>
            </li>
            @endif

            @if (Auth::user()->hasRole('wakamad sarpras') || Auth::user()->hasRole('kepala madrasah'))
            <li class="{{ Route::is('inventaris*') ? 'active' : '' }}">
                <a href="{{ route('inventaris.index') }}" class="nav-link"><i class="fas fa-box"></i><span>Inventaris</span></a>
            </li>
            @endif

            @if (Auth::user()->hasRole('uks') || Auth::user()->hasRole('kepala madrasah'))
            <li class="{{ Route::is('kesehatan*') ? 'active' : '' }}">
                <a href="{{ route('kesehatan.index') }}" class="nav-link"><i class="fas fa-stethoscope"></i><span>UKS</span></a>
            </li>
            @endif

            @if (Auth::user()->hasRole('koperasi') || Auth::user()->hasRole('kepala madrasah'))
            <li class="{{ Route::is('unit-usaha*') ? 'active' : '' }}">
                <a href="{{ route('unit-usaha.index') }}" class="nav-link"><i class="fas fa-wallet"></i><span>Koperasi</span></a>
            </li>
            @endif

            @if (Auth::user()->hasRole('pembina ekskul') || Auth::user()->hasRole('kepala madrasah'))
            <li class="dropdown {{ Route::is(['ekstrakurikuler*', 'prestasi-ekskul*', 'siswa*']) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-medal"></i> <span>Data Ekstrakurikuler</span></a>
                <ul class="dropdown-menu" style="{{ Route::is('pengguna*') ? 'display: block;' : '' }}">
                    <li class="{{ Route::is('ekstrakurikuler*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('ekstrakurikuler.index') }}">Ekstrakurikuler</a></li>
                    <li class="{{ Route::is('prestasi-ekskul*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('prestasi-ekskul.index') }}">Prestasi Ekstrakurikuler</a></li>
                </ul>
            </li>
            @endif

            @if (Auth::user()->hasRole('wakamad kurikulum') || Auth::user()->hasRole('kepala madrasah'))
            <li class="dropdown {{ Route::is(['mapel*', 'waktu-mapel*', 'jadwal*', 'jadwal-umum*', 'pembelajaran*']) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-calendar"></i> <span>Data Jadwal</span></a>
                <ul class="dropdown-menu" style="{{ Route::is('pengguna*') ? 'display: block;' : '' }}">
                    <li class="{{ Route::is('mapel*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('mapel.index') }}">Mata Pelajaran</a></li>
                    <li class="{{ Route::is('pembelajaran*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('pembelajaran.index') }}">Pembelajaran</a></li>
                    <li class="{{ Route::is('waktu-mapel*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('waktu-mapel.index') }}">Jam Pelajaran</a></li>
                    <li class="{{ Route::is('jadwal*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('jadwal.index') }}">Jadwal Pelajaran</a></li>
                    <li class="{{ Route::is('jadwal-umum*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('jadwal-umum.index') }}">Jadwal Umum</a></li>
                </ul>
            </li>
            @endif

            @if (Auth::user()->hasRole('siswa'))
            <li class="{{ Route::is('presensi.riwayat') ? 'active' : '' }}">
                <a href="{{ route('presensi.riwayat') }}" class="nav-link"><i class="fas fa-check"></i><span>Riwayat Presensi Saya</span></a>
            </li>
            @endif

            @if (Auth::user()->hasRole('guru') || Auth::user()->hasRole('kepala madrasah') || Auth::user()->hasRole('wakamad kurikulum'))
            <li class="{{ Route::is('ujian*') ? 'active' : '' }}">
                <a href="{{ route('ujian.index') }}" class="nav-link"><i class="fas fa-clock"></i><span>Ujian</span></a>
            </li>
            @endif

            @if (Auth::user()->hasRole('guru') || Auth::user()->hasRole('kepala madrasah') || Auth::user()->hasRole('wakamad kurikulum'))
            <li class="{{ Route::is('mapel-diampu*') ? 'active' : '' }}">
                <a href="{{ route('mapel-diampu') }}" class="nav-link"><i class="fas fa-clock"></i><span>Mata Pelajaran Diampu</span></a>
            </li>
            @endif

            @if (Auth::user()->hasRole('siswa'))
            <li class="{{ Route::is('riwayat-ujian-saya') ? 'active' : '' }}">
                <a href="{{ route('riwayat-ujian-saya') }}" class="nav-link"><i class="fas fa-check"></i><span>Riwayat Ujian Saya</span></a>
            </li>
            @endif

        </ul>
    </aside>
</div>
