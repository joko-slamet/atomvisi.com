<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class OpenRouterService
{
    protected const ENDPOINT = 'https://openrouter.ai/api/v1/chat/completions';

    /**
     * Generate structured article content (title, excerpt, content) for a given topic.
     *
     * @return array{title: string, excerpt: string, content: string}
     */
    public function generateArticle(string $topic, string $type = 'article', string $locale = 'id'): array
    {
        $apiKey = config('services.openrouter.key');

        if (blank($apiKey)) {
            throw new RuntimeException('OpenRouter API key belum diatur. Set OPENROUTER_API_KEY di file .env.');
        }

        $language = $locale === 'en' ? 'English' : 'Indonesian';
        $typeLabel = match ($type) {
            'op-ed' => 'opinion/op-ed piece',
            'newsletter' => 'newsletter update',
            default => 'research/news article',
        };

        $systemPrompt = <<<PROMPT
            You are an expert writer for Atom Visi Indonesia, an independent research institute focused on public policy research, political & geopolitical analysis, social surveys, and strategic consulting.

            Write a well-structured {$typeLabel} in {$language} about the given topic. Respond ONLY with a single JSON object (no markdown fences, no commentary) with exactly these keys:
            - "title": a compelling, concise headline (max 100 characters)
            - "excerpt": a 1-2 sentence summary (max 300 characters)
            - "content": the full article body as clean HTML using only <p>, <h2>, <h3>, <ul>, <li>, <strong>, <em> tags. Aim for 400-700 words. Do not include the title inside the content.
            PROMPT;

        $response = Http::withToken($apiKey)
            ->withHeaders([
                'HTTP-Referer' => config('app.url'),
                'X-Title' => config('app.name'),
            ])
            ->timeout(120)
            ->post(self::ENDPOINT, [
                'model' => config('services.openrouter.model', 'openai/gpt-4o-mini'),
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => "Topic: {$topic}"],
                ],
                'response_format' => ['type' => 'json_object'],
                'temperature' => 0.7,
            ]);

        if ($response->failed()) {
            throw new RuntimeException(
                'Gagal menghubungi OpenRouter: '.($response->json('error.message') ?? $response->status())
            );
        }

        $raw = (string) $response->json('choices.0.message.content');

        return $this->parseArticleJson($raw);
    }

    /**
     * @return array{title: string, excerpt: string, content: string}
     */
    protected function parseArticleJson(string $raw): array
    {
        $cleaned = trim($raw);
        $cleaned = preg_replace('/^```(?:json)?|```$/m', '', $cleaned);
        $cleaned = trim((string) $cleaned);

        $data = json_decode($cleaned, true);

        if (! is_array($data) || ! isset($data['title'], $data['content'])) {
            throw new RuntimeException('Respons AI tidak sesuai format yang diharapkan. Coba lagi.');
        }

        return [
            'title' => (string) $data['title'],
            'excerpt' => (string) ($data['excerpt'] ?? ''),
            'content' => (string) $data['content'],
        ];
    }
}
