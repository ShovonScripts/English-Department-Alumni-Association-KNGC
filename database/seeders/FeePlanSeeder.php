<?php

namespace Database\Seeders;

use App\Enums\FeeFrequency;
use App\Models\FeePlan;
use App\Models\MembershipType;
use Illuminate\Database\Seeder;

class FeePlanSeeder extends Seeder
{
    /**
     * Seed the constitutional baseline fee plans.
     *
     * Idempotent via slug-keyed updateOrCreate; never deletes or modifies
     * unrelated records.
     *
     * The Constitution fixes only the General (৳50 one-time) and Executive
     * Committee (৳100 monthly) fees. Lifetime and Honorary amounts are
     * "as decided by the Executive Committee", so they are seeded inactive
     * with a zero amount rather than inventing official figures — admins
     * can activate them once the committee sets an amount.
     */
    public function run(): void
    {
        $typeIds = MembershipType::query()->pluck('id', 'slug');

        if ($typeIds->isEmpty()) {
            $this->call(MembershipTypeSeeder::class);
            $typeIds = MembershipType::query()->pluck('id', 'slug');
        }

        $plans = [
            'general-membership-registration' => [
                'membership_type_id' => $typeIds['general-member'],
                'name' => 'General Membership Registration',
                'amount' => 50,
                'currency' => 'BDT',
                'frequency' => FeeFrequency::OneTime,
                'description' => 'One-time registration fee for General Members as defined by the EDAA-KNGC Constitution.',
                'is_active' => true,
                'effective_from' => null,
                'effective_until' => null,
                'sort_order' => 1,
            ],
            'executive-committee-contribution' => [
                'membership_type_id' => $typeIds['executive-committee-member'],
                'name' => 'Executive Committee Contribution',
                'amount' => 100,
                'currency' => 'BDT',
                'frequency' => FeeFrequency::Monthly,
                'description' => 'Monthly contribution for Executive Committee Members as defined by the EDAA-KNGC Constitution.',
                'is_active' => true,
                'effective_from' => null,
                'effective_until' => null,
                'sort_order' => 2,
            ],
            'lifetime-membership' => [
                'membership_type_id' => $typeIds['lifetime-member'],
                'name' => 'Lifetime Membership',
                'amount' => 0,
                'currency' => 'BDT',
                'frequency' => FeeFrequency::OneTime,
                'description' => 'Amount to be determined by the Executive Committee. Activate this plan once the committee sets the fee.',
                'is_active' => false,
                'effective_from' => null,
                'effective_until' => null,
                'sort_order' => 3,
            ],
            'honorary-membership' => [
                'membership_type_id' => $typeIds['honorary-member'],
                'name' => 'Honorary Membership',
                'amount' => 0,
                'currency' => 'BDT',
                'frequency' => FeeFrequency::Custom,
                'description' => 'Amount to be determined by the Executive Committee. Activate this plan once the committee sets the fee.',
                'is_active' => false,
                'effective_from' => null,
                'effective_until' => null,
                'sort_order' => 4,
            ],
        ];

        foreach ($plans as $slug => $plan) {
            FeePlan::updateOrCreate(['slug' => $slug], $plan);
        }
    }
}
