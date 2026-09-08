<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Batch extends Model
{
    protected $fillable = [
        'slug',
        'label',
        'start_year',
        'end_year',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_year' => 'integer',
        'end_year' => 'integer',
        'sort_order' => 'integer',
    ];

    // ── Scopes ──────────────────────────────────────────────────

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderByDesc('start_year');
    }

    // ── Helpers ─────────────────────────────────────────────────

    public static function uniqueSlug(string $label, ?int $ignoreId = null): string
    {
        $base = Str::slug($label);

        if ($base === '') {
            $base = 'batch';
        }

        $slug = $base;
        $suffix = 2;

        while (static::query()->where('slug', $slug)->where('id', '!=', $ignoreId)->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }

    /**
     * Generate label from start_year and end_year (e.g. "2002-03").
     */
    public static function makeLabel(int $startYear, int $endYear): string
    {
        return $startYear.'-'.substr((string) $endYear, -2);
    }

    /**
     * Alumni relationship.
     */
    public function alumni()
    {
        return $this->hasMany(Alumni::class, 'batch', 'label');
    }
}
