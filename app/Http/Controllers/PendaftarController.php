<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranMagang;
use App\Models\BiodataPeserta;
use Illuminate\Support\Facades\Auth;

class PendaftarController extends Controller
{
    public function dashboard()
    {
        $pendaftaran = PendaftaranMagang::with('biodata')
            ->where('user_id', Auth::id())
            ->get();

        return view('pendaftar.dashboard', compact('pendaftaran'));
    }


    public function profile()
    {
        return view('pendaftar.profile');
    }

    public function formPendaftaran()
    {
        $biodata = BiodataPeserta::where('user_id', Auth::id())->first();
        return view('pendaftar.form_pendaftaran', compact('biodata'));
    }
    public function create()
    {
        return view('pendaftaran.create');
    }

    public function storeBiodata(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'instansi' => 'required',
            'jurusan' => 'required',
            'nim_nis' => 'required',
            'no_wa' => 'required',
            'foto' => 'nullable|image|max:2048'
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_peserta', 'public');
        }

        BiodataPeserta::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'nama' => $request->nama,
                'instansi' => $request->instansi,
                'jurusan' => $request->jurusan,
                'nim_nis' => $request->nim_nis,
                'no_wa' => $request->no_wa,
                'foto' => $fotoPath
            ]
        );

        return back()->with('success', 'Biodata berhasil disimpan.');
    }

    public function storePendaftaran(Request $request)
    {
        $request->validate([
            'surat_pengantar' => 'required|file|mimes:pdf|max:2048',
            'proposal' => 'required|file|mimes:pdf|max:2048',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'bagian_penempatan' => 'required|in:umum,humas,ipds,statistik_sosial,statistik_distribusi,statistik_produksi,newilis,sakip',
            'jenis_magang' => 'required|in:mandiri,wajib',
        ]);

        $user_id = Auth::id();

        $surat = $request->file('surat_pengantar')->store('surat_pengantar', 'public');
        $proposal = $request->file('proposal')->store('proposal', 'public');

        $pendaftaran = new PendaftaranMagang();
        $pendaftaran->surat_pengantar = $surat;
        $pendaftaran->proposal = $proposal;
        $pendaftaran->tanggal_mulai = $request->tanggal_mulai;
        $pendaftaran->tanggal_selesai = $request->tanggal_selesai;
        $pendaftaran->bagian_penempatan = $request->bagian_penempatan;
        $pendaftaran->jenis_magang = $request->jenis_magang;
        $pendaftaran->bersedia_ditempatkan_lain = $request->has('siap_ditempatkan') ? 1 : 0;
        $pendaftaran->status = 'menunggu';

        $pendaftaran->user_id = $user_id;
        $pendaftaran->save();

        return redirect()->route('pendaftar.dashboard')->with('success', 'Pengajuan berhasil dikirim!');
    }

}