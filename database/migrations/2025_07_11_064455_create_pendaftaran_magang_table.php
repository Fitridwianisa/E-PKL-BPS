<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pendaftaran_magang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_instansi');
            $table->string('surat_pengantar');
            $table->string('proposal');
            $table->string('bagian_penempatan')->nullable();
            $table->enum('jenis_magang', ['mandiri', 'wajib']);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->boolean('bersedia_ditempatkan_lain')->default(false);
            $table->enum('status', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pendaftaran_magang');
    }
};