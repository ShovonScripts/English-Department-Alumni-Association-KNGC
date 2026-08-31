<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\GalleryAlbum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GalleryAlbumFactory extends Factory
{
    protected $model = GalleryAlbum::class;

    public function definition(): array
    {
        $title = fake()->randomElement([
            'Alumni Reunion 2026',
            'English Department Memories',
            'Annual Lecture Series',
            'Poetry Night Highlights',
            'Cultural Evening 2025',
            'Department Seminar',
            'Convocation Memories',
            'Alumni Meet 2025',
            'Literary Festival',
            'Award Ceremony Gallery',
            'Homecoming Celebration',
            'Workshop Sessions',
        ]);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.$this->faker->unique()->numberBetween(1000, 9999),
            'description' => fake()->optional(0.7)->paragraph(2),
            'cover_image' => null,
            'event_id' => null,
            'status' => GalleryAlbum::STATUS_PUBLISHED,
            'sort_order' => 0,
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => GalleryAlbum::STATUS_PUBLISHED,
        ]);
    }

    public function hidden(): static
    {
        return $this->state(fn () => [
            'status' => GalleryAlbum::STATUS_HIDDEN,
        ]);
    }

    public function withEvent(): static
    {
        return $this->state(fn () => [
            'event_id' => Event::factory(),
        ]);
    }
}
