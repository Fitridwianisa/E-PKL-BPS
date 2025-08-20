@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow rounded-4 p-4" style="width: 420px;">
        <h3 class="text-center mb-4">Profil Pengguna</h3>

        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        @if (Auth::check())
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Username / Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                </div>

                <div class="text-center">
                    <button class="btn btn-success me-2">Simpan Perubahan</button>
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                       class="btn btn-danger">Logout</a>
                </div>
            </form>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <div class="alert alert-warning text-center">Anda belum login.</div>
        @endif
    </div>
</div>
@endsection
