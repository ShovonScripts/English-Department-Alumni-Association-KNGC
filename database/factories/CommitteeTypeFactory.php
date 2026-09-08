<?php

namespace Database\Factories;

use App\Models\CommitteeType;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommitteeTypeFactory extends Factory
{
    protected $model = CommitteeType::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => ucfirst($name),
            'slug' => CommitteeType::uniqueSlug($name),
            'description' => fake()->sentence(),
            'is_active' => true,
            'sort_order' => fake()->unique()->numberBetween(1, 100),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }
}
