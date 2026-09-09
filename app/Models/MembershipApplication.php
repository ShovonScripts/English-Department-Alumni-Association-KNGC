<?php

namespace App\Models;

use App\Enums\ApplicationStatus;
use Database\Factories\MembershipApplicationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class MembershipApplication extends Model
{
    /** @use HasFactory<MembershipApplicationFactory> */
    use HasFactory;

    protected $fillable = [
        'application_number',
        'alumni_id',
        'membership_type_id',
        'requested_tier_id',
        'full_name',
        'email',
        'phone',
        'student_id',
        'batch',
        'graduation_year',
        'current_organization',
        'profession',
        'current_designation',
        'city',
        'country',
        'address',
        'date_of_birth',
        'application_message',
        'alumni_document_path',
        'alumni_document_original_name',
        'alumni_document_size',
        'alumni_document_mime_type',
        'profile_photo_path',
        'profile_photo_original_name',
        'profile_photo_size',
        'profile_photo_mime_type',
        'status',
        'admin_notes',
        'rejection_reason',
        'reviewed_by',
        'reviewed_at',
        'status_token_hash',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'graduation_year' => 'integer',
            'date_of_birth' => 'date',
            'reviewed_at' => 'datetime',
            'submitted_at' => 'datetime',
            'status' => ApplicationStatus::class,
        ];
    }

    // ── Relationships ───────────────────────────────────────────────

    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class);
    }

    public function membershipType(): BelongsTo
    {
        return $this->belongsTo(MembershipType::class, 'membership_type_id');
    }

    public function requestedTier(): BelongsTo
    {
        return $this->belongsTo(MembershipTier::class, 'requested_tier_id');
    }

    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // ── Application Number ──────────────────────────────────────────

    public static function generateApplicationNumber(): string
    {
        $attempts = 0;

        do {
            $latest = static::query()
                ->orderByDesc('application_number')
                ->value('application_number');

            $sequence = $latest !== null ? (int) substr($latest, 9) : 0;
            $number = 'EDAA-APP-'.str_pad((string) ($sequence + 1), 6, '0', STR_PAD_LEFT);

            if (! static::query()->where('application_number', $number)->exists()) {
                return $number;
            }

            $attempts++;
        } while ($attempts < 25);

        throw new \RuntimeException('Unable to generate a unique application number.');
    }

    // ── Status Token ────────────────────────────────────────────────

    /**
     * Generate a cryptographically random status token.
     * Returns the plain token; only the hash is stored in the database.
     */
    public static function generateStatusToken(): string
    {
        return Str::random(40);
    }

    /**
     * Hash a status token for storage.
     */
    public static function hashStatusToken(string $token): string
    {
        return hash('sha256', $token);
    }

    // ── Duplicate Protection ────────────────────────────────────────

    /**
     * Check if an active membership already exists for the given identifiers.
     */
    public static function hasActiveMembership(string $email, ?string $studentId): bool
    {
        $email = strtolower(trim($email));

        return Alumni::query()
            ->whereHas('membership', fn ($q) => $q->whereIn('status', [Membership::STATUS_ACTIVE, Membership::STATUS_PENDING]))
            ->where(function ($q) use ($email) {
                $q->whereRaw('LOWER(email) = ?', [$email]);
            })
            ->when($studentId, fn ($q) => $q->where('student_id', $studentId))
            ->exists();
    }

    /**
     * Check if there is already a pending or under-review application.
     */
    public static function hasActiveApplication(string $email, ?string $phone, ?string $studentId): bool
    {
        $email = strtolower(trim($email));
        $activeStatuses = ApplicationStatus::activeValues();

        return static::query()
            ->whereIn('status', $activeStatuses)
            ->where(function ($q) use ($email, $phone, $studentId) {
                $q->whereRaw('LOWER(email) = ?', [$email]);
                if ($phone) {
                    $q->orWhere('phone', $phone);
                }
                if ($studentId) {
                    $q->orWhere('student_id', $studentId);
                }
            })
            ->exists();
    }

    // ── Accessors ────────────────────────────────────────────────────

    public function getProfilePhotoUrlAttribute(): ?string
    {
        return $this->profile_photo_path
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($this->profile_photo_path)
            : null;
    }

    // ── Status Helpers ──────────────────────────────────────────────

    public function isPending(): bool
    {
        return $this->status === ApplicationStatus::Pending;
    }

    public function isActive(): bool
    {
        return in_array($this->status, ApplicationStatus::activeValues(), true);
    }

    public function isApproved(): bool
    {
        return $this->status === ApplicationStatus::Approved;
    }

    public function isRejected(): bool
    {
        return $this->status === ApplicationStatus::Rejected;
    }
}
