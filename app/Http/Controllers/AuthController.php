<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Tampilkan form register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|min:5|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'nama.required' => 'Nama tidak boleh kosong.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'peserta'
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|min:5',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            // Cek role user setelah berhasil login
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->role === 'peserta') {
                return redirect()->intended('/pendaftar/dashboard');
            } else {
                // Role tidak dikenal
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Role tidak dikenali.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function Profile()
    {
        $profil = auth()->user(); // Ambil data user yang sedang login
        return view('profile.index', compact('profil')); // Kirim ke view
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed'
        ]);

        // Update email (username)
        $user->email = $request->email;

        // Kalau password diisi, update password juga
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

        // Tampilkan semua pengguna
    public function index()
    {
        $pengguna = User::all();
        return view('admin.pengguna', compact('pengguna'));
    }

    // Simpan pengguna baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,peserta'
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect()->route('admin.pengguna')->with('success', 'Pengguna berhasil ditambahkan.');
    }
}