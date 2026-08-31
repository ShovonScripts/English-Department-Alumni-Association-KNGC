<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Publication extends Model
{
    use HasFactory;

    const STATUS_DRAFT = 'draft';

    const STATUS_PUBLISHED = 'published';

    protected $table = 'publications';

    protected $fillable = [
        'publication_category_id',
        'title',
        'slug',
        'subtitle',
        'description',
        'cover_image',
        'document_path',
        'document_original_name',
        'document_size',
        'document_mime_type',
        'author',
        'publisher',
        'publication_date',
        'status',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
        'publication_date' => 'date',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 2;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $originalSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PublicationCategory::class, 'publication_category_id');
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        return $this->cover_image
            ? Storage::disk('public')->url($this->cover_image)
            : null;
    }

    public function getDocumentUrlAttribute(): ?string
    {
        return $this->document_path
            ? Storage::disk('public')->url($this->document_path)
            : null;
    }

    public function getFormattedDocumentSizeAttribute(): ?string
    {
        if (! $this->document_size) {
            return null;
        }

        $bytes = (int) $this->document_size;

        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1).' MB';
        }

        if ($bytes >= 1024) {
            return round($bytes / 1024, 1).' KB';
        }

        return $bytes.' B';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_DRAFT);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeLatest(Builder $query, int $limit = 10): Builder
    {
        return $query->orderByDesc('publication_date')->limit($limit);
    }
}
