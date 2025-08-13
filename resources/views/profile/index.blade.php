@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow rounded-4 p-4" style="width: 420px;">
        <h3 class="text-center mb-4">Profil Pengguna</h3>

        @if (Auth::check())
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Email:</strong> {{ Auth::user()->email }}
                </li>
                <li class="list-group-item">
                    <strong>Username:</strong> {{ Auth::user()->nama ?? '-' }}
                </li>
                <li class="list-group-item">
                    <strong>Password:</strong> <em>(disembunyikan)</em>
                </li>
            </ul>

            <div class="mt-4 text-center">
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="btn btn-danger">Logout</a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        @else
            <div class="alert alert-warning text-center">Anda belum login.</div>
        @endif
    </div>
</div>
@endsection
