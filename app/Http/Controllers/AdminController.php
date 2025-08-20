<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\PendaftaranMagang;
use App\Models\Artikel;

class AdminController extends Controller
{
    public function dashboard() 
    {
        // Jumlah berdasarkan status
        $belumDikonfirmasi = PendaftaranMagang::where('status', 'menunggu')->count();
        $diterima = PendaftaranMagang::where('status', 'diterima')->count();
        $ditolak = PendaftaranMagang::where('status', 'ditolak')->count();

        // Total peserta untuk pie chart
        $totalPeserta = PendaftaranMagang::count();

        // Statistik per bulan
        $statistikPerBulan = PendaftaranMagang::selectRaw("
            MONTH(tanggal_mulai) as bulan,
            SUM(status = 'diterima') as diterima,
            SUM(status = 'ditolak') as ditolak
        ")
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

        return view('admin.dashboard', compact(
            'belumDikonfirmasi',
            'diterima',
            'ditolak',
            'totalPeserta',
            'statistikPerBulan'
        ));
    }

    public function showPendaftaran($id)
    {
        $pendaftaran = PendaftaranMagang::with(['user.biodata'])->findOrFail($id);

        return view('admin.pendaftaran_detail', compact('pendaftaran'));
    }

    public function konfirmasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak'
        ]);

        $pendaftaran = PendaftaranMagang::findOrFail($id);
        $pendaftaran->status = $request->status;
        $pendaftaran->save();

        $message = $request->status === 'diterima' 
        ? 'Pendaftaran berhasil diterima.'
        : 'Pendaftaran telah ditolak.';

        return back()->with('success', $message);
    }

    public function pendaftaran(Request $request)
    {
        $query = PendaftaranMagang::with(['user', 'biodata'])
                    ->orderBy('created_at', 'asc'); // Tanggal terlama

        // Tambahkan pencarian jika ada
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($q2) use ($search) {
                    $q2->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('biodata', function($q2) use ($search) {
                    $q2->where('instansi', 'like', "%{$search}%");
                });
            });
        }

        $pendaftarans = $query->paginate(10)->withQueryString();

        return view('admin.pendaftaran', compact('pendaftarans'));
    }


    public function peserta(Request $request)
    {
        $query = PendaftaranMagang::with(['user', 'biodata'])
            ->where('status', 'diterima'); // Hanya yang diterima

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($q2) use ($search) {
                    $q2->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('biodata', function($q2) use ($search) {
                    $q2->where('instansi', 'like', "%{$search}%");
                });
            });
        }

        $pendaftarans = $query->orderBy('created_at', 'asc')
                            ->paginate(10)
                            ->withQueryString();

        $totalDiterima = PendaftaranMagang::where('status', 'diterima')->count();

        return view('admin.peserta', compact('pendaftarans', 'totalDiterima'));
    }


    public function showPeserta($id)
    {
        $pendaftaran = PendaftaranMagang::findOrFail($id);

        // Ambil data user yang terkait
        $user = User::findOrFail($pendaftaran->user_id);

        return view('admin.upload_sertifikat', compact('user'));
    }


    public function artikel()
    {
        $artikels = Artikel::latest()->get();
        return view('admin.artikel', compact('artikels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('artikel', 'public');
        }

        Artikel::create($validated);

        return redirect()->back()->with('success', 'Artikel berhasil diunggah.');
    }

    public function edit($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('admin.edit-artikel', compact('artikel')); // pastikan nama view sesuai
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $artikel = Artikel::findOrFail($id);
        $artikel->judul = $request->judul;
        $artikel->konten = $request->konten;

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('artikels', 'public');
            $artikel->gambar = $path;
        }

        $artikel->save();

        return redirect()->route('admin.artikel')->with('success', 'Artikel berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);
        if ($artikel->gambar) {
            Storage::disk('public')->delete($artikel->gambar);
        }
        $artikel->delete();
        return redirect()->back()->with('success', 'Artikel berhasil dihapus.');
    }


}
