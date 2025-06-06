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

        </ul>
    </aside>
</div>
