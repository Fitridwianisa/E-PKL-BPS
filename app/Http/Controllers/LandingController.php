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
        $pesertaDiterima = PendaftaranMagang::with(['user', 'biodata'])->where('status', 'diterima')->get();

        return view('landing', compact('artikels', 'pesertaDiterima'));
    }
}