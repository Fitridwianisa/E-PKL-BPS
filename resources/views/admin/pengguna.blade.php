@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="container">
    <h4 class="fw-bold mb-4">Kelola Pengguna</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form tambah pengguna --}}
    <div class="card mb-4">
        <div class="card-header">Tambah Pengguna Baru</div>
        <div class="card-body">
            <form action="{{ route('admin.pengguna.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}">
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Role</label>
                    <select name="role" class="form-select">
                        <option value="">-- Pilih Role --</option>
                        <option value="admin">Admin</option>
                        <option value="peserta">Peserta</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>

    {{-- Tabel pengguna --}}
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengguna as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->nama }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada pengguna</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
