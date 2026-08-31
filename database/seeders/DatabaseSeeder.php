<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        $this->call(AdminUserSeeder::class);
        $this->call(AlumniSeeder::class);
        $this->call(MembershipTypeSeeder::class);
        $this->call(MembershipTierSeeder::class);
        $this->call(MembershipSeeder::class);
        $this->call(FeePlanSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(ExpenseCategorySeeder::class);
        $this->call(ExpenseSeeder::class);
        $this->call(CommitteeMemberSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(NewsCategorySeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(AlumniStorySeeder::class);
        $this->call(GallerySeeder::class);
        $this->call(PublicationSeeder::class);
        $this->call(ContactMessageSeeder::class);
        $this->call(MembershipApplicationSeeder::class);
    }
}
