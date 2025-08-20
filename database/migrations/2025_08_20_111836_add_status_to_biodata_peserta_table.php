<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('biodata_peserta', function (Blueprint $table) {
            $table->enum('status', ['siswa', 'mahasiswa'])
                  ->after('foto')
                  ->default('mahasiswa'); // bisa diubah default sesuai kebutuhan
        });
    }

    public function down(): void {
        Schema::table('biodata_peserta', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
