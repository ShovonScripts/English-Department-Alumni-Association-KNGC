<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminUserSeeder::class);
        $this->call(MembershipTypeSeeder::class);
        $this->call(MembershipTierSeeder::class);
        $this->call(CommitteeSeeder2024::class);
        $this->call(DemoContentSeeder::class);
        $this->call(ExpenseCategorySeeder::class);
    }
}
