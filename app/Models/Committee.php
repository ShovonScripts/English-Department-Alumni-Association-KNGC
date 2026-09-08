<?php

namespace App\Models;

use Database\Factories\CommitteeFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Committee extends Model
{
    /** @use HasFactory<CommitteeFactory> */
    use HasFactory;

    protected $fillable = [
        'committee_type_id',
        'name',
        'slug',
        'description',
        'start_year',
        'end_year',
        'is_current',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'start_year' => 'integer',
            'end_year' => 'integer',
            'is_current' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public static function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $base = $slug;
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
            ->when($ignoreId, fn (Builder $q, int $id) => $q->whereKeyNot($id))
            ->exists();
    }

    // ── Relationships ───────────────────────────────────────────────

    public function type(): BelongsTo
    {
        return $this->belongsTo(CommitteeType::class, 'committee_type_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Membership::class, 'committee_pivot')
            ->withPivot(['committee_role_id', 'sort_order'])
            ->withTimestamps()
            ->orderByPivot('sort_order');
    }

    // ── Scopes ──────────────────────────────────────────────────────

    public function scopeCurrent(Builder $query): Builder
    {
        return $query->where('is_current', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderByDesc('start_year')->orderBy('sort_order')->orderBy('name');
    }

    // ── Helpers ─────────────────────────────────────────────────────

    /**
     * Mark this committee as current for its type, unmarking any previous current.
     */
    public function markAsCurrent(): void
    {
        // Unmark all other current committees of the same type.
        static::query()
            ->where('committee_type_id', $this->committee_type_id)
            ->where('is_current', true)
            ->whereKeyNot($this->id)
            ->update(['is_current' => false]);

        $this->update(['is_current' => true]);
    }

    /**
     * Year range label, e.g. "2024 – 2025".
     */
    public function yearRange(): string
    {
        return $this->start_year.' – '.$this->end_year;
    }

    /**
     * Members with their roles, ordered by role sort order.
     */
    public function membersWithRoles()
    {
        return Membership::query()
            ->join('committee_pivot as cp', 'cp.membership_id', '=', 'memberships.id')
            ->join('committee_roles as cr', 'cr.id', '=', 'cp.committee_role_id')
            ->where('cp.committee_id', $this->id)
            ->orderBy('cr.sort_order')
            ->orderBy('cp.sort_order')
            ->select('memberships.*', 'cp.committee_role_id as pivot_committee_role_id', 'cp.sort_order as pivot_sort_order', 'cr.name as role_name', 'cr.slug as role_slug')
            ->with('alumni')
            ->get();
    }
}
