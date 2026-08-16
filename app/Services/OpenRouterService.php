<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class OpenRouterService
{
    protected const ENDPOINT = 'https://openrouter.ai/api/v1/chat/completions';

    /**
     * Generate a structured political-strategy analysis for a given target region.
     *
     * @return array{
     *   jumlah_penduduk: int,
     *   jumlah_pemilih_potensial: int,
     *   kelompok_umur_dominan: string,
     *   langkah_strategis: array<int, string>,
     *   porsi_komunikasi: array{baliho: int, sosialisasi_kunjungan: int, instagram: int, whatsapp: int},
     *   roadmap: array<int, array{bulan: int, fokus: string, minggu: array<int, array{minggu: int, aktivitas: string}>}>
     * }
     */
    public function generatePoliticalAnalysis(string $province, string $city, string $district, string $target, ?string $model = null): array
    {
        try {
            return $this->requestAnalysis($province, $city, $district, $target, $model);
        } catch (RuntimeException $e) {
            // Structured output from the model can occasionally be malformed; one silent retry
            // is cheap insurance against non-compliance without introducing queue infrastructure.
            return $this->requestAnalysis($province, $city, $district, $target, $model);
        }
    }

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
                'model' => config('services.openrouter.model', 'google/gemini-2.5-flash'),
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
     * Generate a cover image for an article and store it on the "public" disk.
     * Returns the relative path (e.g. "articles/xxxx.png"), matching the format
     * used by the Filament FileUpload field for the "featured_image" column.
     *
     * Uses an image-capable model through OpenRouter's chat completions endpoint
     * (multimodal "modalities" output), rather than a separate images API.
     */
    public function generateArticleCoverImage(string $title, string $topic): string
    {
        $apiKey = config('services.openrouter.key');

        if (blank($apiKey)) {
            throw new RuntimeException('OpenRouter API key belum diatur. Set OPENROUTER_API_KEY di file .env.');
        }

        $prompt = "Professional editorial cover photo for a research/policy article titled \"{$title}\" about \"{$topic}\". Photorealistic photography style — natural lighting, shallow depth of field, corporate/editorial photography. NOT an illustration, NOT a 3D render, NOT a cartoon or flat vector graphic. No text or letters anywhere in the image.";

        $response = Http::withToken($apiKey)
            ->withHeaders([
                'HTTP-Referer' => config('app.url'),
                'X-Title' => config('app.name'),
            ])
            ->timeout(120)
            ->post(self::ENDPOINT, [
                'model' => config('services.openrouter.image_model', 'google/gemini-2.5-flash-image-preview'),
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'modalities' => ['image', 'text'],
            ]);

        if ($response->failed()) {
            throw new RuntimeException(
                'Gagal generate gambar via OpenRouter: '.($response->json('error.message') ?? $response->status())
            );
        }

        $dataUrl = (string) $response->json('choices.0.message.images.0.image_url.url');

        if (blank($dataUrl) || ! str_contains($dataUrl, 'base64,')) {
            throw new RuntimeException('OpenRouter tidak mengembalikan gambar.');
        }

        $base64 = Str::after($dataUrl, 'base64,');
        $path = 'articles/'.Str::uuid().'.png';

        Storage::disk('public')->put($path, base64_decode($base64));

        return $path;
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

    protected function requestAnalysis(string $province, string $city, string $district, string $target, ?string $model): array
    {
        $apiKey = config('services.openrouter.key');

        if (blank($apiKey)) {
            throw new RuntimeException('OpenRouter API key belum diatur. Set OPENROUTER_API_KEY di file .env.');
        }

        $targetLabel = match ($target) {
            'gubernur' => 'Gubernur',
            'walikota' => 'Walikota',
            'bupati' => 'Bupati',
            'caleg' => 'Calon Legislatif (Caleg)',
            default => $target,
        };

        $systemPrompt = <<<PROMPT
            Anda adalah konsultan riset politik senior di Atom Visi Indonesia, lembaga riset independen yang fokus pada riset kebijakan publik, analisis politik & geopolitik, survey sosial, dan konsultasi strategi pemenangan.

            Anda diberi wilayah target dan target jabatan politik. Buat ESTIMASI KASAR yang realistis berdasarkan pengetahuan umum demografi Indonesia (BUKAN data resmi BPS/KPU, ini hanya untuk simulasi awal).

            Balas HANYA dengan satu objek JSON valid (tanpa markdown fence, tanpa teks lain di luar JSON) dengan struktur PERSIS seperti ini:
            {
              "jumlah_penduduk": <integer>,
              "jumlah_pemilih_potensial": <integer>,
              "kelompok_umur_dominan": "<string singkat, contoh '25-34 tahun'>",
              "langkah_strategis": ["<string, maksimal 25 kata>", ... total 5 sampai 7 item],
              "porsi_komunikasi": {"baliho": <integer>, "sosialisasi_kunjungan": <integer>, "instagram": <integer>, "whatsapp": <integer>},
              "roadmap": [
                {"bulan": <integer 1-12>, "fokus": "<string, maksimal 8 kata>",
                 "minggu": [{"minggu": 1, "aktivitas": "<string, maksimal 15 kata>"}, {"minggu": 2, "aktivitas": "..."}, {"minggu": 3, "aktivitas": "..."}, {"minggu": 4, "aktivitas": "..."}]}
              ]
            }

            Aturan wajib:
            - "porsi_komunikasi": 4 angka integer (baliho, sosialisasi_kunjungan, instagram, whatsapp), totalnya harus PERSIS 100.
            - "roadmap": harus TEPAT 12 objek bulan (bulan 1 sampai 12 berurutan), masing-masing harus TEPAT 4 objek minggu. Jangan kurang, jangan lebih.
            - Semua teks dalam Bahasa Indonesia, singkat sesuai batas kata, tanpa penjelasan tambahan di luar struktur JSON di atas.
            PROMPT;

        $userPrompt = "Provinsi: {$province}\nKota/Kabupaten: {$city}\nKecamatan: {$district}\nTarget jabatan: {$targetLabel}";

        $response = Http::withToken($apiKey)
            ->withHeaders([
                'HTTP-Referer' => config('app.url'),
                'X-Title' => config('app.name'),
            ])
            ->timeout(180)
            ->post(self::ENDPOINT, [
                'model' => $model ?: config('services.openrouter.model', 'google/gemini-2.5-flash'),
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userPrompt],
                ],
                'response_format' => ['type' => 'json_object'],
                'temperature' => 0.6,
            ]);

        if ($response->failed()) {
            throw new RuntimeException(
                'Gagal menghubungi OpenRouter: '.($response->json('error.message') ?? $response->status())
            );
        }

        $raw = (string) $response->json('choices.0.message.content');

        return $this->parsePoliticalAnalysisJson($raw);
    }

    /**
     * @return array{
     *   jumlah_penduduk: int,
     *   jumlah_pemilih_potensial: int,
     *   kelompok_umur_dominan: string,
     *   langkah_strategis: array<int, string>,
     *   porsi_komunikasi: array{baliho: int, sosialisasi_kunjungan: int, instagram: int, whatsapp: int},
     *   roadmap: array<int, array{bulan: int, fokus: string, minggu: array<int, array{minggu: int, aktivitas: string}>}>
     * }
     */
    protected function parsePoliticalAnalysisJson(string $raw): array
    {
        $cleaned = trim($raw);
        $cleaned = preg_replace('/^```(?:json)?|```$/m', '', $cleaned);
        $cleaned = trim((string) $cleaned);

        $data = json_decode($cleaned, true);

        if (! is_array($data)) {
            throw new RuntimeException('Respons AI tidak sesuai format yang diharapkan.');
        }

        $requiredKeys = ['jumlah_penduduk', 'jumlah_pemilih_potensial', 'kelompok_umur_dominan', 'langkah_strategis', 'porsi_komunikasi', 'roadmap'];
        foreach ($requiredKeys as $key) {
            if (! array_key_exists($key, $data)) {
                throw new RuntimeException("Respons AI tidak lengkap, field \"{$key}\" hilang.");
            }
        }

        $porsiKomunikasi = $this->validatePorsiKomunikasi($data['porsi_komunikasi']);
        $roadmap = $this->validateRoadmap($data['roadmap']);

        return [
            'jumlah_penduduk' => (int) $data['jumlah_penduduk'],
            'jumlah_pemilih_potensial' => (int) $data['jumlah_pemilih_potensial'],
            'kelompok_umur_dominan' => (string) $data['kelompok_umur_dominan'],
            'langkah_strategis' => array_values(array_map('strval', (array) $data['langkah_strategis'])),
            'porsi_komunikasi' => $porsiKomunikasi,
            'roadmap' => $roadmap,
        ];
    }

    /**
     * @return array{baliho: int, sosialisasi_kunjungan: int, instagram: int, whatsapp: int}
     */
    protected function validatePorsiKomunikasi(mixed $porsi): array
    {
        $keys = ['baliho', 'sosialisasi_kunjungan', 'instagram', 'whatsapp'];

        if (! is_array($porsi)) {
            throw new RuntimeException('Respons AI untuk porsi komunikasi tidak valid.');
        }

        $values = [];
        foreach ($keys as $key) {
            if (! isset($porsi[$key]) || ! is_numeric($porsi[$key])) {
                throw new RuntimeException('Respons AI untuk porsi komunikasi tidak lengkap.');
            }
            $values[$key] = (int) $porsi[$key];
        }

        $total = array_sum($values);

        if ($total === 0) {
            throw new RuntimeException('Respons AI untuk porsi komunikasi tidak valid.');
        }

        if ($total !== 100) {
            if ($total < 90 || $total > 110) {
                throw new RuntimeException('Respons AI untuk porsi komunikasi tidak sesuai (total bukan 100%).');
            }

            // Normalize proportionally, then adjust the last key so it sums to exactly 100.
            $running = 0;
            $normalized = [];
            $keyCount = count($keys);
            foreach ($keys as $index => $key) {
                if ($index === $keyCount - 1) {
                    $normalized[$key] = 100 - $running;
                } else {
                    $normalized[$key] = (int) round(($values[$key] / $total) * 100);
                    $running += $normalized[$key];
                }
            }
            $values = $normalized;
        }

        return $values;
    }

    /**
     * @return array<int, array{bulan: int, fokus: string, minggu: array<int, array{minggu: int, aktivitas: string}>}>
     */
    protected function validateRoadmap(mixed $roadmap): array
    {
        if (! is_array($roadmap) || count($roadmap) !== 12) {
            throw new RuntimeException('Respons AI untuk roadmap tidak sesuai (harus tepat 12 bulan).');
        }

        $result = [];
        foreach (array_values($roadmap) as $index => $month) {
            if (! is_array($month) || ! isset($month['fokus'], $month['minggu']) || ! is_array($month['minggu']) || count($month['minggu']) !== 4) {
                throw new RuntimeException('Respons AI untuk roadmap tidak sesuai (setiap bulan harus tepat 4 minggu).');
            }

            $weeks = [];
            foreach (array_values($month['minggu']) as $weekIndex => $week) {
                if (! is_array($week) || ! isset($week['aktivitas'])) {
                    throw new RuntimeException('Respons AI untuk roadmap tidak sesuai.');
                }
                $weeks[] = [
                    'minggu' => $weekIndex + 1,
                    'aktivitas' => (string) $week['aktivitas'],
                ];
            }

            $result[] = [
                'bulan' => $index + 1,
                'fokus' => (string) $month['fokus'],
                'minggu' => $weeks,
            ];
        }

        return $result;
    }
}
