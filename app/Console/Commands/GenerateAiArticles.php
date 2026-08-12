<?php

namespace App\Console\Commands;

use App\Models\AiArticleSetting;
use App\Services\AiArticleGenerator;
use Illuminate\Console\Command;
use Throwable;

class GenerateAiArticles extends Command
{
    protected $signature = 'articles:generate-ai
        {--topic= : Generate a single article for this topic immediately, ignoring the schedule}
        {--force : Ignore the configured schedule and run now}';

    protected $description = 'Generate one draft article using OpenRouter AI, based on the configured schedule and topics';

    public function handle(AiArticleGenerator $generator): int
    {
        $settings = AiArticleSetting::current();

        if ($topic = $this->option('topic')) {
            return $this->generateOne($generator, $settings, $topic, updateLastRun: false);
        }

        if (! $this->option('force') && ! $settings->isDue()) {
            $this->info('Belum waktunya generate artikel (scheduler nonaktif atau belum jatuh tempo). Gunakan --force untuk memaksa.');

            return self::SUCCESS;
        }

        $topics = $settings->topic_list;

        if (empty($topics)) {
            $this->error('Tidak ada topik yang dikonfigurasi. Tambahkan topik di halaman Pengaturan AI Artikel.');

            return self::FAILURE;
        }

        $topic = collect($topics)->random();

        return $this->generateOne($generator, $settings, $topic, updateLastRun: true);
    }

    protected function generateOne(AiArticleGenerator $generator, AiArticleSetting $settings, string $topic, bool $updateLastRun): int
    {
        try {
            $article = $generator->generate(
                topic: $topic,
                type: $settings->type,
                locale: 'id',
                categoryId: $settings->category_id,
            );

            $this->info("Berhasil: \"{$article->title}\" (draft #{$article->id})");

            if ($updateLastRun) {
                $settings->update(['last_run_at' => now()]);
            }

            return self::SUCCESS;
        } catch (Throwable $e) {
            $this->error("Gagal untuk topik \"{$topic}\": {$e->getMessage()}");

            return self::FAILURE;
        }
    }
}
