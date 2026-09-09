<?php

namespace Database\Seeders;

use App\Models\Alumni;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\MembershipType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MembershipSeeder extends Seeder
{
    public function run(): void
    {
        $alumniList = Alumni::query()->get();

        if ($alumniList->isEmpty()) {
            return;
        }

        if (MembershipType::count() === 0) {
            $this->call(MembershipTypeSeeder::class);
        }

        if (MembershipTier::count() === 0) {
            $this->call(MembershipTierSeeder::class);
        }

        $types = MembershipType::query()->pluck('id', 'slug');
        $tiers = MembershipTier::query()->pluck('id');

        $typeSlugs = $types->keys();
        $statuses = [
            Membership::STATUS_ACTIVE,
            Membership::STATUS_ACTIVE,
            Membership::STATUS_ACTIVE,
            Membership::STATUS_ACTIVE,
            Membership::STATUS_PENDING,
            Membership::STATUS_SUSPENDED,
        ];

        $index = 0;

        foreach ($alumniList as $alumni) {
            $existing = Membership::where('alumni_id', $alumni->id)->first();

            if ($existing) {
                $index++;
                continue;
            }

            $typeSlug = $typeSlugs[$index % $typeSlugs->count()];
            $typeId = $types[$typeSlug];
            $status = $statuses[$index % count($statuses)];
            $isPublic = $index !== ($alumniList->count() - 1);
            $showOnLeaderboard = $isPublic;

            $tierId = $index === 0 ? null : ($tiers->isNotEmpty() ? $tiers->random() : null);

            Membership::create([
                'alumni_id' => $alumni->id,
                'membership_type_id' => $typeId,
                'membership_tier_id' => $tierId,
                'membership_number' => Membership::generateMembershipNumber(),
                'status' => $status,
                'is_public' => $isPublic,
                'show_on_leaderboard' => $showOnLeaderboard,
                'joined_at' => now()->subMonths(rand(1, 24))->toDateString(),
                'approved_at' => $status === Membership::STATUS_ACTIVE ? now()->subMonths(rand(1, 24))->toDateString() : null,
            ]);

            $index++;
        }
    }
}
