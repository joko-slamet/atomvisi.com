<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('political_calculator_submissions', function (Blueprint $table) {
            $table->text('ringkasan_analisis')->nullable()->after('kelompok_umur_dominan');
            $table->json('pesan_utama')->nullable()->after('langkah_strategis');
            $table->json('fokus_isu')->nullable()->after('porsi_komunikasi');
        });
    }

    public function down(): void
    {
        Schema::table('political_calculator_submissions', function (Blueprint $table) {
            $table->dropColumn(['ringkasan_analisis', 'pesan_utama', 'fokus_isu']);
        });
    }
};
