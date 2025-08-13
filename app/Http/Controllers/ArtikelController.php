<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;
use App\Models\Artikel;

class ArtikelController extends Controller
{
    public function showArtikel($id)
    {
        // Ambil satu artikel berdasarkan ID
        $artikelUtama = Artikel::findOrFail($id);

        // Ambil semua artikel untuk ditampilkan di daftar samping
        $artikels = Artikel::latest()->get();

        return view('artikel.index', compact('artikelUtama', 'artikels'));
    }


}
