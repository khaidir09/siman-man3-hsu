<nav class="navbar navbar-expand-lg main-navbar">
    <ul class="navbar-nav">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
    <ul class="navbar-nav navbar-right ml-auto">

        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                {{-- @if (auth()->guard('admin')->user()->image)
                    <img alt="image" src="{{ asset(auth()->guard('admin')->user()->image) }}"
                        class="rounded-circle mr-1">
                @else
                    <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                @endif
                <div class="d-sm-none d-lg-inline-block">{{ __('admin.Hi') }}, {{ auth()->guard('admin')->user()->name }}</div> --}}
                <img alt="image" src="{{ asset('images/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">{{ Auth::user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">

                <a href="" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profil
                </a>
                <div class="dropdown-divider"></div>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a href="#" onclick="event.preventDefault();
                    this.closest('form').submit();" class="dropdown-item has-icon text-danger">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </a>
                </form>
            </div>
        </li>
    </ul>
</nav>
