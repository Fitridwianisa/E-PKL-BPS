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

    // Hitung jumlah peserta diterima dengan tanggal_selesai tersebut
    $pesertaDiterima = PendaftaranMagang::with(['user', 'biodata'])
        ->where('status', 'diterima')
        ->get();

    $jumlahPeserta = $pesertaDiterima->count();
    $kuotaPenuh = $jumlahPeserta >= 15;

    $lastTanggalSelesai = null;
    if ($jumlahPeserta > 0) {
        $lastTanggalSelesai = $pesertaDiterima->last()->tanggal_selesai;
    }


    return view('landing', compact('artikels', 'pesertaDiterima', 'kuotaPenuh', 'lastTanggalSelesai'));
}

}
