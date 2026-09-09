<?php

namespace Database\Seeders;

use App\Models\FeePlan;
use App\Models\MembershipType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FeePlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            ['type_slug' => 'general-member', 'name' => 'General Membership Registration', 'slug' => 'general-membership-registration', 'amount' => 500, 'frequency' => 'one_time', 'sort_order' => 1],
            ['type_slug' => 'general-member', 'name' => 'General Annual Subscription', 'slug' => 'general-annual-subscription', 'amount' => 200, 'frequency' => 'yearly', 'sort_order' => 2],
            ['type_slug' => 'lifetime-member', 'name' => 'Lifetime Membership Fee', 'slug' => 'lifetime-membership-fee', 'amount' => 5000, 'frequency' => 'one_time', 'sort_order' => 1],
            ['type_slug' => 'honorary-member', 'name' => 'Honorary Membership', 'slug' => 'honorary-membership', 'amount' => 0, 'frequency' => 'one_time', 'sort_order' => 1],
            ['type_slug' => 'executive-committee-member', 'name' => 'Executive Committee Contribution', 'slug' => 'executive-committee-contribution', 'amount' => 1000, 'frequency' => 'yearly', 'sort_order' => 1],
        ];

        foreach ($plans as $plan) {
            $type = MembershipType::where('slug', $plan['type_slug'])->first();

            if ($type) {
                FeePlan::updateOrCreate(
                    ['slug' => $plan['slug']],
                    [
                        'membership_type_id' => $type->id,
                        'name' => $plan['name'],
                        'amount' => $plan['amount'],
                        'currency' => 'BDT',
                        'frequency' => $plan['frequency'],
                        'is_active' => true,
                        'sort_order' => $plan['sort_order'],
                    ]
                );
            }
        }
    }
}
