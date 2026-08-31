<?php

namespace Database\Seeders;

use App\Enums\PaymentStatus;
use App\Models\FeePlan;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Seed realistic manual collection records against the existing seeded
     * memberships and fee plans.
     *
     * Idempotent: skipped entirely once any payment exists. Every record is
     * a manual association due — never a website-service purchase.
     */
    public function run(): void
    {
        if (Payment::exists()) {
            return;
        }

        $admin = User::query()->where('is_admin', true)->orderBy('id')->first();

        if ($admin === null) {
            return;
        }

        $generalPlan = FeePlan::query()->where('slug', 'general-membership-registration')->first();
        $execPlan = FeePlan::query()->where('slug', 'executive-committee-contribution')->first();
        $honoraryPlan = FeePlan::query()->where('slug', 'honorary-membership')->first();

        if ($generalPlan === null || $execPlan === null) {
            $this->call(FeePlanSeeder::class);
            $generalPlan = FeePlan::query()->where('slug', 'general-membership-registration')->first();
            $execPlan = FeePlan::query()->where('slug', 'executive-committee-contribution')->first();
        }

        $record = function (array $attributes) use ($admin) {
            Payment::create([
                ...$attributes,
                'payment_number' => Payment::generatePaymentNumber(),
                'currency' => 'BDT',
                'recorded_by' => $admin->id,
            ]);
        };

        // Full payment — Adaeze Okafor (General Member, ৳50).
        $adaeze = Membership::query()->whereHas('alumni', fn ($q) => $q->where('slug', 'adaeze-okafor'))->first();
        if ($adaeze !== null) {
            $record([
                'membership_id' => $adaeze->id,
                'fee_plan_id' => $generalPlan->id,
                'amount' => 50,
                'status' => PaymentStatus::Paid->value,
                'paid_at' => now()->subMonths(2)->toDateString(),
                'reference' => 'Cash Receipt #1024',
                'notes' => 'Collected during the reunion registration desk.',
            ]);
        }

        // Multiple partial payments — Halima Balogun pays ৳30 + ৳20 of ৳50.
        $halima = Membership::query()->whereHas('alumni', fn ($q) => $q->where('slug', 'halima-balogun'))->first();
        if ($halima !== null) {
            $record([
                'membership_id' => $halima->id,
                'fee_plan_id' => $generalPlan->id,
                'amount' => 30,
                'status' => PaymentStatus::Partial->value,
                'paid_at' => now()->subMonth()->toDateString(),
                'reference' => 'Cash Receipt #1031',
                'notes' => 'First instalment collected in person.',
            ]);
            $record([
                'membership_id' => $halima->id,
                'fee_plan_id' => $generalPlan->id,
                'amount' => 20,
                'status' => PaymentStatus::Partial->value,
                'paid_at' => now()->subDays(5)->toDateString(),
                'reference' => 'Cash Receipt #1047',
                'notes' => 'Final instalment; obligation fully settled.',
            ]);
        }

        // Monthly executive contribution — Chidi Eze, collected this month.
        $chidi = Membership::query()->whereHas('alumni', fn ($q) => $q->where('slug', 'chidi-eze'))->first();
        if ($chidi !== null && $execPlan !== null) {
            $record([
                'membership_id' => $chidi->id,
                'fee_plan_id' => $execPlan->id,
                'amount' => 100,
                'status' => PaymentStatus::Paid->value,
                'paid_at' => now()->toDateString(),
                'reference' => 'Bank Deposit #EDAA-55',
                'notes' => null,
            ]);
        }

        // Waived fee — Fatima Hossain's honorary obligation intentionally cleared.
        $fatima = Membership::query()->whereHas('alumni', fn ($q) => $q->where('slug', 'fatima-haddad'))->first();
        if ($fatima !== null && $honoraryPlan !== null) {
            $record([
                'membership_id' => $fatima->id,
                'fee_plan_id' => $honoraryPlan->id,
                'amount' => 0,
                'status' => PaymentStatus::Waived->value,
                'paid_at' => now()->subDays(10)->toDateString(),
                'notes' => 'Honorary member — fee waived by committee decision.',
            ]);
        }

        // Void payment — Tunde Balogun, kept for audit but excluded everywhere.
        $tunde = Membership::query()->whereHas('alumni', fn ($q) => $q->where('full_name', 'Tunde Balogun'))->first();
        if ($tunde !== null) {
            $record([
                'membership_id' => $tunde->id,
                'fee_plan_id' => $generalPlan->id,
                'amount' => 50,
                'status' => PaymentStatus::Void->value,
                'paid_at' => now()->subDays(20)->toDateString(),
                'reference' => 'Manual Receipt 2026-001',
                'voided_at' => now()->subDays(19),
                'voided_by' => $admin->id,
                'void_reason' => 'Duplicate entry recorded during data migration review.',
            ]);
        }
    }
}
