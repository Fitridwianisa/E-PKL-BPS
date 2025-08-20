<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PendaftaranMagangImport;

class PendaftaranMagangSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/pendaftaran.xlsx');
        Excel::import(new PendaftaranMagangImport, $path);
    }
}
