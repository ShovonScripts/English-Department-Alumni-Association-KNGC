<?php

namespace App\Models;

use Database\Factories\GalleryAlbumFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryAlbum extends Model
{
    /** @use HasFactory<GalleryAlbumFactory> */
    use HasFactory;

    public const STATUS_PUBLISHED = 'published';

    public const STATUS_HIDDEN = 'hidden';

    protected $fillable = [
        'title', 'slug', 'description', 'cover_image',
        'event_id', 'status', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);

        if ($base === '') {
            $base = 'album';
        }

        $slug = $base;
        $suffix = 2;

        while (static::slugExists($slug, $ignoreId)) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }

    protected static function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        return static::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn (Builder $q, int $id) => $q->where('id', '!=', $id))
            ->exists();
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        return $this->cover_image ? Storage::disk('public')->url($this->cover_image) : null;
    }

    public function photos(): HasMany
    {
        return $this->hasMany(GalleryPhoto::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function scopeHidden(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_HIDDEN);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }
}
