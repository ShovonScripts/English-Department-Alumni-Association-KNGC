<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Minimal key/value site settings store used for site-level switches such as
 * whether the public contribution leaderboard is enabled (Feature 14).
 *
 * Intentionally kept tiny — a general settings framework is out of scope.
 */
class SiteSetting extends Model
{
    /**
     * No timestamps on this minimal key/value store.
     */
    public $timestamps = false;

    /**
     * @var list<string>
     */
    protected $fillable = ['key', 'value'];

    /**
     * Read a setting value, falling back to a default when unset.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember('site_setting:'.$key, 300, function () use ($key, $default) {
            $value = static::query()->where('key', $key)->value('value');

            return $value ?? $default;
        });
    }

    /**
     * Create or update a setting value.
     */
    public static function set(string $key, mixed $value): void
    {
        static::query()->updateOrCreate(
            ['key' => $key],
            ['value' => (string) $value]
        );

        Cache::forget('site_setting:'.$key);
    }

    /**
     * Whether the public contribution leaderboard is currently enabled.
     *
     * Defaults to enabled when the setting row has not been created yet.
     */
    public static function leaderboardEnabled(): bool
    {
        return (bool) static::get('leaderboard_public_enabled', true);
    }

    /**
     * Whether the public finance transparency page is currently enabled.
     *
     * Defaults to disabled — finance data must be explicitly opted in.
     */
    public static function financePublicEnabled(): bool
    {
        return (bool) static::get('public_finance_enabled', false);
    }

    /**
     * Whether the public announcement bar is currently enabled.
     */
    public static function announcementEnabled(): bool
    {
        return (bool) static::get('announcement_enabled', false);
    }

    /**
     * The announcement bar text content.
     */
    public static function announcementText(): string
    {
        return (string) static::get('announcement_text', '');
    }
}
