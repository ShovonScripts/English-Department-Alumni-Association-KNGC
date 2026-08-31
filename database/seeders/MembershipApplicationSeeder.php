<?php

namespace Database\Seeders;

use App\Enums\ApplicationStatus;
use App\Models\MembershipApplication;
use App\Models\MembershipTier;
use App\Models\MembershipType;
use Illuminate\Database\Seeder;

class MembershipApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $types = MembershipType::where('is_active', true)->get();
        $tiers = MembershipTier::where('is_active', true)->get();

        if ($types->isEmpty()) {
            return;
        }

        $applications = [
            ['full_name' => 'Tanvir Ahmed', 'email' => 'tanvir@example.com', 'phone' => '+8801711111111', 'student_id' => '2018-001', 'batch' => '2018', 'graduation_year' => 2022, 'status' => ApplicationStatus::Pending, 'application_message' => 'Excited to join as a general member.'],
            ['full_name' => 'Sabrina Rahman', 'email' => 'sabrina@example.com', 'phone' => '+8801722222222', 'student_id' => '2019-045', 'batch' => '2019', 'graduation_year' => 2023, 'status' => ApplicationStatus::UnderReview, 'admin_notes' => 'Documents under verification.'],
            ['full_name' => 'Imran Hossain', 'email' => 'imran@example.com', 'phone' => '+8801733333333', 'student_id' => '2017-012', 'batch' => '2017', 'graduation_year' => 2021, 'status' => ApplicationStatus::Approved, 'admin_notes' => 'All criteria met.', 'reviewed_at' => now()->subDays(5)],
            ['full_name' => 'Fatima Begum', 'email' => 'fatima@example.com', 'phone' => '+8801744444444', 'student_id' => '2020-078', 'batch' => '2020', 'graduation_year' => 2024, 'status' => ApplicationStatus::Rejected, 'rejection_reason' => 'Incomplete graduation documentation.', 'reviewed_at' => now()->subDays(3)],
            ['full_name' => 'Kamal Uddin', 'email' => 'kamal@example.com', 'phone' => '+8801755555555', 'student_id' => '2016-033', 'batch' => '2016', 'graduation_year' => 2020, 'status' => ApplicationStatus::ChangesRequested, 'admin_notes' => 'Please update your current organization details.'],
            ['full_name' => 'Nadia Karim', 'email' => 'nadia@example.com', 'phone' => '+8801766666666', 'current_organization' => 'ABC Corp', 'profession' => 'Software Engineer', 'current_designation' => 'Senior Developer', 'status' => ApplicationStatus::Pending, 'application_message' => 'Looking forward to reconnecting with fellow alumni.'],
            ['full_name' => 'Rafiq Chowdhury', 'email' => 'rafiq@example.com', 'phone' => '+8801777777777', 'student_id' => '2015-019', 'batch' => '2015', 'graduation_year' => 2019, 'status' => ApplicationStatus::Pending, 'application_message' => 'Would like to contribute to alumni activities.'],
        ];

        foreach ($applications as $index => $data) {
            $type = $types->random();
            $data['membership_type_id'] = $type->id;

            if ($tiers->isNotEmpty() && ($index % 3 === 0)) {
                $data['requested_tier_id'] = $tiers->random()->id;
            }

            MembershipApplication::create($data);
        }
    }
}
