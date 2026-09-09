<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ExpenseCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Events & Programs', 'description' => 'Expenses related to alumni events, reunions, seminars and cultural programs.', 'sort_order' => 1],
            ['name' => 'Welfare Activities', 'description' => 'Community welfare, charity and social responsibility initiatives.', 'sort_order' => 2],
            ['name' => 'Administrative Costs', 'description' => 'Office supplies, printing, communication and general administration.', 'sort_order' => 3],
            ['name' => 'Marketing & Outreach', 'description' => 'Promotional materials, advertising and member recruitment campaigns.', 'sort_order' => 4],
            ['name' => 'Technology & Infrastructure', 'description' => 'Website hosting, software subscriptions and IT equipment.', 'sort_order' => 5],
            ['name' => 'Travel & Transportation', 'description' => 'Travel expenses for official association business and events.', 'sort_order' => 6],
            ['name' => 'Publications & Media', 'description' => 'Printing costs for journals, magazines and press materials.', 'sort_order' => 7],
            ['name' => 'Training & Development', 'description' => 'Workshops, skill-building sessions and professional development.', 'sort_order' => 8],
            ['name' => 'Donations & Grants', 'description' => 'Charitable donations and grant disbursements.', 'sort_order' => 9],
            ['name' => 'Miscellaneous', 'description' => 'Other expenses not categorized elsewhere.', 'sort_order' => 10],
        ];

        foreach ($categories as $category) {
            ExpenseCategory::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                array_merge($category, ['is_active' => true])
            );
        }
    }
}
