<?php

use App\Models\AiArticleSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ai_article_settings', function (Blueprint $table) {
            $table->text('prompt')->nullable()->after('is_scheduler_enabled');
        });

        AiArticleSetting::query()->update(['prompt' => AiArticleSetting::DEFAULT_PROMPT]);

        Schema::table('ai_article_settings', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['topics', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::table('ai_article_settings', function (Blueprint $table) {
            $table->text('topics')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->dropColumn('prompt');
        });
    }
};
