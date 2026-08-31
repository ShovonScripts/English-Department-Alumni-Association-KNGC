<?php

namespace App\Models;

use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Event extends Model
{
    /** @use HasFactory<EventFactory> */
    use HasFactory;

    protected $table = 'events';

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'cover_image',
        'short_description',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'venue',
        'address',
        'city',
        'country',
        'organizer',
        'capacity',
        'registration_deadline',
        'status',
        'is_featured',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'registration_deadline' => 'date',
            'capacity' => 'integer',
            'is_featured' => 'boolean',
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
            $base = 'event';
        }

        $slug = $base;
        $suffix = 2;

        while (self::slugExists($slug, $ignoreId)) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }

    protected static function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        return static::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class);
    }

    public function galleryAlbums(): HasMany
    {
        return $this->hasMany(GalleryAlbum::class);
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        return $this->cover_image
            ? Storage::disk('public')->url($this->cover_image)
            : null;
    }

    public function getLocationAttribute(): ?string
    {
        return collect([$this->city, $this->country])->filter()->implode(', ') ?: null;
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->event_date?->format('l, F j, Y') ?? '';
    }

    public function getFormattedTimeAttribute(): ?string
    {
        if (! $this->start_time) {
            return null;
        }

        $start = Carbon::parse($this->start_time)->format('g:i A');
        $end = $this->end_time ? Carbon::parse($this->end_time)->format('g:i A') : null;

        return $end ? "{$start} – {$end}" : $start;
    }

    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', Carbon::today());
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', Carbon::today());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function isUpcoming(): bool
    {
        return $this->event_date && $this->event_date->isFuture();
    }

    public function isPast(): bool
    {
        return $this->event_date && $this->event_date->isPast();
    }
}
