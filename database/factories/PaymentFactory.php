<?php

namespace Database\Factories;

use App\Enums\PaymentStatus;
use App\Models\FeePlan;
use App\Models\Membership;
use App\Models\MembershipType;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        // Guarantee a valid financial relationship: the fee plan and the
        // membership always share one membership type. The companion
        // membership is suspended so factory scaffolding never leaks into
        // obligation aggregates (which only consider active memberships).
        $type = MembershipType::query()->inRandomOrder()->first()
            ?? MembershipType::factory()->create();

        // Scaffold plan is inactive so factory scaffolding never registers
        // as a "currently applicable" fee for the type; explicit states and
        // overrides can still pin any real plan (historical plans are
        // legitimately payable).
        $plan = FeePlan::factory()->inactive()->create(['membership_type_id' => $type->id]);
        $membership = Membership::factory()->create([
            'membership_type_id' => $type->id,
            'status' => Membership::STATUS_SUSPENDED,
        ]);

        return [
            'membership_id' => $membership->id,
            'fee_plan_id' => $plan->id,
            'payment_number' => 'EDAA-PAY-'.str_pad((string) fake()->unique()->numberBetween(1, 999999), 6, '0', STR_PAD_LEFT),
            'amount' => (float) $plan->amount > 0 ? $plan->amount : 50,
            'currency' => 'BDT',
            'status' => PaymentStatus::Paid->value,
            'paid_at' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'reference' => fake()->optional(0.5)->numerify('Cash Receipt ####'),
            'notes' => fake()->optional(0.4)->sentence(6),
            'recorded_by' => User::factory()->admin(),
        ];
    }

    public function paid(): static
    {
        return $this->state(fn () => ['status' => PaymentStatus::Paid->value]);
    }

    public function partial(): static
    {
        return $this->state(fn () => ['status' => PaymentStatus::Partial->value]);
    }

    public function waived(): static
    {
        return $this->state(fn () => ['status' => PaymentStatus::Waived->value, 'amount' => 0]);
    }

    public function void(): static
    {
        return $this->state(fn () => [
            'status' => PaymentStatus::Void->value,
            'voided_at' => now(),
        ]);
    }

    public function forMembership(Membership $membership): static
    {
        return $this->state(fn () => ['membership_id' => $membership->id]);
    }

    public function forFeePlan(FeePlan $feePlan): static
    {
        return $this->state(fn () => [
            'fee_plan_id' => $feePlan->id,
            // Keep the relationship valid when a plan is pinned explicitly.
            'membership_id' => Membership::factory()->create([
                'membership_type_id' => $feePlan->membership_type_id,
            ])->id,
        ]);
    }
}
