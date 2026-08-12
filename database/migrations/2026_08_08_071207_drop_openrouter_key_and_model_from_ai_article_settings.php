<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ai_article_settings', function (Blueprint $table) {
            $table->dropColumn(['openrouter_api_key', 'model']);
        });
    }

    public function down(): void
    {
        Schema::table('ai_article_settings', function (Blueprint $table) {
            $table->text('openrouter_api_key')->nullable();
            $table->string('model')->default('openai/gpt-4o-mini');
        });
    }
};
