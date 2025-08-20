<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BiodataPesertaImport;

class BiodataPeserta extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/biodata.xlsx');
        Excel::import(new BiodataPesertaImport, $path);
    }
}
