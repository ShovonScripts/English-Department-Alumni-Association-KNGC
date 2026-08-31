<?php

namespace Database\Factories;

use App\Models\NewsCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsCategoryFactory extends Factory
{
    protected $model = NewsCategory::class;

    public function definition(): array
    {
        $id = $this->faker->unique()->numberBetween(1, 99999);
        $name = 'Category '.$id;

        return [
            'name' => $name,
            'slug' => 'category-'.$id,
            'description' => fake()->sentence(),
            'sort_order' => fake()->numberBetween(0, 20),
            'is_active' => true,
        ];
    }
}
