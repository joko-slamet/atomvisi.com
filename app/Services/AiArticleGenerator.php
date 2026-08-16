<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class AiArticleGenerator
{
    public function __construct(protected OpenRouterService $openRouter) {}

    public function generate(string $topic, string $type = 'article', string $locale = 'id', ?int $categoryId = null): Article
    {
        $generated = $this->openRouter->generateArticle($topic, $type, $locale);

        $article = new Article([
            'type' => $type,
            'category_id' => $categoryId,
            'status' => 'draft',
        ]);

        $article->setTranslation('title', $locale, $generated['title']);
        $article->setTranslation('excerpt', $locale, $generated['excerpt']);
        $article->setTranslation('content', $locale, $generated['content']);

        $article->slug = $this->uniqueSlug($generated['title']);
        $article->featured_image = $this->tryGenerateCoverImage($generated['title'], $topic);
        $article->save();

        return $article;
    }

    /**
     * Cover image generation is best-effort: a failure here (rate limit, moderation
     * refusal, etc.) shouldn't prevent the article draft itself from being saved.
     */
    protected function tryGenerateCoverImage(string $title, string $topic): ?string
    {
        try {
            return $this->openRouter->generateArticleCoverImage($title, $topic);
        } catch (Throwable $e) {
            Log::warning('Gagal generate gambar cover artikel AI: '.$e->getMessage());

            return null;
        }
    }

    protected function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'artikel';
        $slug = $base;
        $suffix = 2;

        while (Article::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }
}
