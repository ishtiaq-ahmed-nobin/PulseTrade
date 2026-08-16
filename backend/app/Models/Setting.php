<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Throwable;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        try {
            if (! Schema::hasTable('settings')) {
                return $default;
            }
        } catch (Throwable) {
            return $default;
        }

        $cached = Cache::get("setting_{$key}");
        if ($cached !== null) return $cached;

        $setting = static::where('key', $key)->first();
        $value = $setting?->value ?? $default;
        Cache::put("setting_{$key}", $value, 3600);
        return $value;
    }

    public static function set(string $key, mixed $value, string $group = 'general'): void
    {
        static::updateOrCreate(['key' => $key], [
            'value' => $value,
            'group' => $group,
        ]);
        Cache::forget("setting_{$key}");
    }
}
