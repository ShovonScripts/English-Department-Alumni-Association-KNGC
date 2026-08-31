<?php

namespace Database\Factories;

use App\Enums\FeeFrequency;
use App\Models\FeePlan;
use App\Models\MembershipType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FeePlanFactory extends Factory
{
    protected $model = FeePlan::class;

    public function definition(): array
    {
        $name = 'Fee Plan '.str_pad((string) fake()->unique()->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT);

        return [
            'membership_type_id' => MembershipType::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'amount' => fake()->randomElement([50, 100, 500, 5000]),
            'currency' => 'BDT',
            'frequency' => FeeFrequency::OneTime,
            'description' => fake()->optional(0.6)->sentence(8),
            'is_active' => true,
            'effective_from' => null,
            'effective_until' => null,
            'sort_order' => 0,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }

    public function monthly(): static
    {
        return $this->state(fn () => ['frequency' => FeeFrequency::Monthly]);
    }

    public function oneTime(): static
    {
        return $this->state(fn () => ['frequency' => FeeFrequency::OneTime]);
    }

    public function yearly(): static
    {
        return $this->state(fn () => ['frequency' => FeeFrequency::Yearly]);
    }

    public function custom(): static
    {
        return $this->state(fn () => ['frequency' => FeeFrequency::Custom]);
    }

    /**
     * Active and applicable today (no date boundaries).
     */
    public function current(): static
    {
        return $this->state(fn () => [
            'is_active' => true,
            'effective_from' => null,
            'effective_until' => null,
        ]);
    }

    /**
     * Active with a window that has already ended.
     */
    public function expired(): static
    {
        return $this->state(fn () => [
            'is_active' => true,
            'effective_from' => now()->subMonths(2)->toDateString(),
            'effective_until' => now()->subMonth()->toDateString(),
        ]);
    }

    /**
     * Active with a window starting in the future.
     */
    public function upcoming(): static
    {
        return $this->state(fn () => [
            'is_active' => true,
            'effective_from' => now()->addMonths(2)->toDateString(),
            'effective_until' => now()->addYear()->toDateString(),
        ]);
    }
}
