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
            'user_id' => 'required|exists:users,id',
            'file' => 'required|mimes:pdf|max:2048'
        ]);

        $path = $request->file('file')->store('surat_balasan', 'public');

        // Cek apakah sudah ada surat balasan untuk user ini
        $existing = SuratBalasan::where('user_id', $request->user_id)->first();
        if ($existing) {
            // Hapus file lama kalau ada
            if (\Storage::disk('public')->exists($existing->file)) {
                \Storage::disk('public')->delete($existing->file);
            }
            // Update data lama
            $existing->update([
                'file' => $path
            ]);
        } else {
            // Buat baru kalau belum ada
            SuratBalasan::create([
                'user_id' => $request->user_id,
                'file' => $path
            ]);
        }

        return back()->with('success', 'Surat balasan berhasil diunggah.');
    }


}
