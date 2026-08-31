<?php

namespace App\Models;

use Database\Factories\MembershipFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Membership extends Model
{
    /** @use HasFactory<MembershipFactory> */
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_ACTIVE = 'active';

    public const STATUS_SUSPENDED = 'suspended';

    public const STATUS_CANCELLED = 'cancelled';

    public const STATUS_EXPIRED = 'expired';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_ACTIVE,
        self::STATUS_SUSPENDED,
        self::STATUS_CANCELLED,
        self::STATUS_EXPIRED,
    ];

    protected $fillable = [
        'alumni_id',
        'membership_type_id',
        'membership_tier_id',
        'membership_number',
        'status',
        'joined_at',
        'approved_at',
        'notes',
        'is_public',
        'show_on_leaderboard',
    ];

    protected function casts(): array
    {
        return [
            'joined_at' => 'date',
            'approved_at' => 'date',
            'is_public' => 'boolean',
            'show_on_leaderboard' => 'boolean',
        ];
    }

    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(MembershipType::class, 'membership_type_id');
    }

    public function tier(): BelongsTo
    {
        return $this->belongsTo(MembershipTier::class, 'membership_tier_id');
    }

    /**
     * Manual collection records anchored to this membership.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Generate the next sequential, unique membership number (EDAA-000001).
     *
     * Numbers are fixed-width, so descending string order equals numeric
     * order. The database holds a unique constraint on membership_number
     * as the final race-condition guard.
     */
    public static function generateMembershipNumber(): string
    {
        $attempts = 0;

        do {
            $latest = static::query()->orderByDesc('membership_number')->value('membership_number');
            $sequence = $latest !== null ? (int) substr($latest, 5) : 0;
            $number = 'EDAA-'.str_pad((string) ($sequence + 1), 6, '0', STR_PAD_LEFT);

            if (! static::query()->where('membership_number', $number)->exists()) {
                return $number;
            }

            $attempts++;
        } while ($attempts < 25);

        throw new \RuntimeException('Unable to generate a unique membership number.');
    }

    /**
     * Stamp approved_at when a membership becomes active for the first time.
     */
    public function syncApprovalStamp(): void
    {
        if ($this->status === self::STATUS_ACTIVE && $this->approved_at === null) {
            $this->forceFill(['approved_at' => now()->toDateString()])->saveQuietly();
        }
    }

    /**
     * The verified contribution total for this membership, derived only from
     * valid (paid + partial) payment records. Future contribution sources can
     * extend this without affecting consumers.
     */
    public function verifiedContributionTotal(): float
    {
        return (float) $this->payments()->valid()->sum('amount');
    }

    /**
     * Number of valid payment records contributing to this member's total.
     */
    public function verifiedPaymentCount(): int
    {
        return (int) $this->payments()->valid()->count();
    }

    /**
     * Whether this membership is eligible to appear on the public
     * contribution leaderboard: active, public profile, and explicitly
     * opted-in to leaderboard visibility.
     *
     * Note: eligibility to appear publicly is distinct from having a nonzero
     * contribution — the zero-contribution exclusion is applied at the query
     * layer so it can be relaxed independently later.
     */
    public function canAppearOnLeaderboard(): bool
    {
        return $this->status === self::STATUS_ACTIVE
            && $this->is_public === true
            && $this->show_on_leaderboard === true;
    }
}
