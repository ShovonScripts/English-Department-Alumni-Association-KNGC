<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Default expense categories for the association. Idempotent: existing
     * categories are matched by slug and never duplicated.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Events & Programs', 'description' => 'Reunions, cultural programs, seminars, and department events.', 'sort_order' => 10],
            ['name' => 'Welfare Activities', 'description' => 'Association welfare initiatives for members and their families.', 'sort_order' => 20],
            ['name' => 'Student Support', 'description' => 'Support for current students: scholarships, book banks, and coaching.', 'sort_order' => 30],
            ['name' => 'Office & Administration', 'description' => 'Stationery, printing, registration fees, and administrative costs.', 'sort_order' => 40],
            ['name' => 'Publications', 'description' => 'Magazines, souvenirs, and other printed publications.', 'sort_order' => 50],
            ['name' => 'Media & Communication', 'description' => 'Website hosting, photography, and communication expenses.', 'sort_order' => 60],
            ['name' => 'Transportation', 'description' => 'Travel and transport costs for association activities.', 'sort_order' => 70],
            ['name' => 'Refreshments', 'description' => 'Food and refreshments for meetings and events.', 'sort_order' => 80],
            ['name' => 'Humanitarian Activities', 'description' => 'Relief and humanitarian support in the community.', 'sort_order' => 90],
            ['name' => 'Other', 'description' => 'Expenses that do not fit a defined category.', 'sort_order' => 100],
        ];

        foreach ($categories as $category) {
            ExpenseCategory::query()->updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'is_active' => true,
                    'sort_order' => $category['sort_order'],
                ]
            );
        }
    }
}
