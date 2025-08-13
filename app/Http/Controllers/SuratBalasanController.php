<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratBalasan;
use App\Models\PendaftaranMagang;

class SuratBalasanController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id', // perbaiki validasi exists
            'file' => 'required|mimes:pdf|max:2048'
        ]);

        $path = $request->file('file')->store('surat_balasan', 'public');

        SuratBalasan::create([
            'user_id' => $request->user_id,
            'file' => $path
        ]);

        return back()->with('success', 'Surat balasan berhasil diunggah.');
    }

}
