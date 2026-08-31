<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ExpenseStatus;
use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search'));
        $categoryId = $request->query('category_id');
        $status = $request->query('status');
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');

        $query = Expense::query()
            ->with(['category', 'recordedBy'])
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('expense_number', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%")
                    ->orWhereHas('category', fn ($q) => $q->where('name', 'like', "%{$search}%"));
            }))
            ->when($categoryId, fn ($query, $value) => $query->forCategory((int) $value))
            ->when($status, fn ($query, $value) => $query->where('status', $value))
            ->when($dateFrom, fn ($query, $value) => $query->whereDate('expense_date', '>=', $value))
            ->when($dateTo, fn ($query, $value) => $query->whereDate('expense_date', '<=', $value));

        // Administrative totals honour the active filters but always exclude
        // void records from spent funds.
        $totals = (clone $query)->valid()->toBase()
            ->selectRaw('COUNT(*) as count, COALESCE(SUM(amount), 0) as total')
            ->first();

        $expenses = $query->orderByDesc('expense_date')->orderByDesc('id')->paginate(15)->withQueryString();

        return view('admin.expenses.index', [
            'expenses' => $expenses,
            'filters' => [
                'search' => $search,
                'category_id' => $categoryId,
                'status' => $status,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
            ],
            'totalSpent' => (float) ($totals->total ?? 0),
            'validCount' => (int) ($totals->count ?? 0),
            'statuses' => ExpenseStatus::cases(),
            'categories' => ExpenseCategory::query()->ordered()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.expenses.create', [
            'categories' => ExpenseCategory::query()->active()->ordered()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->storeRules());

        $expense = Expense::create([
            ...$validated,
            'expense_number' => Expense::generateExpenseNumber(),
            // Server-controlled financial fields: new expenses are recorded,
            // never void, and always attributed to the authenticated admin.
            'status' => ExpenseStatus::Recorded->value,
            'recorded_by' => $request->user()->id,
        ]);

        return redirect()
            ->route('admin.expenses.show', $expense)
            ->with('status', "Expense {$expense->expense_number} recorded.");
    }

    public function show(Expense $expense)
    {
        return view('admin.expenses.show', [
            'expense' => $expense->load(['category', 'recordedBy', 'voidedBy']),
        ]);
    }

    public function edit(Expense $expense)
    {
        abort_if($expense->status === ExpenseStatus::Void, 403, 'Voided expenses cannot be edited.');

        return view('admin.expenses.edit', [
            'expense' => $expense->load('category'),
            // Active categories plus the expense's current (possibly
            // deactivated) category, so history is never broken.
            'categories' => ExpenseCategory::query()
                ->where(fn ($q) => $q->where('is_active', true)->orWhere('id', $expense->expense_category_id))
                ->ordered()
                ->get(),
        ]);
    }

    public function update(Request $request, Expense $expense)
    {
        abort_if($expense->status === ExpenseStatus::Void, 403, 'Voided expenses cannot be edited.');

        $validated = $request->validate($this->updateRules($expense));

        // The expense number, status, and recorded_by are permanent
        // financial identifiers — never editable. Void + re-record instead.
        unset($validated['status'], $validated['recorded_by'], $validated['expense_number']);

        $expense->update($validated);

        return redirect()
            ->route('admin.expenses.show', $expense)
            ->with('status', "Expense {$expense->expense_number} updated.");
    }

    /**
     * Audit-safe invalidation: never hard-delete financial history.
     */
    public function void(Request $request, Expense $expense)
    {
        if ($expense->status === ExpenseStatus::Void) {
            return redirect()
                ->route('admin.expenses.show', $expense)
                ->with('warning', "Expense {$expense->expense_number} is already void.");
        }

        $validated = $request->validate([
            'void_reason' => ['required', 'string', 'min:5', 'max:1000'],
        ]);

        $expense->forceFill([
            'status' => ExpenseStatus::Void->value,
            'voided_at' => now(),
            'voided_by' => $request->user()->id,
            'void_reason' => $validated['void_reason'],
        ])->save();

        return redirect()
            ->route('admin.expenses.show', $expense)
            ->with('status', "Expense {$expense->expense_number} voided. The record is retained for audit purposes.");
    }

    /**
     * Validation rules for creating a new expense. Only active categories
     * may receive new expenses.
     *
     * @return array<string, mixed>
     */
    protected function storeRules(): array
    {
        return [
            'expense_category_id' => [
                'required', 'integer',
                Rule::exists('expense_categories', 'id')->where('is_active', true),
            ],
            ...$this->sharedRules(),
        ];
    }

    /**
     * Validation rules for editing. The expense's current category remains
     * valid even if it has since been deactivated (historical integrity).
     *
     * @return array<string, mixed>
     */
    protected function updateRules(Expense $expense): array
    {
        return [
            'expense_category_id' => [
                'required', 'integer',
                Rule::exists('expense_categories', 'id')->where(
                    fn ($q) => $q->where('is_active', true)->orWhere('id', $expense->expense_category_id)
                ),
            ],
            ...$this->sharedRules(),
        ];
    }

    /**
     * Validation rules shared by store and update.
     *
     * @return array<string, mixed>
     */
    protected function sharedRules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'expense_date' => ['required', 'date', 'before_or_equal:today'],
            'reference' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
