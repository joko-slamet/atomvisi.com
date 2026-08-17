<?php

namespace App\Console\Commands;

use App\Models\AiArticleSetting;
use App\Models\Category;
use App\Services\AiArticleGenerator;
use Illuminate\Console\Command;
use Throwable;

class GenerateAiArticles extends Command
{
    protected $signature = 'articles:generate-ai
        {--prompt= : Generate a single article for this prompt immediately, ignoring the schedule}
        {--force : Ignore the configured schedule and run now}';

    protected $description = 'Generate and publish one article using OpenRouter AI, based on the configured schedule and a randomly picked article category';

    public function handle(AiArticleGenerator $generator): int
    {
        $settings = AiArticleSetting::current();

        if ($prompt = $this->option('prompt')) {
            return $this->generateOne($generator, $settings, $prompt, null, updateLastRun: false);
        }

        if (! $this->option('force') && ! $settings->isDue()) {
            $this->info('Belum waktunya generate artikel (scheduler nonaktif atau belum jatuh tempo). Gunakan --force untuk memaksa.');

            return self::SUCCESS;
        }

        $category = Category::query()->where('type', 'article')->inRandomOrder()->first();

        if (! $category) {
            $this->error('Tidak ada kategori bertipe Artikel yang tersedia. Tambahkan kategori terlebih dahulu.');

            return self::FAILURE;
        }

        $prompt = str_replace('{kategori}', $category->name, $settings->promptOrDefault());

        return $this->generateOne($generator, $settings, $prompt, $category->id, updateLastRun: true);
    }

    protected function generateOne(AiArticleGenerator $generator, AiArticleSetting $settings, string $prompt, ?int $categoryId, bool $updateLastRun): int
    {
        try {
            $article = $generator->generate(
                prompt: $prompt,
                type: $settings->type,
                locale: 'id',
                categoryId: $categoryId,
            );

            $this->info("Berhasil: \"{$article->title}\" (dipublikasikan #{$article->id})");

            if ($updateLastRun) {
                $settings->update(['last_run_at' => now()]);
            }

            return self::SUCCESS;
        } catch (Throwable $e) {
            $this->error("Gagal untuk prompt \"{$prompt}\": {$e->getMessage()}");

            return self::FAILURE;
        }
    }
}
