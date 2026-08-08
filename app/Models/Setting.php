<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'phone',
        'whatsapp_message',
        'email',
        'address',
        'map_embed_url',
        'instagram_url',
        'facebook_url',
        'tiktok_url',
        'linkedin_url',
        'youtube_url',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1]);
    }

    public function getPhoneDigitsAttribute(): string
    {
        return preg_replace('/\D/', '', (string) $this->phone) ?? '';
    }

    public function getInstagramHandleAttribute(): ?string
    {
        if (blank($this->instagram_url)) {
            return null;
        }

        $path = trim(parse_url($this->instagram_url, PHP_URL_PATH) ?? '', '/');

        return $path !== '' ? '@'.$path : null;
    }
}
