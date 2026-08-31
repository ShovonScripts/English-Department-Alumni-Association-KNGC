<?php

namespace Database\Seeders;

use App\Models\Alumni;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\MembershipType;
use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    /**
     * Seed demo memberships against existing alumni records.
     *
     * Idempotent: keyed on alumni_id via updateOrCreate, so repeated runs
     * never duplicate. Never deletes or modifies existing memberships.
     */
    public function run(): void
    {
        // Ensure the classifications and tiers exist.
        $this->call(MembershipTypeSeeder::class);
        $this->call(MembershipTierSeeder::class);

        $types = MembershipType::query()->pluck('id', 'slug');
        $tiers = MembershipTier::query()->pluck('id', 'slug');

        if ($types->isEmpty()) {
            return;
        }

        $memberships = [
            'adaeze-okafor' => [
                'type' => 'general-member',
                'tier' => 'gold',
                'status' => Membership::STATUS_ACTIVE,
                'is_public' => true,
                'show_on_leaderboard' => true,
                'joined_at' => '2024-02-10',
                'notes' => 'Founding register entry; active volunteer at reunions.',
            ],
            'kwame-mensah' => [
                'type' => 'lifetime-member',
                'tier' => 'platinum',
                'status' => Membership::STATUS_ACTIVE,
                'is_public' => true,
                'show_on_leaderboard' => true,
                'joined_at' => '2023-11-05',
                'notes' => 'Recognised for long-standing service to the department.',
            ],
            'halima-balogun' => [
                'type' => 'general-member',
                'tier' => 'silver',
                'status' => Membership::STATUS_ACTIVE,
                'is_public' => true,
                'show_on_leaderboard' => true,
                'joined_at' => '2024-06-21',
            ],
            'chidi-eze' => [
                'type' => 'executive-committee-member',
                'tier' => 'gold',
                'status' => Membership::STATUS_ACTIVE,
                'is_public' => true,
                'show_on_leaderboard' => true,
                'joined_at' => '2023-08-15',
            ],
            'fatima-haddad' => [
                'type' => 'honorary-member',
                'tier' => null,
                'status' => Membership::STATUS_ACTIVE,
                'is_public' => true,
                'show_on_leaderboard' => true,
                'joined_at' => '2024-01-30',
            ],
            'pending-demo' => [],
            'suspended-demo' => [],
            'private-demo' => [],
        ];

        foreach (['pending-demo', 'suspended-demo', 'private-demo'] as $key) {
            unset($memberships[$key]);
        }

        // Pick three further seeded alumni (any without a membership yet)
        // for the pending / suspended / private demo states.
        $remaining = Alumni::query()
            ->whereNotIn('slug', array_keys($memberships))
            ->orderBy('id')
            ->take(3)
            ->get();

        $extraStates = [
            ['type' => 'general-member', 'tier' => 'bronze', 'status' => Membership::STATUS_PENDING, 'is_public' => false, 'show_on_leaderboard' => false, 'joined_at' => '2026-07-12'],
            ['type' => 'general-member', 'tier' => 'bronze', 'status' => Membership::STATUS_SUSPENDED, 'is_public' => false, 'show_on_leaderboard' => false, 'joined_at' => '2024-03-18'],
            ['type' => 'general-member', 'tier' => null, 'status' => Membership::STATUS_ACTIVE, 'is_public' => false, 'show_on_leaderboard' => false, 'joined_at' => '2025-09-09'],
        ];

        foreach ($remaining as $index => $alumni) {
            $state = $extraStates[$index % count($extraStates)];
            $memberships[$alumni->slug] = $state + ['notes' => null];
        }

        foreach ($memberships as $slug => $config) {
            $alumni = Alumni::query()->where('slug', $slug)->first();

            if (! $alumni || $alumni->membership()->exists()) {
                continue;
            }

            Membership::create([
                'alumni_id' => $alumni->id,
                'membership_type_id' => $types[$config['type']],
                'membership_tier_id' => $config['tier'] !== null ? $tiers[$config['tier']] : null,
                'membership_number' => Membership::generateMembershipNumber(),
                'status' => $config['status'],
                'joined_at' => $config['joined_at'],
                'approved_at' => $config['status'] === Membership::STATUS_ACTIVE ? $config['joined_at'] : null,
                'notes' => $config['notes'] ?? null,
                'is_public' => $config['is_public'],
                'show_on_leaderboard' => $config['show_on_leaderboard'] ?? true,
            ]);
        }
    }
}
