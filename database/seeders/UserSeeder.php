<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;

class UserSeeder extends Seeder
{
    public function run(): void
    {
     
        $path = database_path('seeders/data/users.xlsx');

        Excel::import(new UsersImport, $path);
    }
}
