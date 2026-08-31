<?php

namespace Database\Seeders;

use App\Enums\ExpenseStatus;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Seed realistic association expenses across the default categories.
     *
     * Idempotent: skipped entirely once any expense exists. Amounts are
     * modest, welfare-oriented association figures — never commercial
     * values. Every record is audit-complete (recorded_by, dates).
     */
    public function run(): void
    {
        if (Expense::exists()) {
            return;
        }

        $admin = User::query()->where('is_admin', true)->orderBy('id')->first();

        if ($admin === null) {
            return;
        }

        $categories = ExpenseCategory::query()->get()->keyBy('slug');

        $category = fn (string $slug) => $categories->get($slug)
            ?? ExpenseCategory::query()->where('slug', $slug)->first();

        $record = function (array $attributes) use ($admin) {
            Expense::create(array_merge([
                'currency' => 'BDT',
                'status' => ExpenseStatus::Recorded->value,
                'expense_number' => Expense::generateExpenseNumber(),
                'recorded_by' => $admin->id,
            ], $attributes));
        };

        // Annual reunion venue and logistics.
        if ($events = $category('events-programs')) {
            $record([
                'expense_category_id' => $events->id,
                'amount' => 5000,
                'expense_date' => now()->subMonths(2)->toDateString(),
                'title' => 'Annual reunion venue booking',
                'description' => 'Auditorium rent and basic decoration for the annual reunion.',
                'reference' => 'Voucher 2026-011',
            ]);
        }

        // Student support stipend.
        if ($students = $category('student-support')) {
            $record([
                'expense_category_id' => $students->id,
                'amount' => 3000,
                'expense_date' => now()->subMonth()->toDateString(),
                'title' => 'Student book bank replenishment',
                'description' => 'Reference books purchased for the departmental book bank.',
                'reference' => null,
            ]);
        }

        // Welfare activity.
        if ($welfare = $category('welfare-activities')) {
            $record([
                'expense_category_id' => $welfare->id,
                'amount' => 2500,
                'expense_date' => now()->subDays(20)->toDateString(),
                'title' => 'Winter welfare distribution',
                'description' => 'Blankets distributed among families in need near the campus.',
                'reference' => 'Voucher 2026-019',
            ]);
        }

        // Office & administration.
        if ($office = $category('office-administration')) {
            $record([
                'expense_category_id' => $office->id,
                'amount' => 1500,
                'expense_date' => now()->subDays(10)->toDateString(),
                'title' => 'Stationery and printing',
                'description' => 'Letterheads, receipts, and meeting notices.',
                'reference' => null,
            ]);
        }

        // Void expense — retained for audit, excluded from every total.
        if ($events !== null) {
            Expense::create([
                'expense_category_id' => $events->id,
                'expense_number' => Expense::generateExpenseNumber(),
                'amount' => 1200,
                'currency' => 'BDT',
                'status' => ExpenseStatus::Void->value,
                'expense_date' => now()->subMonths(3)->toDateString(),
                'title' => 'Event banner (duplicate)',
                'description' => 'Duplicate record created during manual entry review.',
                'reference' => 'Voucher 2026-004',
                'recorded_by' => $admin->id,
                'voided_at' => now()->subMonths(3)->addDays(2),
                'voided_by' => $admin->id,
                'void_reason' => 'Duplicate entry — same purchase already recorded under Voucher 2026-003.',
            ]);
        }
    }
}
