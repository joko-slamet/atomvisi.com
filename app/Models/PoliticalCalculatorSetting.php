<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoliticalCalculatorSetting extends Model
{
    protected $fillable = [
        'is_enabled',
        'model',
        'max_submissions_per_ip_per_day',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'max_submissions_per_ip_per_day' => 'integer',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1]);
    }

    public function resolvedModel(): string
    {
        return $this->model ?: config('services.openrouter.model', 'google/gemini-2.5-flash');
    }
}
