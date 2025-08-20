<!DOCTYPE html> 
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .navbar-custom {
            background-color: #002B6B;
            font-size: 0.9rem; 
            line-height: 1.2; 
            padding-top: 0.25rem;   /* kecilkan atas */
            padding-bottom: 0.25rem;/* kecilkan bawah */
        }

        body {
            padding-top: 80px;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            height: calc(100vh - 80px);
            overflow-y: auto;
            background-color: #f8f9fa;
            transition: width 0.3s;
            position: fixed;
            top: 120px;
            left: 0;
        }

        .sidebar.collapsed {
            width: 60px;
        }

        .sidebar .nav-link span {
            transition: opacity 0.3s;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        /* Main content */
        .main-content {
            margin-left: 250px;
            flex-grow: 1;
            overflow-y: auto;
            height: calc(100vh - 80px);
            padding: 1.5rem;
            transition: margin-left 0.3s;
        }

        /* Toggle button */
        .sidebar-toggle-btn {
            position: fixed;
            top: 90px;
            left: 10px;
            z-index: 1000;
        }

        /* Sidebar hover effect */
        .sidebar .nav-link {
            color: #000; /* default teks hitam */
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar .nav-link:hover {
            background-color: #0d6efd; /* biru bootstrap */
            color: #fff;
        }

        /* Icon ikut berubah warna saat hover */
        .sidebar .nav-link:hover i {
            color: #fff;
        }

        /* Menu aktif (misal halaman saat ini) */
        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: #fff;
        }

        .sidebar .nav-link.active i {
            color: #fff;
        }

        /* Teks tetap hilang saat collapsed */
        .sidebar.collapsed .nav-link span {
            display: none;
        }

    </style>
</head>
<body>

    {{-- Header --}}
    @include('layouts.header')

    {{-- Tombol Toggle Sidebar --}}
    <button class="btn btn-primary sidebar-toggle-btn" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>

    <div class="d-flex">
        {{-- Sidebar --}}
        <div class="sidebar" id="sidebar">
            @include('layouts.sidebar')
        </div>

        {{-- Main Content --}}
        <div class="main-content" id="mainContent">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggleBtn = document.getElementById('sidebarToggle');
        const mainContent = document.getElementById('mainContent');

        // Cek status di localStorage saat halaman load
        if(localStorage.getItem('sidebarCollapsed') === 'true') {
            sidebar.classList.add('collapsed');
            mainContent.style.marginLeft = '60px';
        }

        sidebarToggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            const isCollapsed = sidebar.classList.contains('collapsed');
            mainContent.style.marginLeft = isCollapsed ? '60px' : '250px';
            // Simpan status ke localStorage
            localStorage.setItem('sidebarCollapsed', isCollapsed);
        });
    </script>


    @yield('scripts')
    @stack('scripts')
</body>
</html>
