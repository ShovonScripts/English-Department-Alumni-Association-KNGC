<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'alumni_id',
        'status',
        'verified_at',
        'verified_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'verified_at' => 'datetime',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class);
    }

    /**
     * Payment collections this user has recorded (audit trail).
     */
    public function recordedPayments(): HasMany
    {
        return $this->hasMany(Payment::class, 'recorded_by');
    }

    /**
     * Membership applications reviewed by this user.
     */
    public function reviewedApplications(): HasMany
    {
        return $this->hasMany(MembershipApplication::class, 'reviewed_by');
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function correctionRequests(): HasMany
    {
        return $this->hasMany(CorrectionRequest::class, 'reviewed_by');
    }

    public function isVerified(): bool
    {
        return ! is_null($this->verified_at);
    }

    public function isDisabled(): bool
    {
        return $this->status === 'disabled';
    }
}
