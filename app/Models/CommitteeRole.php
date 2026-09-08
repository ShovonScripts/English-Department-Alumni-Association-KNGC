<?php

namespace App\Models;

use Database\Factories\CommitteeRoleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CommitteeRole extends Model
{
    /** @use HasFactory<CommitteeRoleFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
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

        while (static::query()->where('slug', $slug)->when($ignoreId, fn ($q, int $id) => $q->whereKeyNot($id))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
