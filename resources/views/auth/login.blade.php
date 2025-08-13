<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Pengguna</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow rounded-4 p-4" style="width: 420px;">
        <img src="{{ asset('img/logo-bps.png') }}" alt="Logo BPS" 
            style="width: 100px; height: auto;" 
            class="mx-auto d-block mb-3">

        <h3 class="text-center mb-4">Login Pengguna</h3>

        {{-- Notifikasi sukses --}}
        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        {{-- Error login --}}
        @if($errors->any())
            <div class="alert alert-danger text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Username (Email)</label>
                <input type="email" name="email" id="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password"
                       class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tombol login --}}
            <button type="submit" class="btn btn-primary w-100">Login</button>

            <div class="text-center mt-3">
                Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
