<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('political_calculator_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_enabled')->default(true);
            $table->string('model')->nullable();
            $table->unsignedSmallInteger('max_submissions_per_ip_per_day')->default(5);
            $table->timestamps();
        });

        DB::table('political_calculator_settings')->insert([
            'is_enabled' => true,
            'max_submissions_per_ip_per_day' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('political_calculator_settings');
    }
};
