<nav class="navbar navbar-expand-lg navbar-custom px-2 fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('img/logo-bps.png') }}" alt="Logo BPS" height="32" class="me-2">
            <span class="text-white fw-bold fst-italic">
                BADAN PUSAT STATISTIK<br>
                KABUPATEN KEDIRI
            </span>
        </a>

        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarBPS" aria-controls="navbarBPS" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon text-white"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarBPS">
            <ul class="navbar-nav mb-2 mb-lg-0 align-items-center">

                {{-- Lokasi --}}
                <li class="nav-item mx-2">
                    <a class="nav-link text-white" href="https://www.google.com/maps?q=Badan+Pusat+Statistik+Kabupaten+Kediri" target="_blank" title="Lihat lokasi BPS Kabupaten Kediri">
                        <img src="https://img.icons8.com/ios-filled/24/ffffff/marker.png" alt="Lokasi"/>
                    </a>
                </li>

                {{-- Belum login --}}
                @guest
                    <li>
                        <a href="{{ route('login') }}">
                            <button type="button" class="btn btn-primary">Login</button>
                        </a>
                    </li>
                @endguest

                {{-- Sudah login --}}
                @auth
                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1" style="font-size: 1.5rem;"></i>
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>
