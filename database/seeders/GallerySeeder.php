<?php

namespace Database\Seeders;

use App\Models\GalleryAlbum;
use App\Models\GalleryPhoto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    private array $albums = [
        ['title' => 'Grand Alumni Reunion 2026', 'description' => 'Highlights from the 2026 Grand Alumni Reunion.', 'status' => 'published', 'sort_order' => 1],
        ['title' => 'Annual Literary Festival', 'description' => 'Scenes from the annual literary festival.', 'status' => 'published', 'sort_order' => 2],
        ['title' => 'Department Seminar Series', 'description' => 'Academic seminars and guest lectures.', 'status' => 'published', 'sort_order' => 3],
        ['title' => 'Cultural Evening 2025', 'description' => 'Performances and celebrations.', 'status' => 'published', 'sort_order' => 4],
        ['title' => 'Workshop on Creative Writing', 'description' => 'Hands-on creative writing workshop.', 'status' => 'published', 'sort_order' => 5],
        ['title' => 'Convocation Memories', 'description' => 'Graduation day moments.', 'status' => 'published', 'sort_order' => 6],
        ['title' => 'Alumni Meet 2025', 'description' => 'Alumni networking and socializing.', 'status' => 'published', 'sort_order' => 7],
        ['title' => 'Hidden Test Album', 'description' => 'This album is hidden from public view.', 'status' => 'hidden', 'sort_order' => 8],
    ];

    public function run(): void
    {
        $this->command->info('Seeding gallery albums and photos...');

        foreach ($this->albums as $index => $albumData) {
            $slug = Str::slug($albumData['title']);

            $album = GalleryAlbum::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $albumData['title'],
                    'description' => $albumData['description'],
                    'status' => $albumData['status'],
                    'sort_order' => $albumData['sort_order'],
                ]
            );

            $photoCount = $album->photos()->count();

            if ($photoCount < 6) {
                $this->createPhotos($album, $photoCount, $index);
            } else {
                $this->healMissingImages($album);
            }
        }

        $this->command->info('Gallery seeded: ' . GalleryAlbum::count() . ' albums, ' . GalleryPhoto::count() . ' photos.');
    }

    private function createPhotos(GalleryAlbum $album, int $existingCount, int $albumIndex): void
    {
        for ($i = $existingCount; $i < 6; $i++) {
            $photoNumber = ($albumIndex * 6) + $i + 1;
            $imagePath = "gallery/demo-{$photoNumber}.jpg";

            if (!Storage::disk('public')->exists($imagePath)) {
                $this->createDemoImage($imagePath, 800, 600);
            }

            GalleryPhoto::updateOrCreate(
                ['gallery_album_id' => $album->id, 'image' => $imagePath],
                [
                    'title' => 'Photo ' . ($i + 1),
                    'caption' => 'Demo photo for ' . $album->title,
                    'alt_text' => 'Photo ' . ($i + 1) . ' of ' . $album->title,
                    'sort_order' => $i + 1,
                    'status' => GalleryPhoto::STATUS_PUBLISHED,
                ]
            );
        }
    }

    private function healMissingImages(GalleryAlbum $album): void
    {
        foreach ($album->photos as $photo) {
            if (!Storage::disk('public')->exists($photo->image)) {
                $this->createDemoImage($photo->image, 800, 600);
            }
        }
    }

    private function createDemoImage(string $path, int $width, int $height): void
    {
        $image = imagecreatetruecolor($width, $height);
        $bgColor = imagecolorallocate($image, rand(100, 240), rand(100, 240), rand(100, 240));
        imagefilledrectangle($image, 0, 0, $width - 1, $height - 1, $bgColor);

        $textColor = imagecolorallocate($image, 50, 50, 50);
        imagestring($image, 5, 10, 10, 'EDAA Demo Image', $textColor);

        ob_start();
        imagejpeg($image, null, 85);
        $data = ob_get_clean();
        imagedestroy($image);

        Storage::disk('public')->put($path, $data);
    }
}
