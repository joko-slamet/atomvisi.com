<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('political_calculator_submissions', function (Blueprint $table) {
            $table->dropColumn('kecamatan');
            $table->string('kota')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('political_calculator_submissions', function (Blueprint $table) {
            $table->string('kecamatan')->after('kota');
            $table->string('kota')->nullable(false)->change();
        });
    }
};
