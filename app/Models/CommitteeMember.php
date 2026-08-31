<?php

namespace App\Models;

use Database\Factories\CommitteeMemberFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CommitteeMember extends Model
{
    /** @use HasFactory<CommitteeMemberFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'committee_members';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'position',
        'profile_photo',
        'short_bio',
        'biography',
        'email',
        'linkedin_url',
        'website_url',
        'sort_order',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Route model binding for public pages uses the slug.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Generate a unique slug derived from the member's name.
     */
    public static function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);

        if ($base === '') {
            $base = 'committee-member';
        }

        $slug = $base;
        $suffix = 2;

        while (self::slugExists($slug, $ignoreId)) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }

    /**
     * Determine whether the given slug is already in use.
     */
    protected static function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        return static::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists();
    }

    /**
     * The absolute URL of the member's profile photo, if one exists.
     */
    public function getProfilePhotoUrlAttribute(): ?string
    {
        return $this->profile_photo
            ? Storage::disk('public')->url($this->profile_photo)
            : null;
    }
}
