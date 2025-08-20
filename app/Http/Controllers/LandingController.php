<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\PendaftaranMagang;

class LandingController extends Controller
{
    /**
     * Tampilkan halaman landing.
     */
public function index()
{
    $artikels = Artikel::latest()->get();

    // Ambil tanggal_selesai terakhir dari peserta yang diterima
    $lastTanggalSelesai = PendaftaranMagang::where('status', 'diterima')
        ->max('tanggal_selesai');

    // Hitung jumlah peserta diterima dengan tanggal_selesai tersebut
    $jumlahPeserta = PendaftaranMagang::where('status', 'diterima')
        ->where('tanggal_selesai', $lastTanggalSelesai)
        ->count();

    // Ambil data peserta diterima (buat ditampilkan di tabel)
    $pesertaDiterima = PendaftaranMagang::with(['user', 'biodata'])
        ->where('status', 'diterima')
        ->where('tanggal_selesai', $lastTanggalSelesai)
        ->get();

    // Cek apakah kuota penuh (>= 15)
    $kuotaPenuh = $jumlahPeserta >= 15;

    return view('landing', compact('artikels', 'pesertaDiterima', 'kuotaPenuh', 'lastTanggalSelesai'));
}

}
