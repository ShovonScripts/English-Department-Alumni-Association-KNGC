<?php

namespace Database\Factories;

use App\Models\CommitteeRole;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommitteeRoleFactory extends Factory
{
    protected $model = CommitteeRole::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => ucfirst($name),
            'slug' => CommitteeRole::uniqueSlug($name),
            'sort_order' => fake()->unique()->numberBetween(1, 100),
        ];
    }
}
