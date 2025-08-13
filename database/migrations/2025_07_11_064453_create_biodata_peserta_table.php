<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('biodata_peserta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nim_nis');
            $table->string('jurusan');
            $table->string('no_wa');
            $table->string('foto');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('biodata_peserta');
    }
};