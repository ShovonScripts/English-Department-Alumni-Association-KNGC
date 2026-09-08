<?php

namespace Database\Factories;

use App\Models\Committee;
use App\Models\CommitteeType;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommitteeFactory extends Factory
{
    protected $model = Committee::class;

    public function definition(): array
    {
        $year = fake()->year();
        $name = fake()->unique()->words(3, true);

        return [
            'committee_type_id' => CommitteeType::factory(),
            'name' => ucfirst($name),
            'slug' => Committee::uniqueSlug($name),
            'description' => fake()->sentence(),
            'start_year' => $year,
            'end_year' => $year + 1,
            'is_current' => false,
            'sort_order' => fake()->unique()->numberBetween(1, 100),
        ];
    }

    public function current(): static
    {
        return $this->state(fn () => ['is_current' => true]);
    }
}
