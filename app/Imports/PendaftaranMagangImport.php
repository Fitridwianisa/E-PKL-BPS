<?php

namespace App\Imports;

use App\Models\PendaftaranMagang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PendaftaranMagangImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new PendaftaranMagang([
            'user_id' => $row['user_id'],  // langsung ambil dari Excel
            'surat_pengantar' => $row['surat_pengantar'],
            'proposal' => $row['proposal'],
            'bagian_penempatan' => $row['bagian_penempatan'],
            'jenis_magang' => $row['jenis_magang'],
            'tanggal_mulai' => $row['tanggal_mulai'],
            'tanggal_selesai' => $row['tanggal_selesai'],
            'bersedia_ditempatkan_lain' => strtolower($row['bersedia_ditempatkan_lain']) == 'ya' ? true : false,
            'status' => $row['status'] ?? 'menunggu',
        ]);
    }
}


