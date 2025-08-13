<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PendaftaranMagang;
use App\Models\BiodataPeserta;
use App\Models\Sertifikat;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;


class SertifikatController extends Controller
{
    public function sertifikat()
    {
        $userId = Auth::id();

        // Ambil data pendaftaran dan biodata
        $pendaftaran = PendaftaranMagang::where('user_id', $userId)->first();
        $biodata = BiodataPeserta::where('user_id', $userId)->first();
        $sertifikat = Sertifikat::where('user_id', $userId)->first();

        // Pastikan minimal data ada
        if (!$pendaftaran || !$pendaftaran->tanggal_selesai) {
            return redirect()->back()->with('error', 'Data magang belum lengkap.');
        }

        // Kirim data ke view — tampilannya nanti ditentukan di Blade
        return view('pendaftar.sertifikat', [
            'nama' => $biodata->nama ?? 'N/A',
            'instansi' => $biodata->instansi ?? 'N/A',
            'tanggal_mulai' => $pendaftaran->tanggal_mulai,
            'tanggal_selesai' => $pendaftaran->tanggal_selesai,
            'file_sertifikat' => $sertifikat->file_path ?? null, // Ambil file_path dari tabel sertifikats
        ]);
    }


    public function preview()
    {
        $userId = Auth::id();

        $pendaftaran = PendaftaranMagang::where('user_id', $userId)->first();
        $biodata = BiodataPeserta::where('user_id', $userId)->first();

        if (!$pendaftaran || now()->lt($pendaftaran->tanggal_selesai)) {
            return redirect()->back()->with('error', 'Sertifikat belum tersedia.');
        }

        \Carbon\Carbon::setLocale('id');

        // Cek sertifikat
        $sertifikat = Sertifikat::firstOrCreate(
            ['user_id' => $userId],
            ['nomor_sertifikat' => $this->generateNomorSertifikat()]
        );

        // Kirim semua data ke view, termasuk nomor sertifikat
        $data = [
            'nama' => $biodata->nama,
            'instansi' => $biodata->instansi,
            'tanggal_mulai' => Carbon::parse($pendaftaran->tanggal_mulai)->translatedFormat('d F Y'),
            'tanggal_selesai' => Carbon::parse($pendaftaran->tanggal_selesai)->translatedFormat('d F Y'),
            'nomor_sertifikat' => $sertifikat->nomor_sertifikat, // ⬅️ inilah yang error kalau tidak dikirim
        ];

        $pdf = PDF::loadView('pendaftar.sertifikat-pdf', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('preview-sertifikat.pdf');
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'file_sertifikat' => 'required|mimes:pdf|max:2048'
        ]);

        $user = User::findOrFail($id);

        $path = $request->file('file_sertifikat')->store('sertifikat', 'public');

        // Simpan ke database
        $user->sertifikat()->updateOrCreate([], [
            'nomor_sertifikat' => $this->generateNomorSertifikat(),
            'file_path' => $path
        ]);

        return back()->with('success', 'Sertifikat berhasil diunggah!');
    }
    public function download()
    {
        $userId = Auth::id();

        $pendaftaran = PendaftaranMagang::where('user_id', $userId)->first();
        $biodata = BiodataPeserta::where('user_id', $userId)->first();

        if (!$pendaftaran || now()->lt($pendaftaran->tanggal_selesai)) {
            return redirect()->back()->with('error', 'Sertifikat belum tersedia.');
        }

        // Cek sertifikat
        $sertifikat = Sertifikat::firstOrCreate(
            ['user_id' => $userId],
            ['nomor_sertifikat' => $this->generateNomorSertifikat()]
        );

        $data = [
            'nama' => $biodata->nama,
            'instansi' => $biodata->instansi,
            'tanggal_mulai' => Carbon::parse($pendaftaran->tanggal_mulai)->translatedFormat('d F Y'),
            'tanggal_selesai' => Carbon::parse($pendaftaran->tanggal_selesai)->translatedFormat('d F Y'),
            'nomor_sertifikat' => $sertifikat->nomor_sertifikat,
        ];

        $pdf = PDF::loadView('pendaftar.sertifikat-pdf', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('sertifikat_' . Str::slug($data['nama']) . '.pdf');
    }

    private function generateNomorSertifikat()
    {
        $bulan = now()->format('m');

        // Hitung total sertifikat + 1
        $count = Sertifikat::count() + 1;

        // Format jadi 3 digit (001, 002, dst)
        $noUrut = str_pad($count, 3, '0', STR_PAD_LEFT);

        // Susun format akhir
        return "{$noUrut}/3506/HM.340/{$bulan}/2025";
    }


}
