<?php

namespace Database\Factories;

use App\Models\MembershipTier;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MembershipTierFactory extends Factory
{
    protected $model = MembershipTier::class;

    public function definition(): array
    {
        $name = 'Recognition Tier '.str_pad((string) fake()->unique()->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'badge_label' => $name,
            'description' => fake()->optional(0.7)->sentence(8),
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
