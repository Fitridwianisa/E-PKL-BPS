<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .navbar-custom {
            background-color: #002B6B;
        }
    </style>
</head>
    <body>

    {{-- Header --}}
    @include('layouts.header')

    <div class="d-flex">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('scripts') {{-- untuk menampilkan script tambahan dari halaman --}}

    @stack('scripts')
    </body>
</html>
