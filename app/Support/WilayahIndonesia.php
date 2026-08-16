<?php

namespace App\Support;

class WilayahIndonesia
{
    /**
     * @var array{provinces: array<string, string>, regencies: array<string, array<string, string>>}|null
     */
    protected static ?array $data = null;

    /**
     * @return array<string, string> Province id => name, ordered alphabetically by name.
     */
    public static function provinces(): array
    {
        $provinces = static::load()['provinces'];
        asort($provinces);

        return $provinces;
    }

    /**
     * @return array<string, string> Regency/city id => name for the given province, ordered alphabetically.
     */
    public static function regencies(?string $provinceId): array
    {
        if (blank($provinceId)) {
            return [];
        }

        $regencies = static::load()['regencies'][$provinceId] ?? [];
        asort($regencies);

        return $regencies;
    }

    public static function provinceName(?string $provinceId): ?string
    {
        return static::load()['provinces'][$provinceId] ?? null;
    }

    public static function regencyName(?string $provinceId, ?string $regencyId): ?string
    {
        if (blank($provinceId) || blank($regencyId)) {
            return null;
        }

        return static::load()['regencies'][$provinceId][$regencyId] ?? null;
    }

    /**
     * @return array{provinces: array<string, string>, regencies: array<string, array<string, string>>}
     */
    protected static function load(): array
    {
        return static::$data ??= require resource_path('data/wilayah-indonesia.php');
    }
}
