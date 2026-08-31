<?php

namespace App\Models;

use App\Enums\FeeFrequency;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeePlan extends Model
{
    /** @use HasFactory<FeePlanFactory> */
    use HasFactory;

    protected $fillable = [
        'membership_type_id',
        'name',
        'slug',
        'amount',
        'currency',
        'frequency',
        'description',
        'is_active',
        'effective_from',
        'effective_until',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'is_active' => 'boolean',
            'effective_from' => 'date',
            'effective_until' => 'date',
            'sort_order' => 'integer',
            'frequency' => FeeFrequency::class,
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function membershipType(): BelongsTo
    {
        return $this->belongsTo(MembershipType::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Active plans applicable today (effective window contains today).
     */
    public function scopeCurrent(Builder $query): Builder
    {
        $today = now()->toDateString();

        return $query->active()
            ->where(fn (Builder $q) => $q->whereNull('effective_from')->orWhere('effective_from', '<=', $today))
            ->where(fn (Builder $q) => $q->whereNull('effective_until')->orWhere('effective_until', '>=', $today));
    }

    /**
     * Active plans whose effective window has not started yet.
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->active()
            ->whereNotNull('effective_from')
            ->where('effective_from', '>', now()->toDateString());
    }

    /**
     * Plans that are inactive or whose effective window has ended.
     */
    public function scopeExpired(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->where('is_active', false)
                ->orWhere(fn (Builder $inner) => $inner
                    ->whereNotNull('effective_until')
                    ->where('effective_until', '<', now()->toDateString()));
        });
    }

    public function scopeForType(Builder $query, int $membershipTypeId): Builder
    {
        return $query->where('membership_type_id', $membershipTypeId);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * The currently applicable fee plan for a membership type.
     */
    public static function currentForType(int $membershipTypeId): ?self
    {
        /** @var self|null $plan */
        $plan = static::query()
            ->current()
            ->forType($membershipTypeId)
            ->ordered()
            ->first();

        return $plan;
    }

    public function formattedAmount(): string
    {
        return '৳'.number_format((float) $this->amount);
    }

    public function frequencyLabel(): string
    {
        return $this->frequency?->label() ?? '';
    }

    /**
     * Timing classification: current, upcoming, or expired.
     */
    public function timingState(): string
    {
        if ($this->is_active) {
            $today = now()->startOfDay();

            if ($this->effective_from !== null && $this->effective_from->gt($today)) {
                return 'upcoming';
            }

            if (($this->effective_until === null || $this->effective_until->gte($today))) {
                return 'current';
            }
        }

        return 'expired';
    }

    /**
     * True when this plan's active effective range overlaps another active
     * plan of the same membership type — an ambiguous configuration.
     */
    public function overlapsWithActiveSibling(): bool
    {
        $today = now()->toDateString();

        return static::query()
            ->active()
            ->forType($this->membership_type_id)
            ->whereKeyNot($this->id ?? 0)
            ->where(fn (Builder $q) => $q->whereNull('effective_from')->orWhere('effective_from', '<=', $this->effective_until?->toDateString() ?? $today))
            ->where(fn (Builder $q) => $q->whereNull('effective_until')->orWhere('effective_until', '>=', $this->effective_from?->toDateString() ?? $today))
            ->exists();
    }
}
