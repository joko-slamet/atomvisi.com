<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('political_calculator_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('provinsi');
            $table->string('kota');
            $table->string('kecamatan');
            $table->string('target_jabatan');
            $table->unsignedBigInteger('jumlah_penduduk')->nullable();
            $table->unsignedBigInteger('jumlah_pemilih_potensial')->nullable();
            $table->string('kelompok_umur_dominan')->nullable();
            $table->json('langkah_strategis')->nullable();
            $table->json('porsi_komunikasi')->nullable();
            $table->json('roadmap')->nullable();
            $table->string('ai_model')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('political_calculator_submissions');
    }
};
