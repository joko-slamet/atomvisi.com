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
    /**
     * @param  array{age_range_label: string, candidate_status_label: string, public_recognition_label: string, voter_target_label: string, main_goal_label: string, local_issues_labels: array<int, string>, about_you: ?string}  $profile
     */
    public function generatePoliticalAnalysis(string $province, string $city, string $target, ?string $model = null, array $profile = []): array
    {
        try {
            return $this->requestAnalysis($province, $city, $target, $model, $profile);
        } catch (RuntimeException $e) {
            // Structured output from the model can occasionally be malformed; one silent retry
            // is cheap insurance against non-compliance without introducing queue infrastructure.
            return $this->requestAnalysis($province, $city, $target, $model, $profile);
        }
    }

    /**
     * Generate structured article content (title, excerpt, content) in both
     * Indonesian and English for a given prompt, in a single AI call.
     *
     * @return array{
     *   id: array{title: string, excerpt: string, content: string},
     *   en: array{title: string, excerpt: string, content: string}
     * }
     */
    public function generateArticle(string $prompt, string $type = 'article'): array
    {
        $apiKey = config('services.openrouter.key');

        if (blank($apiKey)) {
            throw new RuntimeException('OpenRouter API key belum diatur. Set OPENROUTER_API_KEY di file .env.');
        }

        $typeLabel = match ($type) {
            'op-ed' => 'opinion/op-ed piece',
            'newsletter' => 'newsletter update',
            default => 'research/news article',
        };

        $systemPrompt = <<<PROMPT
            You are an expert writer for Atom Visi Indonesia, an independent research institute focused on public policy research, political & geopolitical analysis, social surveys, and strategic consulting.

            Write a well-structured {$typeLabel} following the instruction given below, in BOTH Indonesian and English. Respond ONLY with a single JSON object (no markdown fences, no commentary) with exactly this structure:
            {
              "id": {"title": "...", "excerpt": "...", "content": "..."},
              "en": {"title": "...", "excerpt": "...", "content": "..."}
            }

            Rules for each language version:
            - "title": a compelling, concise headline (max 100 characters)
            - "excerpt": a 1-2 sentence summary (max 300 characters)
            - "content": the full article body as clean HTML using only <p>, <h2>, <h3>, <ul>, <li>, <strong>, <em> tags. Aim for 400-700 words. Do not include the title inside the content.
            - The English version must read as if originally written in English (a natural adaptation for that audience), not a literal word-for-word translation of the Indonesian version.
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
                    ['role' => 'user', 'content' => $prompt],
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
    public function generateArticleCoverImage(string $title, string $prompt): string
    {
        $apiKey = config('services.openrouter.key');

        if (blank($apiKey)) {
            throw new RuntimeException('OpenRouter API key belum diatur. Set OPENROUTER_API_KEY di file .env.');
        }

        $imagePrompt = "Professional editorial cover photo for a research/policy article titled \"{$title}\" about \"{$prompt}\". Photorealistic photography style — natural lighting, shallow depth of field, corporate/editorial photography. NOT an illustration, NOT a 3D render, NOT a cartoon or flat vector graphic. No text or letters anywhere in the image.";

        $response = Http::withToken($apiKey)
            ->withHeaders([
                'HTTP-Referer' => config('app.url'),
                'X-Title' => config('app.name'),
            ])
            ->timeout(120)
            ->post(self::ENDPOINT, [
                'model' => config('services.openrouter.image_model', 'google/gemini-2.5-flash-image-preview'),
                'messages' => [
                    ['role' => 'user', 'content' => $imagePrompt],
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
     * @return array{
     *   id: array{title: string, excerpt: string, content: string},
     *   en: array{title: string, excerpt: string, content: string}
     * }
     */
    protected function parseArticleJson(string $raw): array
    {
        $cleaned = trim($raw);
        $cleaned = preg_replace('/^```(?:json)?|```$/m', '', $cleaned);
        $cleaned = trim((string) $cleaned);

        $data = json_decode($cleaned, true);

        if (! is_array($data)) {
            throw new RuntimeException('Respons AI tidak sesuai format yang diharapkan. Coba lagi.');
        }

        $result = [];

        foreach (['id', 'en'] as $locale) {
            if (! isset($data[$locale]) || ! is_array($data[$locale]) || ! isset($data[$locale]['title'], $data[$locale]['content'])) {
                throw new RuntimeException("Respons AI tidak lengkap untuk versi \"{$locale}\". Coba lagi.");
            }

            $result[$locale] = [
                'title' => (string) $data[$locale]['title'],
                'excerpt' => (string) ($data[$locale]['excerpt'] ?? ''),
                'content' => (string) $data[$locale]['content'],
            ];
        }

        return $result;
    }

    /**
     * @param  array{age_range_label?: string, candidate_status_label?: string, public_recognition_label?: string, voter_target_label?: string, main_goal_label?: string, local_issues_labels?: array<int, string>, about_you?: ?string}  $profile
     */
    protected function requestAnalysis(string $province, string $city, string $target, ?string $model, array $profile = []): array
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

            Anda diberi wilayah target, target jabatan politik, dan profil kandidat. Buat ESTIMASI KASAR yang realistis berdasarkan pengetahuan umum demografi Indonesia (BUKAN data resmi BPS/KPU, ini hanya untuk simulasi awal).

            Jika hanya provinsi yang diberikan (target Gubernur), buat estimasi untuk keseluruhan provinsi tersebut. Jika kota/kabupaten juga diberikan (target Walikota/Bupati/Caleg), buat estimasi khusus untuk wilayah kota/kabupaten tersebut saja, bukan seluruh provinsi.

            PENTING: Manfaatkan profil kandidat (rentang usia, status pencalonan, tingkat pengenalan publik, kelompok masyarakat prioritas, prioritas sosialisasi saat ini, isu utama di wilayah, dan latar belakang kandidat jika diberikan) supaya "langkah_strategis", "porsi_komunikasi", dan "roadmap" benar-benar spesifik dan personal untuk kandidat ini — bukan generik. Contoh: kandidat baru dengan pengenalan publik rendah butuh roadmap awal yang fokus pada perkenalan diri, sementara petahana dengan pengenalan tinggi bisa langsung fokus penguatan dukungan pada isu prioritas. Sesuaikan juga porsi komunikasi dan langkah strategis dengan kelompok masyarakat prioritas serta isu utama yang dipilih.

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

        $userPrompt = $city !== ''
            ? "Provinsi: {$province}\nKota/Kabupaten: {$city}\nTarget jabatan: {$targetLabel}"
            : "Provinsi: {$province}\nTarget jabatan: {$targetLabel}";

        $userPrompt .= "\n\nProfil Kandidat:";
        $userPrompt .= "\n- Rentang usia: ".($profile['age_range_label'] ?? '-');
        $userPrompt .= "\n- Status pencalonan: ".($profile['candidate_status_label'] ?? '-');
        $userPrompt .= "\n- Tingkat pengenalan publik saat ini: ".($profile['public_recognition_label'] ?? '-');
        $userPrompt .= "\n- Kelompok masyarakat prioritas: ".($profile['voter_target_label'] ?? '-');
        $userPrompt .= "\n- Prioritas sosialisasi saat ini: ".($profile['main_goal_label'] ?? '-');
        $userPrompt .= "\n- Isu utama di wilayah: ".(filled($profile['local_issues_labels'] ?? null) ? implode(', ', $profile['local_issues_labels']) : '-');

        if (filled($profile['about_you'] ?? null)) {
            $userPrompt .= "\n- Latar belakang kandidat: {$profile['about_you']}";
        }

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
