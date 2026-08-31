<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    const STATUS_UNREAD = 'unread';

    const STATUS_READ = 'read';

    const STATUS_ARCHIVED = 'archived';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'ip_address',
        'user_agent',
        'read_at',
        'archived_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'archived_at' => 'datetime',
    ];

    public function scopeUnread(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_UNREAD);
    }

    public function scopeRead(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_READ);
    }

    public function scopeArchived(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ARCHIVED);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', '!=', self::STATUS_ARCHIVED);
    }

    public function scopeLatest(Builder $query, int $limit = 10): Builder
    {
        return $query->orderByDesc('created_at')->limit($limit);
    }

    public function markAsRead(): void
    {
        $this->update([
            'status' => self::STATUS_READ,
            'read_at' => now(),
        ]);
    }

    public function markAsUnread(): void
    {
        $this->update([
            'status' => self::STATUS_UNREAD,
            'read_at' => null,
        ]);
    }

    public function archive(): void
    {
        $this->update([
            'status' => self::STATUS_ARCHIVED,
            'archived_at' => now(),
        ]);
    }

    public function unarchive(): void
    {
        $this->update([
            'status' => self::STATUS_UNREAD,
            'archived_at' => null,
        ]);
    }

    public function isUnread(): bool
    {
        return $this->status === self::STATUS_UNREAD;
    }

    public function isArchived(): bool
    {
        return $this->status === self::STATUS_ARCHIVED;
    }
}
