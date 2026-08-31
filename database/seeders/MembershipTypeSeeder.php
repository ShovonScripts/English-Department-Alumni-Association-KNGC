<?php

namespace Database\Seeders;

use App\Models\MembershipType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MembershipTypeSeeder extends Seeder
{
    /**
     * Seed the four EDAA-KNGC membership classifications from Article 4
     * of the Constitution (plus the Executive Committee classification).
     *
     * Fee amounts deliberately omitted — Feature 12 will manage fee plans.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'General Member',
                'description' => 'Former students of the English Department, KNGC, admitted through the prescribed application and registration.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Lifetime Member',
                'description' => 'Members recognised as lifetime members by the Executive Committee based on time and circumstances.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Honorary Member',
                'description' => 'Teachers of the English Department, honoured with honorary membership.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Executive Committee Member',
                'description' => 'Classification for members currently serving on the Executive Committee.',
                'sort_order' => 4,
            ],
        ];

        foreach ($types as $type) {
            MembershipType::updateOrCreate(
                ['slug' => Str::slug($type['name'])],
                $type
            );
        }
    }
}
