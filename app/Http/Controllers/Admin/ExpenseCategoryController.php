<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        return view('admin.expense-categories.index', [
            // All categories — including inactive ones — remain visible so
            // historical expenses stay traceable.
            'categories' => ExpenseCategory::query()
                ->withCount('expenses')
                ->ordered()
                ->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.expense-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $validated['slug'] = ExpenseCategory::uniqueSlug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        ExpenseCategory::create($validated);

        return redirect()->route('admin.expense-categories.index')
            ->with('status', 'Expense category created.');
    }

    public function edit(ExpenseCategory $expenseCategory)
    {
        return view('admin.expense-categories.edit', ['category' => $expenseCategory]);
    }

    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        $validated = $request->validate($this->rules());

        $validated['slug'] = ExpenseCategory::uniqueSlug($validated['name'], $expenseCategory->id);
        $validated['is_active'] = $request->boolean('is_active');

        $expenseCategory->update($validated);

        return redirect()->route('admin.expense-categories.index')
            ->with('status', 'Expense category updated.');
    }

    /**
     * Categories with assigned expenses are never deleted — deactivation
     * preserves the financial history of every past expense.
     */
    public function destroy(ExpenseCategory $expenseCategory)
    {
        if ($expenseCategory->expenses()->exists()) {
            return redirect()->route('admin.expense-categories.index')
                ->with('warning', 'This category cannot be deleted because expenses are assigned to it. Deactivate it instead.');
        }

        $expenseCategory->delete();

        return redirect()->route('admin.expense-categories.index')
            ->with('status', 'Expense category deleted.');
    }

    /**
     * Validation rules shared by store and update.
     *
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ];
    }
}
