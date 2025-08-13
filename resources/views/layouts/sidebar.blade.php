{{-- Bungkus semua dalam satu container column --}}
<div class="bg-light border-bottom px-3 py-2">
    {{-- Tombol Menu --}}
    <div>
        <button class="btn btn-outline-secondary d-flex align-items-center" type="button" id="menuToggle">
            <i class="bi bi-list me-2"></i>
            <strong>Menu</strong>
        </button>
    </div>

    {{-- Submenu --}}
    <div id="menuContent" class="px-2 pt-2" style="display: none;">
        <ul class="nav flex-column">
            @if(Auth::user() && Auth::user()->role == 'admin')
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark p-0" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark p-0" href="{{ route('admin.pendaftaran') }}">Kelola Pendaftaran</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark p-0" href="{{ route('admin.artikel') }}">Kelola Artikel</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark p-0" href="{{ route('admin.peserta') }}">Kelola Peserta</a>
                </li>
                <li class="nav-item mb-2">
                    <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?');">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-dark p-0" style="text-decoration: none;">Logout</button>
                    </form>
                </li>
            @elseif(Auth::user() && Auth::user()->role == 'peserta')
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark p-0" href="{{ route('pendaftar.dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark p-0" href="{{ route('pendaftar.form_pendaftaran') }}">Pendaftaran</a>
                </li>
                    <li class="nav-item mb-2">
                    <a class="nav-link text-dark p-0" href="{{ route('pendaftar.sertifikat') }}">sertifikat</a>
                </li>
                <li class="nav-item mb-2">
                    <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?');">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-dark p-0" style="text-decoration: none;">Logout</button>
                    </form>
                </li>
            @endif
        </ul>
    </div>
</div>

{{-- Script Toggle + localStorage --}}
<script>
    const toggleBtn = document.getElementById('menuToggle');
    const menu = document.getElementById('menuContent');

    // Atur dari localStorage jika sebelumnya terbuka
    const isOpen = localStorage.getItem('menuOpen') === 'true';
    menu.style.display = isOpen ? 'block' : 'none';

    toggleBtn.addEventListener('click', () => {
        const isCurrentlyOpen = menu.style.display === 'block';
        menu.style.display = isCurrentlyOpen ? 'none' : 'block';
        localStorage.setItem('menuOpen', !isCurrentlyOpen);
    });
</script>
