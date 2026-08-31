<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition(): array
    {
        $title = fake()->randomElement([
            'Department Launches New Creative Writing Fellowship',
            'EDAA Awards Merit Scholarships to Four Students',
            'Alumni Mentorship Programme Opens for Applications',
            'Annual Reunion Date Announced',
            'Professor Adeyemi Delivers Keynote at International Conference',
            'New Library Wing Inaugurated',
            'Student Exchange Programme Expands',
            'Alumni Author Publishes New Novel',
            'Department Celebrates 50th Anniversary',
            'Research Grant Awards Announced',
            'Literary Magazine Launch Event',
            'Career Workshop for Final Year Students',
            'Alumni Networking Dinner Planned',
            'Guest Lecture Series Begins Next Week',
            'Poetry Competition Results Announced',
            'Community Outreach Programme Launched',
            'Annual General Meeting Scheduled',
            'Scholarship Fund Reaches New Milestone',
            'Distinguished Lecture Series Announced',
            'Creative Writing Workshop Highlights',
        ]);

        return [
            'news_category_id' => NewsCategory::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.$this->faker->unique()->numberBetween(1000, 9999),
            'excerpt' => fake()->paragraph(2),
            'content' => fake()->paragraphs(5, true),
            'featured_image' => null,
            'status' => News::STATUS_DRAFT,
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
            'status' => News::STATUS_PUBLISHED,
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'status' => News::STATUS_DRAFT,
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
            'status' => News::STATUS_PUBLISHED,
            'published_at' => fake()->dateTimeBetween('-12 months', '-1 month'),
        ]);
    }

    public function future(): static
    {
        return $this->state(fn () => [
            'status' => News::STATUS_PUBLISHED,
            'published_at' => fake()->dateTimeBetween('+1 week', '+3 months'),
        ]);
    }
}
