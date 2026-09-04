<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class SiteSettingsService
{
    private const CACHE_KEY = 'site_settings';

    public function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return SiteSetting::query()
                ->pluck('value', 'key')
                ->toArray();
        });
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->all()[$key] ?? $default;
    }

    public function set(string $key, mixed $value, string $type = 'string', string $group = 'general'): void
    {
        SiteSetting::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type, 'group' => $group]
        );

        Cache::forget(self::CACHE_KEY);
    }

    public function forget(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
