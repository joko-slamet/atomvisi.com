<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Str;

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
        $article->save();

        return $article;
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
