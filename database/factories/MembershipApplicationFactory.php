<?php

namespace Database\Factories;

use App\Enums\ApplicationStatus;
use App\Models\MembershipApplication;
use App\Models\MembershipTier;
use App\Models\MembershipType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MembershipApplicationFactory extends Factory
{
    protected $model = MembershipApplication::class;

    public function definition(): array
    {
        $submittedAt = fake()->dateTimeBetween('-3 months', 'now');

        return [
            'application_number' => MembershipApplication::generateApplicationNumber(),
            'membership_type_id' => MembershipType::factory(),
            'full_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('+8801#########'),
            'student_id' => fake()->optional(0.6)->numerify('####-###-####'),
            'batch' => fake()->optional(0.7)->numerify('####'),
            'graduation_year' => fake()->optional(0.8)->numberBetween(2015, 2025),
            'current_organization' => fake()->optional(0.7)->company(),
            'profession' => fake()->optional(0.6)->jobTitle(),
            'current_designation' => fake()->optional(0.5)->jobTitle(),
            'address' => fake()->optional(0.8)->address(),
            'city' => fake()->optional(0.8)->city(),
            'country' => fake()->randomElement(['Bangladesh', 'India', 'Nepal']),
            'date_of_birth' => fake()->optional(0.7)->dateTimeBetween('-30 years', '-20 years'),
            'application_message' => fake()->optional(0.5)->paragraph(),
            'status' => ApplicationStatus::Pending,
            'submitted_at' => $submittedAt,
        ];
    }

    public function pending(): static
    {
        return $this->state(fn () => ['status' => ApplicationStatus::Pending]);
    }

    public function underReview(): static
    {
        return $this->state(fn () => ['status' => ApplicationStatus::UnderReview]);
    }

    public function approved(): static
    {
        return $this->state(fn () => [
            'status' => ApplicationStatus::Approved,
            'reviewed_by' => User::factory()->admin(),
            'reviewed_at' => now(),
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn () => [
            'status' => ApplicationStatus::Rejected,
            'rejection_reason' => fake()->sentence(),
            'reviewed_by' => User::factory()->admin(),
            'reviewed_at' => now(),
        ]);
    }

    public function changesRequested(): static
    {
        return $this->state(fn () => [
            'status' => ApplicationStatus::ChangesRequested,
            'admin_notes' => fake()->sentence(),
            'reviewed_by' => User::factory()->admin(),
            'reviewed_at' => now(),
        ]);
    }

    public function forTier(MembershipTier $tier): static
    {
        return $this->state(fn () => ['requested_tier_id' => $tier->id]);
    }

    public function withAlumni(): static
    {
        return $this->state(fn () => [
            'alumni_id' => Alumni::factory(),
        ]);
    }
}
