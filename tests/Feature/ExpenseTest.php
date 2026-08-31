<?php

namespace Tests\Feature;

use App\Enums\ExpenseStatus;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->actingAs($this->admin);
    }

    protected function makeCategory(array $attributes = []): ExpenseCategory
    {
        return ExpenseCategory::factory()->active()->create($attributes);
    }

    protected function validPayload(array $overrides = []): array
    {
        $category = $overrides['category'] ?? $this->makeCategory();
        unset($overrides['category']);

        return array_merge([
            'expense_category_id' => $category->id,
            'title' => 'Annual reunion venue booking',
            'amount' => '1000',
            'expense_date' => now()->toDateString(),
            'reference' => 'Voucher 2026-011',
            'description' => 'Auditorium rent and decoration.',
        ], $overrides);
    }

    // ──────────────────────────────────────────
    // AUTHORIZATION
    // ──────────────────────────────────────────

    public function test_guest_is_redirected_to_login(): void
    {
        auth()->logout();

        $expense = Expense::factory()->create();
        $category = $this->makeCategory();

        $this->get(route('admin.finance.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.expenses.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.expenses.create'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.expenses.show', $expense))->assertRedirect(route('admin.login'));
        $this->get(route('admin.expenses.edit', $expense))->assertRedirect(route('admin.login'));
        $this->post(route('admin.expenses.void', $expense), ['void_reason' => 'duplicate entry'])->assertRedirect(route('admin.login'));
        $this->get(route('admin.expense-categories.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.expense-categories.create'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.expense-categories.edit', $category))->assertRedirect(route('admin.login'));
    }

    public function test_non_admin_receives_403(): void
    {
        $this->actingAs(User::factory()->create());

        $expense = Expense::factory()->create();
        $category = $this->makeCategory();

        $this->get(route('admin.finance.index'))->assertForbidden();
        $this->get(route('admin.expenses.index'))->assertForbidden();
        $this->post(route('admin.expenses.store'), $this->validPayload())->assertForbidden();
        $this->put(route('admin.expenses.update', $expense), $this->validPayload())->assertForbidden();
        $this->post(route('admin.expenses.void', $expense), ['void_reason' => 'duplicate entry'])->assertForbidden();
        $this->get(route('admin.expense-categories.index'))->assertForbidden();
        $this->post(route('admin.expense-categories.store'), ['name' => 'Testing'])->assertForbidden();
        $this->delete(route('admin.expense-categories.destroy', $category))->assertForbidden();
    }

    public function test_admin_can_access_all_finance_pages(): void
    {
        $expense = Expense::factory()->create();
        $category = $this->makeCategory();

        $this->get(route('admin.finance.index'))->assertOk();
        $this->get(route('admin.expenses.index'))->assertOk();
        $this->get(route('admin.expenses.create'))->assertOk();
        $this->get(route('admin.expenses.show', $expense))->assertOk();
        $this->get(route('admin.expenses.edit', $expense))->assertOk();
        $this->get(route('admin.expense-categories.index'))->assertOk();
        $this->get(route('admin.expense-categories.create'))->assertOk();
        $this->get(route('admin.expense-categories.edit', $category))->assertOk();
    }

    // ──────────────────────────────────────────
    // DATABASE / RELATIONSHIPS
    // ──────────────────────────────────────────

    public function test_expense_tables_exist_with_expected_columns(): void
    {
        foreach (['id', 'name', 'slug', 'description', 'is_active', 'sort_order'] as $column) {
            $this->assertTrue(\Schema::hasColumn('expense_categories', $column), "Missing column {$column}");
        }

        foreach (['id', 'expense_category_id', 'expense_number', 'amount', 'currency', 'status', 'expense_date', 'title', 'description', 'reference', 'recorded_by', 'voided_at', 'voided_by', 'void_reason'] as $column) {
            $this->assertTrue(\Schema::hasColumn('expenses', $column), "Missing column {$column}");
        }
    }

    public function test_expense_relationships_work(): void
    {
        $category = $this->makeCategory(['name' => 'Welfare Activities']);
        $expense = Expense::factory()->forCategory($category)->create(['recorded_by' => $this->admin->id]);

        $this->assertTrue($expense->category->is($category));
        $this->assertTrue($category->expenses->first()->is($expense));
        $this->assertNotNull($expense->recordedBy);
        $this->assertTrue($expense->recordedBy->is($this->admin));
    }

    public function test_expense_number_is_unique_at_database_level(): void
    {
        $expense = Expense::factory()->create();

        $this->expectException(UniqueConstraintViolationException::class);

        Expense::create([
            'expense_category_id' => $expense->expense_category_id,
            'expense_number' => $expense->expense_number,
            'amount' => 100,
            'currency' => 'BDT',
            'status' => ExpenseStatus::Recorded->value,
            'expense_date' => now()->toDateString(),
            'title' => 'Duplicate number attempt',
            'recorded_by' => $this->admin->id,
        ]);
    }

    public function test_deleting_category_with_expenses_is_restricted(): void
    {
        $category = $this->makeCategory();
        Expense::factory()->forCategory($category)->create();

        $this->expectException(QueryException::class);

        $category->delete();
    }

    // ──────────────────────────────────────────
    // CATEGORY MANAGEMENT
    // ──────────────────────────────────────────

    public function test_category_index_lists_categories(): void
    {
        $this->makeCategory(['name' => 'Events & Programs']);

        $response = $this->get(route('admin.expense-categories.index'));

        $response->assertOk()->assertSee('Events & Programs');
        $this->assertSame(1, $response->viewData('categories')->total());
    }

    public function test_category_store_creates_category_with_generated_slug(): void
    {
        $this->post(route('admin.expense-categories.store'), [
            'name' => 'Humanitarian Activities',
            'description' => 'Relief and support work.',
            'sort_order' => '15',
            'is_active' => '1',
        ])->assertRedirect(route('admin.expense-categories.index'));

        $category = ExpenseCategory::query()->where('name', 'Humanitarian Activities')->firstOrFail();
        $this->assertSame('humanitarian-activities', $category->slug);
        $this->assertTrue($category->is_active);
        $this->assertSame(15, $category->sort_order);
    }

    public function test_category_store_validates_input(): void
    {
        $this->post(route('admin.expense-categories.store'), [])->assertInvalid(['name']);
        $this->post(route('admin.expense-categories.store'), ['name' => str_repeat('a', 256)])->assertInvalid(['name']);
    }

    public function test_category_update_renames_and_regenerates_slug(): void
    {
        $category = $this->makeCategory(['name' => 'Old Name']);

        $this->put(route('admin.expense-categories.update', $category), [
            'name' => 'New Name',
            'description' => 'Updated description.',
            'sort_order' => '5',
        ])->assertRedirect(route('admin.expense-categories.index'));

        $category->refresh();
        $this->assertSame('New Name', $category->name);
        $this->assertSame('new-name', $category->slug);
        $this->assertSame(5, $category->sort_order);
    }

    public function test_category_can_be_deactivated(): void
    {
        $category = $this->makeCategory();

        $this->put(route('admin.expense-categories.update', $category), [
            'name' => $category->name,
            'is_active' => '0',
        ])->assertRedirect(route('admin.expense-categories.index'));

        $this->assertFalse($category->refresh()->is_active);
    }

    public function test_unused_category_can_be_deleted(): void
    {
        $category = $this->makeCategory();

        $this->delete(route('admin.expense-categories.destroy', $category))
            ->assertRedirect(route('admin.expense-categories.index'))
            ->assertSessionHas('status');

        $this->assertDatabaseMissing('expense_categories', ['id' => $category->id]);
    }

    public function test_used_category_cannot_be_deleted(): void
    {
        $category = $this->makeCategory(['name' => 'Events & Programs']);
        Expense::factory()->forCategory($category)->create();

        $this->delete(route('admin.expense-categories.destroy', $category))
            ->assertRedirect(route('admin.expense-categories.index'))
            ->assertSessionHas('warning', 'This category cannot be deleted because expenses are assigned to it. Deactivate it instead.');

        $this->assertDatabaseHas('expense_categories', ['id' => $category->id]);
    }

    public function test_inactive_category_is_unavailable_for_new_expenses(): void
    {
        $inactive = $this->makeCategory(['name' => 'Retired Category']);
        $inactive->update(['is_active' => false]);
        $active = $this->makeCategory(['name' => 'Live Category']);

        $response = $this->get(route('admin.expenses.create'));
        $response->assertOk();
        $this->assertFalse($response->viewData('categories')->contains('id', $inactive->id));
        $this->assertTrue($response->viewData('categories')->contains('id', $active->id));

        $this->post(route('admin.expenses.store'), $this->validPayload([
            'expense_category_id' => $inactive->id,
        ]))->assertInvalid(['expense_category_id']);
    }

    // ──────────────────────────────────────────
    // EXPENSE CRUD
    // ──────────────────────────────────────────

    public function test_expense_store_creates_recorded_expense_with_number_and_recorder(): void
    {
        $response = $this->post(route('admin.expenses.store'), $this->validPayload([
            'recorded_by' => 999999, // must be ignored — server controlled
            'status' => 'void', // must be ignored — server controlled
        ]));

        $expense = Expense::query()->firstOrFail();

        $response->assertRedirect(route('admin.expenses.show', $expense));
        $this->assertSame('EDAA-EXP-000001', $expense->expense_number);
        $this->assertSame(ExpenseStatus::Recorded, $expense->status);
        $this->assertTrue($expense->recordedBy->is($this->admin));
        $this->assertNull($expense->voided_at);
        $this->assertSame('1000.00', (string) $expense->amount);
    }

    public function test_expense_show_displays_details(): void
    {
        $expense = Expense::factory()->create(['title' => 'Book bank purchase', 'recorded_by' => $this->admin->id]);

        $this->get(route('admin.expenses.show', $expense))
            ->assertOk()
            ->assertSee($expense->expense_number)
            ->assertSee('Book bank purchase')
            ->assertSee($expense->category->name)
            ->assertSee($this->admin->name);
    }

    public function test_expense_update_changes_editable_fields_but_not_number_or_recorder(): void
    {
        $expense = Expense::factory()->create(['recorded_by' => $this->admin->id]);
        $newCategory = $this->makeCategory();
        $originalNumber = $expense->expense_number;

        $this->put(route('admin.expenses.update', $expense), $this->validPayload([
            'expense_category_id' => $newCategory->id,
            'title' => 'Updated title',
            'amount' => '2500.50',
        ]))->assertRedirect(route('admin.expenses.show', $expense));

        $expense->refresh();
        $this->assertSame('Updated title', $expense->title);
        $this->assertSame('2500.50', (string) $expense->amount);
        $this->assertSame($newCategory->id, $expense->expense_category_id);
        $this->assertSame($originalNumber, $expense->expense_number);
        $this->assertTrue($expense->recordedBy->is($this->admin));
        $this->assertSame(ExpenseStatus::Recorded, $expense->status);
    }

    public function test_expense_index_shows_list_and_totals(): void
    {
        Expense::factory()->count(2)->create(['amount' => 500]);
        Expense::factory()->voided()->create(['amount' => 999]);

        $response = $this->get(route('admin.expenses.index'));

        $response->assertOk();
        // The listing shows every record (including void), but the totals
        // only count recorded (valid) expenses.
        $this->assertSame(3, $response->viewData('expenses')->total());
        $this->assertSame(1000.0, $response->viewData('totalSpent'));
        $this->assertSame(2, $response->viewData('validCount'));
    }

    public function test_expense_index_search_matches_number_title_reference_and_category(): void
    {
        $category = $this->makeCategory(['name' => 'Transportation']);
        $byNumber = Expense::factory()->create(['title' => 'Venue rent']);
        $byTitle = Expense::factory()->create(['title' => 'Unique welfare blankets']);
        $byReference = Expense::factory()->create(['title' => 'Supplies', 'reference' => 'REC-777']);
        $byCategory = Expense::factory()->forCategory($category)->create(['title' => 'Bus hire']);

        $cases = [
            [$byNumber->expense_number, $byNumber],
            ['Unique welfare', $byTitle],
            ['REC-777', $byReference],
            ['Transportation', $byCategory],
        ];

        foreach ($cases as [$term, $expected]) {
            $response = $this->get(route('admin.expenses.index', ['search' => $term]));
            $response->assertOk();
            $this->assertSame(1, $response->viewData('expenses')->total(), "Search '{$term}' failed");
            $this->assertTrue($response->viewData('expenses')->getCollection()->first()->is($expected));
        }
    }

    public function test_expense_index_filters_by_category_status_and_date_range(): void
    {
        $events = $this->makeCategory(['name' => 'Events A']);
        $office = $this->makeCategory(['name' => 'Office B']);

        $inRange = Expense::factory()->forCategory($events)->create([
            'expense_date' => now()->subDays(5)->toDateString(),
        ]);
        Expense::factory()->forCategory($office)->create([
            'expense_date' => now()->subDays(40)->toDateString(),
        ]);
        Expense::factory()->forCategory($office)->voided()->create([
            'expense_date' => now()->subDays(45)->toDateString(),
        ]);

        $byCategory = $this->get(route('admin.expenses.index', ['category_id' => $events->id]));
        $byCategory->assertOk();
        $this->assertSame(1, $byCategory->viewData('expenses')->total());

        $byStatus = $this->get(route('admin.expenses.index', ['status' => 'void']));
        $byStatus->assertOk();
        $this->assertSame(1, $byStatus->viewData('expenses')->total());

        $byDate = $this->get(route('admin.expenses.index', [
            'date_from' => now()->subDays(7)->toDateString(),
            'date_to' => now()->toDateString(),
        ]));
        $byDate->assertOk();
        $this->assertSame(1, $byDate->viewData('expenses')->total());
        $this->assertTrue($byDate->viewData('expenses')->getCollection()->first()->is($inRange));
    }

    public function test_expense_index_paginates(): void
    {
        Expense::factory()->count(20)->create();

        $page1 = $this->get(route('admin.expenses.index'));
        $page1->assertOk();
        $this->assertSame(15, $page1->viewData('expenses')->count());
        $this->assertSame(20, $page1->viewData('expenses')->total());

        $page2 = $this->get(route('admin.expenses.index', ['page' => 2]));
        $page2->assertOk();
        $this->assertSame(5, $page2->viewData('expenses')->count());
    }

    public function test_expense_index_shows_empty_state_when_no_expenses(): void
    {
        $this->get(route('admin.expenses.index'))
            ->assertOk()
            ->assertSee('No expenses found');
    }

    // ──────────────────────────────────────────
    // EXPENSE VALIDATION
    // ──────────────────────────────────────────

    public function test_expense_store_validates_required_and_bounds(): void
    {
        $this->post(route('admin.expenses.store'), [])->assertInvalid([
            'expense_category_id', 'title', 'amount', 'expense_date',
        ]);

        $this->post(route('admin.expenses.store'), $this->validPayload([
            'expense_category_id' => 999999,
        ]))->assertInvalid(['expense_category_id']);

        $this->post(route('admin.expenses.store'), $this->validPayload(['title' => str_repeat('a', 256)]))
            ->assertInvalid(['title']);

        $this->post(route('admin.expenses.store'), $this->validPayload(['amount' => '-10']))
            ->assertInvalid(['amount']);

        $this->post(route('admin.expenses.store'), $this->validPayload(['amount' => 'abc']))
            ->assertInvalid(['amount']);

        $this->post(route('admin.expenses.store'), $this->validPayload(['expense_date' => now()->addDay()->toDateString()]))
            ->assertInvalid(['expense_date']);

        $this->post(route('admin.expenses.store'), $this->validPayload(['reference' => str_repeat('a', 256)]))
            ->assertInvalid(['reference']);

        $this->post(route('admin.expenses.store'), $this->validPayload(['description' => str_repeat('a', 2001)]))
            ->assertInvalid(['description']);
    }

    // ──────────────────────────────────────────
    // EXPENSE NUMBER
    // ──────────────────────────────────────────

    public function test_expense_numbers_generate_sequentially_and_are_stable(): void
    {
        $first = Expense::factory()->create();
        $second = Expense::factory()->create();

        $this->assertSame('EDAA-EXP-000001', $first->expense_number);
        $this->assertSame('EDAA-EXP-000002', $second->expense_number);

        $originalNumber = $second->expense_number;
        $second->update(['title' => 'Renamed after creation']);
        $this->assertSame($originalNumber, $second->refresh()->expense_number);
    }

    public function test_voided_expense_numbers_are_never_recycled(): void
    {
        $voided = Expense::factory()->create();
        $voided->forceFill([
            'status' => ExpenseStatus::Void->value,
            'voided_at' => now(),
            'voided_by' => $this->admin->id,
            'void_reason' => 'Duplicate entry.',
        ])->save();

        $next = Expense::factory()->create();

        $this->assertNotSame($voided->expense_number, $next->expense_number);
        $this->assertSame('EDAA-EXP-000002', $next->expense_number);
        $this->assertDatabaseHas('expenses', ['expense_number' => $voided->expense_number]);
    }

    // ──────────────────────────────────────────
    // VOID
    // ──────────────────────────────────────────

    public function test_void_requires_reason(): void
    {
        $expense = Expense::factory()->create();

        $this->post(route('admin.expenses.void', $expense), [])->assertInvalid(['void_reason']);
        $this->post(route('admin.expenses.void', $expense), ['void_reason' => 'abc'])->assertInvalid(['void_reason']);

        $expense->refresh();
        $this->assertNotSame(ExpenseStatus::Void, $expense->status);
    }

    public function test_void_stamps_audit_fields_and_retains_record(): void
    {
        $expense = Expense::factory()->create();

        $this->post(route('admin.expenses.void', $expense), ['void_reason' => 'Duplicate entry recorded in error.'])
            ->assertRedirect(route('admin.expenses.show', $expense))
            ->assertSessionHas('status');

        $expense->refresh();
        $this->assertSame(ExpenseStatus::Void, $expense->status);
        $this->assertNotNull($expense->voided_at);
        $this->assertTrue($expense->voidedBy->is($this->admin));
        $this->assertSame('Duplicate entry recorded in error.', $expense->void_reason);

        // The record is retained — never deleted.
        $this->assertDatabaseHas('expenses', ['id' => $expense->id]);
    }

    public function test_voided_expense_is_excluded_from_total_expenses(): void
    {
        $expense = Expense::factory()->create(['amount' => 750]);

        $this->assertSame(750.0, (float) Expense::query()->valid()->sum('amount'));

        $this->post(route('admin.expenses.void', $expense), ['void_reason' => 'Entry created by mistake.']);

        $this->assertSame(0.0, (float) Expense::query()->valid()->sum('amount'));
    }

    public function test_voided_expense_cannot_be_edited(): void
    {
        $expense = Expense::factory()->voided()->create();

        $this->get(route('admin.expenses.edit', $expense))->assertForbidden();
        $this->put(route('admin.expenses.update', $expense), $this->validPayload())->assertForbidden();
    }

    public function test_voided_expense_cannot_be_voided_twice(): void
    {
        $expense = Expense::factory()->voided()->create();
        $originalVoidedAt = $expense->voided_at;

        $response = $this->post(route('admin.expenses.void', $expense), ['void_reason' => 'Second void attempt.']);

        $response->assertRedirect(route('admin.expenses.show', $expense))->assertSessionHas('warning');
        $expense->refresh();
        $this->assertSame($originalVoidedAt?->toString(), $expense->voided_at?->toString());
        $this->assertSame('Duplicate entry recorded during review.', $expense->void_reason);
    }

    // ──────────────────────────────────────────
    // AUDIT
    // ──────────────────────────────────────────

    public function test_audit_trail_is_preserved(): void
    {
        $expense = Expense::factory()->create(['recorded_by' => $this->admin->id]);

        $this->assertTrue($expense->recordedBy->is($this->admin));
        $this->assertNotNull($expense->created_at);
        $this->assertNotNull($expense->updated_at);
        $this->assertNotNull($expense->expense_date);
        $this->assertMatchesRegularExpression('/^EDAA-EXP-\d{6}$/', $expense->expense_number);

        $this->post(route('admin.expenses.void', $expense), ['void_reason' => 'Audit trail verification.']);

        $expense->refresh();
        $this->assertNotNull($expense->voided_by);
        $this->assertNotNull($expense->voided_at);
        $this->assertSame('Audit trail verification.', $expense->void_reason);
    }
}
