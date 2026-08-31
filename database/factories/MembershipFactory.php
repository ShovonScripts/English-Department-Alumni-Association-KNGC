<?php

namespace Database\Factories;

use App\Models\Alumni;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\MembershipType;
use Illuminate\Database\Eloquent\Factories\Factory;

class MembershipFactory extends Factory
{
    protected $model = Membership::class;

    public function definition(): array
    {
        return [
            'alumni_id' => Alumni::factory(),
            'membership_type_id' => MembershipType::factory(),
            'membership_tier_id' => MembershipTier::factory(),
            // Batch-safe unique number; the application path assigns
            // sequential numbers via Membership::generateMembershipNumber().
            'membership_number' => 'EDAA-'.str_pad((string) fake()->unique()->numberBetween(1, 999999), 6, '0', STR_PAD_LEFT),
            'status' => Membership::STATUS_ACTIVE,
            'joined_at' => fake()->dateTimeBetween('-3 years', 'now')->format('Y-m-d'),
            'approved_at' => now()->toDateString(),
            'notes' => fake()->optional(0.4)->sentence(8),
            'is_public' => true,
            'show_on_leaderboard' => true,
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => [
            'status' => Membership::STATUS_ACTIVE,
            'approved_at' => now()->toDateString(),
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn () => [
            'status' => Membership::STATUS_PENDING,
            'approved_at' => null,
        ]);
    }

    public function suspended(): static
    {
        return $this->state(fn () => [
            'status' => Membership::STATUS_SUSPENDED,
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn () => [
            'status' => Membership::STATUS_CANCELLED,
        ]);
    }

    public function expired(): static
    {
        return $this->state(fn () => [
            'status' => Membership::STATUS_EXPIRED,
        ]);
    }

    public function private(): static
    {
        return $this->state(fn () => [
            'is_public' => false,
        ]);
    }

    public function public(): static
    {
        return $this->state(fn () => [
            'is_public' => true,
        ]);
    }

    /**
     * Explicitly opted-in to the public contribution leaderboard.
     */
    public function leaderboardVisible(): static
    {
        return $this->state(fn () => [
            'show_on_leaderboard' => true,
        ]);
    }

    /**
     * Hidden from the public contribution leaderboard (Feature 14).
     */
    public function leaderboardHidden(): static
    {
        return $this->state(fn () => [
            'show_on_leaderboard' => false,
        ]);
    }

    public function lifetime(): static
    {
        return $this->state(fn () => [
            'membership_type_id' => MembershipType::query()->firstOrCreate(
                ['slug' => 'lifetime-member'],
                ['name' => 'Lifetime Member', 'sort_order' => 2]
            )->id,
        ]);
    }
}
