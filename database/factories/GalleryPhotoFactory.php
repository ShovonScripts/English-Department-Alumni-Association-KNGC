<?php

namespace Database\Factories;

use App\Models\GalleryAlbum;
use App\Models\GalleryPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

class GalleryPhotoFactory extends Factory
{
    protected $model = GalleryPhoto::class;

    public function definition(): array
    {
        return [
            'gallery_album_id' => GalleryAlbum::factory(),
            'image' => 'gallery/demo-1.jpg',
            'title' => fake()->optional(0.6)->sentence(3),
            'caption' => fake()->optional(0.4)->sentence(6),
            'alt_text' => fake()->optional(0.5)->sentence(4),
            'sort_order' => 0,
            'status' => GalleryPhoto::STATUS_PUBLISHED,
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => GalleryPhoto::STATUS_PUBLISHED,
        ]);
    }

    public function hidden(): static
    {
        return $this->state(fn () => [
            'status' => GalleryPhoto::STATUS_HIDDEN,
        ]);
    }
}
