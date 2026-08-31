<?php

namespace Database\Factories;

use App\Models\Alumni;
use App\Models\AlumniStory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AlumniStoryFactory extends Factory
{
    protected $model = AlumniStory::class;

    public function definition(): array
    {
        $title = fake()->randomElement([
            'From Classroom to Global Career',
            'How the Department Shaped My Writing',
            'Lessons Beyond Literature',
            'Finding My Voice Through Shakespeare',
            'A Journey from Campus to Publishing',
            'The Mentors Who Changed Everything',
            'Building a Career in Media and Communications',
            'How Alumni Networks Open Doors',
            'Returning to Campus After Ten Years',
            'From Student to Professor',
            'The Power of a Liberal Arts Education',
            'Why I Keep Coming Back to Reunions',
            'Language as a Bridge Across Cultures',
            'My Experience Studying Abroad',
            'What the Department Taught Me About Resilience',
        ]);

        return [
            'alumni_id' => Alumni::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.$this->faker->unique()->numberBetween(1000, 9999),
            'excerpt' => fake()->paragraph(2),
            'content' => fake()->paragraphs(5, true),
            'cover_image' => null,
            'status' => AlumniStory::STATUS_DRAFT,
            'is_featured' => fake()->boolean(20),
            'published_at' => fake()->optional(0.7)->dateTimeBetween('-6 months', 'now'),
            'author_name' => fake()->randomElement([
                'Mercy Uche',
                'Kofi Adjei',
                'Ngozi Eze',
                'Tom Bello',
                'Dr. Grace Adeyemi',
                'Department Office',
                'EDAA Secretariat',
            ]),
            'sort_order' => 0,
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => AlumniStory::STATUS_PUBLISHED,
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'status' => AlumniStory::STATUS_DRAFT,
            'published_at' => null,
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn () => [
            'is_featured' => true,
        ]);
    }

    public function past(): static
    {
        return $this->state(fn () => [
            'status' => AlumniStory::STATUS_PUBLISHED,
            'published_at' => fake()->dateTimeBetween('-12 months', '-1 month'),
        ]);
    }

    public function future(): static
    {
        return $this->state(fn () => [
            'status' => AlumniStory::STATUS_PUBLISHED,
            'published_at' => fake()->dateTimeBetween('+1 week', '+3 months'),
        ]);
    }
}
