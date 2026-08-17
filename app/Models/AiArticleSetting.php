<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiArticleSetting extends Model
{
    public const DEFAULT_PROMPT = <<<'PROMPT'
        Tulis satu artikel orisinal untuk kategori "{kategori}", sesuai fokus riset Atom Visi Indonesia (kebijakan publik, politik & geopolitik, survey sosial, dan konsultasi strategi). Pilih sudut pandang dan isu yang aktual serta relevan dengan situasi terkini di Indonesia.

        Tulis dengan gaya jurnalistik yang informatif dan berbasis data/analisis, mudah dipahami baik oleh pembaca umum maupun pengambil kebijakan. Pastikan artikel SEO-friendly: judul menarik dan memuat kata kunci utama, paragraf pembuka langsung merangkum inti isu, gunakan sub-judul yang jelas, serta sisipkan variasi kata kunci terkait secara alami tanpa terkesan dipaksakan. Tutup artikel dengan insight atau rekomendasi singkat yang actionable.
        PROMPT;

    protected $fillable = [
        'is_scheduler_enabled',
        'run_times',
        'prompt',
        'type',
        'last_run_at',
    ];

    protected $casts = [
        'is_scheduler_enabled' => 'boolean',
        'run_times' => 'array',
        'last_run_at' => 'datetime',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1]);
    }

    public function promptOrDefault(): string
    {
        return filled($this->prompt) ? $this->prompt : self::DEFAULT_PROMPT;
    }

    /**
     * Jam di "run_times" diisi admin dalam waktu lokal Indonesia (WIB), terlepas dari
     * timezone aplikasi (app.timezone = UTC), jadi perbandingannya dilakukan di sini.
     */
    public const SCHEDULE_TIMEZONE = 'Asia/Jakarta';

    public function isDue(): bool
    {
        if (! $this->is_scheduler_enabled) {
            return false;
        }

        $times = $this->run_times ?? [];

        if (empty($times)) {
            return false;
        }

        $now = now(self::SCHEDULE_TIMEZONE);
        $lastRunAt = $this->last_run_at?->copy()->setTimezone(self::SCHEDULE_TIMEZONE);

        foreach ($times as $time) {
            if (! preg_match('/^(\d{1,2}):(\d{2})/', (string) $time, $matches)) {
                continue;
            }

            $scheduledAt = $now->copy()->setTime((int) $matches[1], (int) $matches[2], 0);

            // Grace window in case the scheduler tick is a little late.
            if ($now->lt($scheduledAt) || $now->diffInMinutes($scheduledAt) > 5) {
                continue;
            }

            if (blank($lastRunAt) || $lastRunAt->lt($scheduledAt)) {
                return true;
            }
        }

        return false;
    }
}
