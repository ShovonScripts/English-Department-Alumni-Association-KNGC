<?php

namespace App\Models;

use Database\Factories\AlumniFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Alumni extends Model
{
    /** @use HasFactory<AlumniFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alumni';

    public const STATUS_ACTIVE = 'active';

    public const STATUS_INACTIVE = 'inactive';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'full_name',
        'slug',
        'profile_photo',
        'student_id',
        'batch',
        'session',
        'graduation_year',
        'degree',
        'designation',
        'organization',
        'profession',
        'city',
        'country',
        'bio',
        'email',
        'phone',
        'linkedin_url',
        'website_url',
        'is_featured',
        'status',
        'sort_order',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'graduation_year' => 'integer',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
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
     * Generate a unique slug derived from the alumni's name.
     */
    public static function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);

        if ($base === '') {
            $base = 'alumni';
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
     * The absolute URL of the alumni's profile photo, if one exists.
     */
    public function getProfilePhotoUrlAttribute(): ?string
    {
        return $this->profile_photo
            ? Storage::disk('public')->url($this->profile_photo)
            : null;
    }

    /**
     * A human-friendly location string, e.g. "Lagos, Nigeria".
     */
    public function getLocationAttribute(): ?string
    {
        return collect([$this->city, $this->country])->filter()->implode(', ') ?: null;
    }

    public function stories(): HasMany
    {
        return $this->hasMany(AlumniStory::class);
    }

    public function correctionRequests(): HasMany
    {
        return $this->hasMany(CorrectionRequest::class);
    }

    /**
     * Membership applications submitted by this alumni.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(MembershipApplication::class);
    }

    /**
     * The alumni's membership record, if one exists (one per alumnus).
     */
    public function membership(): HasOne
    {
        return $this->hasOne(Membership::class);
    }

    public function batchModel(): BelongsTo
    {
        return $this->belongsTo(Batch::class, 'batch', 'label');
    }

    /**
     * The user account linked to this alumni record.
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * The membership as shown publicly: active and marked public only.
     */
    public function publicMembership(): HasOne
    {
        return $this->hasOne(Membership::class)
            ->where('status', Membership::STATUS_ACTIVE)
            ->where('is_public', true);
    }

    public function profileCompletionPercentage(): int
    {
        $fields = [
            'profile_photo',
            'phone',
            'city',
            'country',
            'profession',
            'bio',
            'organization',
            'website_url',
            'linkedin_url',
        ];

        $completed = 0;
        foreach ($fields as $field) {
            if (! empty($this->{$field})) {
                $completed++;
            }
        }

        return (int) round(($completed / count($fields)) * 100);
    }

    public function missingProfileFields(): array
    {
        $fields = [
            'profile_photo' => 'Add a profile photo',
            'phone' => 'Add your phone number',
            'city' => 'Add your city',
            'country' => 'Add your country',
            'profession' => 'Add your profession',
            'bio' => 'Add a bio',
            'organization' => 'Add your organization',
            'website_url' => 'Add your website URL',
            'linkedin_url' => 'Add your LinkedIn profile',
        ];

        $missing = [];
        foreach ($fields as $field => $message) {
            if (empty($this->{$field})) {
                $missing[$field] = $message;
            }
        }

        return $missing;
    }
}
