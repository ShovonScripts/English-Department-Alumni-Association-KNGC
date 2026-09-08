<?php

namespace Database\Seeders;

use App\Models\MembershipTier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MembershipTierSeeder extends Seeder
{
    /**
     * Seed the configurable recognition tiers.
     *
     * Tiers are auto-assigned based on total verified contributions.
     */
    public function run(): void
    {
        $tiers = [
            ['name' => 'Bronze', 'badge_label' => 'Bronze', 'description' => 'Entry recognition tier for contributing members.', 'min_contribution' => 0, 'max_contribution' => 999, 'sort_order' => 1],
            ['name' => 'Silver', 'badge_label' => 'Silver', 'description' => 'Recognition tier honouring steady contribution to the association.', 'min_contribution' => 1000, 'max_contribution' => 4999, 'sort_order' => 2],
            ['name' => 'Gold', 'badge_label' => 'Gold', 'description' => 'Recognition tier honouring significant sustained contribution.', 'min_contribution' => 5000, 'max_contribution' => 19999, 'sort_order' => 3],
            ['name' => 'Platinum', 'badge_label' => 'Platinum', 'description' => 'Recognition tier honouring exceptional generosity to the association.', 'min_contribution' => 20000, 'max_contribution' => null, 'sort_order' => 4],
        ];

        foreach ($tiers as $tier) {
            MembershipTier::updateOrCreate(
                ['slug' => Str::slug($tier['name'])],
                $tier
            );
        }
    }
}
