<?php

namespace Database\Seeders;

use App\Enums\ExpenseStatus;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('is_admin', true)->first()
            ?? User::factory()->admin()->create();

        $categories = ExpenseCategory::query()->pluck('id');

        if ($categories->isEmpty()) {
            return;
        }

        $expenses = [
            ['title' => 'Annual Reunion Venue Rental', 'amount' => 5000.00, 'status' => ExpenseStatus::Recorded->value, 'category_index' => 0],
            ['title' => 'Community Library Setup', 'amount' => 3000.00, 'status' => ExpenseStatus::Recorded->value, 'category_index' => 1],
            ['title' => 'Office Stationery & Printing', 'amount' => 2500.00, 'status' => ExpenseStatus::Recorded->value, 'category_index' => 2],
            ['title' => 'Social Media Campaign', 'amount' => 1500.00, 'status' => ExpenseStatus::Recorded->value, 'category_index' => 3],
            ['title' => 'Cancelled Conference Booking', 'amount' => 8000.00, 'status' => ExpenseStatus::Void->value, 'category_index' => 0],
        ];

        foreach ($expenses as $expense) {
            $categoryIndex = $expense['category_index'] % $categories->count();

            Expense::updateOrCreate(
                ['title' => $expense['title']],
                [
                    'expense_category_id' => $categories[$categoryIndex],
                    'amount' => $expense['amount'],
                    'currency' => 'BDT',
                    'status' => $expense['status'],
                    'expense_date' => now()->subDays(rand(1, 60))->toDateString(),
                    'recorded_by' => $admin->id,
                    'reference' => 'EXP-REF-' . str_pad((string) array_search($expense, $expenses) + 1, 3, '0', STR_PAD_LEFT),
                ]
            );
        }
    }
}
