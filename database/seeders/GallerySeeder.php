<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\GalleryAlbum;
use App\Models\GalleryPhoto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        // Heal demo assets first so re-running the seeder on an existing
        // installation restores any missing seeded image files.
        $this->ensureDemoImages();

        if (GalleryAlbum::exists()) {
            return;
        }

        $events = Event::where('status', 'published')->pluck('id', 'slug');

        $albums = [
            [
                'title' => 'Alumni Reunion 2026',
                'description' => 'Photos from the annual alumni reunion held on campus, featuring distinguished graduates and faculty.',
                'event_id' => null,
                'status' => 'published',
                'photo_count' => 8,
            ],
            [
                'title' => 'Annual Lecture Series',
                'description' => 'Highlights from this year\'s distinguished lecture series featuring renowned scholars.',
                'event_id' => null,
                'status' => 'published',
                'photo_count' => 6,
            ],
            [
                'title' => 'Poetry Night: New Voices',
                'description' => 'An evening of spoken word and poetry readings by current students and alumni.',
                'event_id' => null,
                'status' => 'published',
                'photo_count' => 7,
            ],
            [
                'title' => 'Cultural Evening 2025',
                'description' => 'A celebration of diverse cultural expressions through literature, music, and performance.',
                'event_id' => null,
                'status' => 'published',
                'photo_count' => 5,
            ],
            [
                'title' => 'Department Seminar',
                'description' => 'Academic presentations and discussions from the department\'s annual research seminar.',
                'event_id' => null,
                'status' => 'published',
                'photo_count' => 4,
            ],
            [
                'title' => 'Award Ceremony Gallery',
                'description' => 'Moments from the annual awards ceremony recognizing outstanding alumni achievements.',
                'event_id' => null,
                'status' => 'published',
                'photo_count' => 6,
            ],
            [
                'title' => 'Homecoming Celebration',
                'description' => 'A nostalgic look back at this year\'s homecoming festivities on campus.',
                'event_id' => null,
                'status' => 'published',
                'photo_count' => 9,
            ],
            [
                'title' => 'Internal Planning Meeting',
                'description' => 'Private album for committee planning sessions.',
                'event_id' => null,
                'status' => 'hidden',
                'photo_count' => 3,
            ],
        ];

        $photoTitles = [
            'Opening ceremony',
            'Keynote address',
            'Group photograph',
            'Award presentation',
            'Panel discussion',
            'Audience engagement',
            'Networking session',
            'Closing remarks',
            'Campus tour',
            'Cultural performance',
            'Poetry reading',
            'Reception dinner',
            'Faculty gathering',
            'Student interaction',
            'Library visit',
        ];

        foreach ($albums as $albumData) {
            $photoCount = $albumData['photo_count'];
            unset($albumData['photo_count']);

            $album = GalleryAlbum::create([
                ...$albumData,
                'slug' => Str::slug($albumData['title']),
            ]);

            for ($i = 0; $i < $photoCount; $i++) {
                GalleryPhoto::create([
                    'gallery_album_id' => $album->id,
                    'image' => 'gallery/demo-'.(($i % count(self::DEMO_IMAGES)) + 1).'.jpg',
                    'title' => $photoTitles[array_rand($photoTitles)],
                    'caption' => fake()->optional(0.5)->sentence(6),
                    'alt_text' => fake()->optional(0.5)->sentence(4),
                    'sort_order' => $i + 1,
                    'status' => ($i === 0 && $albumData['status'] === 'hidden') ? 'hidden' : 'published',
                ]);
            }
        }
    }

    /**
     * Deterministic demo image assets used by the seeded albums.
     *
     * @var array<string, array{0: int, 1: int, 2: int}>
     */
    private const DEMO_IMAGES = [
        'demo-1.jpg' => [126, 34, 206],   // maroon
        'demo-2.jpg' => [15, 23, 42],     // navy
        'demo-3.jpg' => [212, 175, 55],   // gold
        'demo-4.jpg' => [22, 101, 52],    // green
        'demo-5.jpg' => [194, 65, 12],    // orange
        'demo-6.jpg' => [29, 78, 216],    // blue
    ];

    /**
     * Generate any missing deterministic demo images (800x600 JPEG) so the
     * seeded gallery works on a fresh installation without binary assets.
     */
    private function ensureDemoImages(): void
    {
        foreach (self::DEMO_IMAGES as $filename => [$r, $g, $b]) {
            $path = 'gallery/'.$filename;

            if (Storage::disk('public')->exists($path)) {
                continue;
            }

            $image = imagecreatetruecolor(800, 600);
            $background = imagecolorallocate($image, $r, $g, $b);
            imagefill($image, 0, 0, $background);

            $accent = imagecolorallocate($image, 255, 255, 255);
            imagerectangle($image, 20, 20, 779, 579, $accent);

            ob_start();
            imagejpeg($image, null, 85);
            $binary = (string) ob_get_clean();
            imagedestroy($image);

            Storage::disk('public')->put($path, $binary);
        }
    }
}
