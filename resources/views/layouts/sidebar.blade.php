<div class="bg-light border-bottom px-3 py-2">
    <div class="px-2 pt-2">
        <ul class="nav flex-column">
            @if(Auth::user() && Auth::user()->role == 'admin')
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex align-items-center p-2 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2 me-2"></i>
                        <span>Dashboard Admin</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex align-items-center p-2 {{ request()->routeIs('admin.pendaftaran') ? 'active' : '' }}" href="{{ route('admin.pendaftaran') }}">
                        <i class="bi bi-journal-text me-2"></i>
                        <span>Kelola Pendaftaran</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex align-items-center p-2 {{ request()->routeIs('admin.artikel') ? 'active' : '' }}" href="{{ route('admin.artikel') }}">
                        <i class="bi bi-newspaper me-2"></i>
                        <span>Kelola Artikel</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex align-items-center p-2 {{ request()->routeIs('admin.peserta') ? 'active' : '' }}" href="{{ route('admin.peserta') }}">
                        <i class="bi bi-people me-2"></i>
                        <span>Kelola Peserta</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex align-items-center p-2 {{ request()->routeIs('admin.pengguna') ? 'active' : '' }}" href="{{ route('admin.pengguna') }}">
                        <i class="bi bi-person-badge me-2"></i>
                        <span>Kelola Pengguna</span>
                    </a>
                </li>
            @elseif(Auth::user() && Auth::user()->role == 'peserta')
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex align-items-center p-2 {{ request()->routeIs('pendaftar.dashboard') ? 'active' : '' }}" href="{{ route('pendaftar.dashboard') }}">
                        <i class="bi bi-speedometer2 me-2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex align-items-center p-2 {{ request()->routeIs('pendaftar.form_pendaftaran') ? 'active' : '' }}" href="{{ route('pendaftar.form_pendaftaran') }}">
                        <i class="bi bi-journal-plus me-2"></i>
                        <span>Pendaftaran</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex align-items-center p-2 {{ request()->routeIs('pendaftar.sertifikat') ? 'active' : '' }}" href="{{ route('pendaftar.sertifikat') }}">
                        <i class="bi bi-award me-2"></i>
                        <span>Sertifikat</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
