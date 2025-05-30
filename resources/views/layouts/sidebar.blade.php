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
            <li class="active">
                <a href="" class="nav-link"><i class="fas fa-fire"></i><span>Dasbor</span></a>
            </li>

            @if (Auth::user()->hasRole('kepala madrasah'))
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="far fa-file-alt"></i> <span>Data Master</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="">Pengguna</a></li>
                    <li><a class="nav-link" href="">Jurusan</a></li>
                    <li><a class="nav-link" href="">Kelas</a></li>
                    <li><a class="nav-link" href="">TP/Semester</a></li>
                </ul>
            </li>
            @endif

        </ul>
    </aside>
</div>
