<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_article_settings', function (Blueprint $table) {
            $table->id();
            $table->text('openrouter_api_key')->nullable();
            $table->string('model')->default('openai/gpt-4o-mini');
            $table->boolean('is_scheduler_enabled')->default(false);
            $table->unsignedInteger('frequency_hours')->default(24);
            $table->text('topics')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type')->default('article');
            $table->unsignedTinyInteger('articles_per_run')->default(1);
            $table->timestamp('last_run_at')->nullable();
            $table->timestamps();
        });

        DB::table('ai_article_settings')->insert([
            'model' => 'openai/gpt-4o-mini',
            'is_scheduler_enabled' => false,
            'frequency_hours' => 24,
            'type' => 'article',
            'articles_per_run' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_article_settings');
    }
};
