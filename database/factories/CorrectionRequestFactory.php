<?php

namespace Database\Factories;

use App\Models\Alumni;
use App\Models\CorrectionRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CorrectionRequest>
 */
class CorrectionRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'alumni_id' => Alumni::factory(),
            'requested_field' => 'full_name',
            'requested_value' => $this->faker->name(),
            'reason' => $this->faker->sentence(),
            'status' => CorrectionRequest::STATUS_PENDING,
            'reviewed_by' => null,
            'reviewed_at' => null,
        ];
    }
}
