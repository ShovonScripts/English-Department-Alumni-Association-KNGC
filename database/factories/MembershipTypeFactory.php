<?php

namespace Database\Factories;

use App\Models\MembershipType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MembershipTypeFactory extends Factory
{
    protected $model = MembershipType::class;

    public function definition(): array
    {
        $name = 'Membership Type '.str_pad((string) fake()->unique()->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->optional(0.7)->sentence(10),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => [
            'is_active' => false,
        ]);
    }
}
