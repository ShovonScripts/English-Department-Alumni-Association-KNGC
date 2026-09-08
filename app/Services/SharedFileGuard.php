<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Guards against deleting files that are still referenced elsewhere.
 *
 * Prevents data loss when a CMS record's cover / document is replaced or
 * deleted while the underlying file is shared by (or seeded into) another
 * record — for example the demo gallery images used as featured covers
 * across events, news, stories, publications and press releases.
 */
class SharedFileGuard
{
    /**
     * Tables + columns that can reference a shared file on the public disk.
     *
     * Order matters: the first reference found short-circuits the check.
     *
     * @var array<string, array<int, string>>
     */
    private const REFERENCE_COLUMNS = [
        'events' => ['cover_image'],
        'news' => ['featured_image'],
        'alumni_stories' => ['cover_image'],
        'gallery_albums' => ['cover_image'],
        'gallery_photos' => ['image'],
        'publications' => ['cover_image', 'document_path'],
        'press_releases' => ['cover_image', 'document_path'],
        'testimonials' => ['image_path'],
        'home_slider_images' => ['image_path'],
    ];

    /**
     * Delete a file from the public disk, but only if no other record
     * (besides the optional calling record) references the same path.
     */
    public static function deleteIfUnreferenced(
        ?string $path,
        ?int $ignoreId = null,
        ?string $ignoreTable = null,
    ): bool {
        if (! $path) {
            return false;
        }

        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            return false;
        }

        if (self::isReferenced($path, $ignoreId, $ignoreTable)) {
            return false;
        }

        $disk->delete($path);

        return true;
    }

    public static function isReferenced(?string $path, ?int $ignoreId = null, ?string $ignoreTable = null): bool
    {
        if (! $path) {
            return false;
        }

        foreach (self::REFERENCE_COLUMNS as $table => $columns) {
            foreach ($columns as $column) {
                $exists = DB::table($table)
                    ->where($column, $path)
                    ->when(
                        $ignoreTable === $table && $ignoreId,
                        fn ($query) => $query->where('id', '!=', $ignoreId)
                    )
                    ->exists();

                if ($exists) {
                    return true;
                }
            }
        }

        return false;
    }
}