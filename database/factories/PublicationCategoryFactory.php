<?php

namespace Database\Factories;

use App\Models\PublicationCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PublicationCategoryFactory extends Factory
{
    protected $model = PublicationCategory::class;

    public function definition(): array
    {
        $name = $this->faker->randomElement([
            'Thesis',
            'Dissertation',
            'Journal Article',
            'Conference Paper',
            'Book',
            'Book Chapter',
            'Technical Report',
            'Working Paper',
            'Monograph',
            'Edited Volume',
            'Review Article',
            'Case Study',
            'Proceedings',
            'Policy Brief',
            'Working Paper Series',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name).'-'.$this->faker->unique()->numberBetween(1000, 9999),
            'description' => fake()->optional()->sentence(),
            'sort_order' => 0,
            'is_active' => true,
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => [
            'is_active' => true,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn () => [
            'is_active' => false,
        ]);
    }
}
