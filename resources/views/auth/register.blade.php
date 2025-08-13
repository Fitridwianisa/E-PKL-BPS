<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow rounded-4 p-4" style="width: 420px;">
        <img src="{{ asset('img/logo-bps.png') }}" alt="Logo BPS" 
            style="width: 100px; height: auto;" 
            class="mx-auto d-block mb-3">
        <h3 class="text-center mb-4">Registrasi Pengguna</h3>

        {{-- Menampilkan pesan sukses --}}
        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Nama Lengkap --}}
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" id="nama"
                    class="form-control @error('nama') is-invalid @enderror"
                    value="{{ old('nama') }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Username / Email --}}
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

            {{-- Konfirmasi Password --}}
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Daftar</button>

            <div class="text-center mt-3">
                Sudah punya akun? <a href="{{ route('login') }}">Login</a>
            </div>
        </form>
    </div>
</div>
