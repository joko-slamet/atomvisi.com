<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ai_article_settings', function (Blueprint $table) {
            $table->json('run_times')->nullable()->after('is_scheduler_enabled');
            $table->dropColumn(['frequency_hours', 'articles_per_run']);
        });
    }

    public function down(): void
    {
        Schema::table('ai_article_settings', function (Blueprint $table) {
            $table->unsignedInteger('frequency_hours')->default(24);
            $table->unsignedTinyInteger('articles_per_run')->default(1);
            $table->dropColumn('run_times');
        });
    }
};
