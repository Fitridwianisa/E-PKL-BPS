<?php

namespace App\Imports;

use App\Models\BiodataPeserta;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BiodataPesertaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new BiodataPeserta([
            'user_id' => $row['user_id'],
            'nim_nis' => $row['nim_nis'],
            'jurusan' => $row['jurusan'],
            'no_wa'   => $row['no_wa'],
            'foto'    => $row['foto'] ?? 'default.png',
            'instansi'   => $row['instansi'],
        ]);
    }
}
