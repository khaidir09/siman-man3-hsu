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
                <a href="#" class="nav-link has-dropdown"><i class="far fa-file-alt"></i> <span>Data Master</span></a>
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
                <a href="{{ route('prestasi-akademik.index') }}" class="nav-link"><i class="fas fa-fire"></i><span>Prestasi Akademik</span></a>
            </li>

            <li class="{{ Route::is('terlambat*') ? 'active' : '' }}">
                <a href="{{ route('terlambat.index') }}" class="nav-link"><i class="fas fa-fire"></i><span>Pelanggaran Kedisiplinan</span></a>
            </li>

            <li class="{{ Route::is('alumni*') ? 'active' : '' }}">
                <a href="{{ route('alumni.index') }}" class="nav-link"><i class="fas fa-fire"></i><span>Alumni</span></a>
            </li>
            @endif

            @if (Auth::user()->hasRole('wali kelas') || Auth::user()->hasRole('kepala madrasah'))
            <li class="{{ Route::is('kehadiran*') ? 'active' : '' }}">
                <a href="{{ route('kehadiran.index') }}" class="nav-link"><i class="fas fa-fire"></i><span>Kehadiran Siswa</span></a>
            </li>
            @endif

            @if (Auth::user()->hasRole('guru bk') || Auth::user()->hasRole('kepala madrasah'))
            <li class="{{ Route::is('konseling*') ? 'active' : '' }}">
                <a href="{{ route('konseling.index') }}" class="nav-link"><i class="fas fa-fire"></i><span>Bimbingan Konseling</span></a>
            </li>
            @endif

            @if (Auth::user()->hasRole('wakamad sarpras') || Auth::user()->hasRole('kepala madrasah'))
            <li class="{{ Route::is('inventaris*') ? 'active' : '' }}">
                <a href="{{ route('inventaris.index') }}" class="nav-link"><i class="fas fa-fire"></i><span>Inventaris</span></a>
            </li>
            @endif

            @if (Auth::user()->hasRole('uks') || Auth::user()->hasRole('kepala madrasah'))
            <li class="{{ Route::is('kesehatan*') ? 'active' : '' }}">
                <a href="{{ route('kesehatan.index') }}" class="nav-link"><i class="fas fa-fire"></i><span>UKS</span></a>
            </li>
            @endif

            @if (Auth::user()->hasRole('koperasi') || Auth::user()->hasRole('kepala madrasah'))
            <li class="{{ Route::is('unit-usaha*') ? 'active' : '' }}">
                <a href="{{ route('unit-usaha.index') }}" class="nav-link"><i class="fas fa-fire"></i><span>Unit Usaha</span></a>
            </li>
            @endif

            @if (Auth::user()->hasRole('pembina ekskul') || Auth::user()->hasRole('kepala madrasah'))
            <li class="{{ Route::is('ekstrakurikuler*') ? 'active' : '' }}">
                <a href="{{ route('ekstrakurikuler.index') }}" class="nav-link"><i class="fas fa-fire"></i><span>Ekstrakurikuler</span></a>
            </li>
            <li class="{{ Route::is('prestasi-ekskul*') ? 'active' : '' }}">
                <a href="{{ route('prestasi-ekskul.index') }}" class="nav-link"><i class="fas fa-fire"></i><span>Prestasi Ekstrakurikuler</span></a>
            </li>
            <li class="{{ Route::is('siswa*') ? 'active' : '' }}">
                <a href="{{ route('siswa.index') }}" class="nav-link"><i class="fas fa-fire"></i><span>Siswa</span></a>
            </li>
            @endif

            @if (Auth::user()->hasRole('wakamad kurikulum') || Auth::user()->hasRole('kepala madrasah'))
            <li class="{{ Route::is('mapel*') ? 'active' : '' }}">
                <a href="{{ route('mapel.index') }}" class="nav-link"><i class="fas fa-fire"></i><span>Mata Pelajaran</span></a>
            </li>
            <li class="{{ Route::is('waktu-mapel*') ? 'active' : '' }}">
                <a href="{{ route('waktu-mapel.index') }}" class="nav-link"><i class="fas fa-fire"></i><span>Jam Pelajaran</span></a>
            </li>
            <li class="{{ Route::is('jadwal-umum*') ? 'active' : '' }}">
                <a href="{{ route('jadwal-umum.index') }}" class="nav-link"><i class="fas fa-fire"></i><span>Jadwal Umum</span></a>
            </li>
            <li class="{{ Route::is('jadwal*') ? 'active' : '' }}">
                <a href="{{ route('jadwal.index') }}" class="nav-link"><i class="fas fa-fire"></i><span>Jadwal Pelajaran</span></a>
            </li>
            @endif

        </ul>
    </aside>
</div>
