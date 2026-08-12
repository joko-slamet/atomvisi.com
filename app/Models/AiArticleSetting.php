<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiArticleSetting extends Model
{
    protected $fillable = [
        'is_scheduler_enabled',
        'run_times',
        'topics',
        'category_id',
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return array<int, string>
     */
    public function getTopicListAttribute(): array
    {
        return collect(preg_split('/\r?\n/', (string) $this->topics))
            ->map(fn (string $topic) => trim($topic))
            ->filter()
            ->values()
            ->all();
    }

    public function isDue(): bool
    {
        if (! $this->is_scheduler_enabled) {
            return false;
        }

        $times = $this->run_times ?? [];

        if (empty($times)) {
            return false;
        }

        $now = now();

        foreach ($times as $time) {
            if (! preg_match('/^(\d{1,2}):(\d{2})/', (string) $time, $matches)) {
                continue;
            }

            $scheduledAt = $now->copy()->setTime((int) $matches[1], (int) $matches[2], 0);

            // Grace window in case the scheduler tick is a little late.
            if ($now->lt($scheduledAt) || $now->diffInMinutes($scheduledAt) > 5) {
                continue;
            }

            if (blank($this->last_run_at) || $this->last_run_at->lt($scheduledAt)) {
                return true;
            }
        }

        return false;
    }
}
