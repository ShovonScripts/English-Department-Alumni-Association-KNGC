<x-layouts.admin title="Expenses">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Expenses</h1>
            <p class="mt-1 text-sm text-ink-soft">
                Association spending records. Expenses are never deleted — void them for audit safety.
            </p>
        </div>
        <x-button href="{{ route('admin.expenses.create') }}" variant="gold">Record Expense</x-button>
    </div>

    @if (session('status'))
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            {{ session('status') }}
        </div>
    @endif

    @if (session('warning'))
        <div class="mb-6 flex items-center gap-3 rounded-md border border-gold-500/50 bg-gold-500/10 px-4 py-3 text-sm text-gold-700" role="alert">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.9L1.8 18a2 2 0 001.7 3h17a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z" />
            </svg>
            {{ session('warning') }}
        </div>
    @endif

    {{-- Spending totals --}}
    <div class="mb-8 grid gap-5 sm:grid-cols-2">
        <div class="rounded-lg border border-maroon-200 bg-maroon-50 p-6">
            <p class="text-sm font-medium uppercase tracking-wider text-maroon-700">Total Spent</p>
            <p class="mt-2 font-serif text-4xl font-semibold tracking-tight text-maroon-800">{{ \App\Services\FinanceService::formatBalance($totalSpent) }}</p>
            <p class="mt-1 text-xs text-maroon-600">Recorded expenses matching current filters. Void excluded.</p>
        </div>
        <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium uppercase tracking-wider text-ink-soft">Valid Expenses</p>
            <p class="mt-2 font-serif text-4xl font-semibold tracking-tight text-navy-950">{{ number_format($validCount) }}</p>
            <p class="mt-1 text-xs text-ink-soft">Void records are retained for audit but never counted.</p>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.expenses.index') }}" class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-6">
            <div class="lg:col-span-2">
                <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                <input
                    type="search"
                    id="search"
                    name="search"
                    value="{{ $filters['search'] }}"
                    placeholder="Expense #, title, reference, category…"
                    class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"
                >
            </div>

            <div>
                <label for="category_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</label>
                <select id="category_id" name="category_id" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected($filters['category_id'] == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</label>
                <select id="status" name="status" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All statuses</option>
                    @foreach ($statuses as $expenseStatus)
                        <option value="{{ $expenseStatus->value }}" @selected($filters['status'] === $expenseStatus->value)>{{ $expenseStatus->label() }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="date_from" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">From</label>
                <input type="date" id="date_from" name="date_from" value="{{ $filters['date_from'] }}" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
            </div>

            <div>
                <label for="date_to" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">To</label>
                <input type="date" id="date_to" name="date_to" value="{{ $filters['date_to'] }}" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
            </div>
        </div>

        <div class="mt-4 flex flex-wrap items-center gap-3">
            <x-button type="submit" variant="navy" size="sm">Apply Filters</x-button>
            <a href="{{ route('admin.expenses.index') }}" class="focus-ring rounded text-sm font-semibold text-maroon-700 hover:underline">Clear</a>
        </div>
    </form>

    @if ($expenses->count())
        <div class="mt-8 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-navy-100 text-sm">
                    <thead class="bg-cream">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Expense #</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Title</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</th>
                            <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-ink-soft">Amount</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Date</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Recorded By</th>
                            <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-ink-soft"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-navy-50">
                        @foreach ($expenses as $expense)
                            <tr class="transition-colors hover:bg-cream/60">
                                <td class="whitespace-nowrap px-6 py-4 font-mono text-xs font-semibold text-navy-900">{{ $expense->expense_number }}</td>
                                <td class="px-6 py-4 font-medium text-navy-950">{{ $expense->title }}</td>
                                <td class="px-6 py-4 text-ink-soft">{{ $expense->category?->name ?? '—' }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-right font-semibold {{ $expense->status->isVoid() ? 'text-maroon-400 line-through' : 'text-navy-950' }}">{{ $expense->formattedAmount() }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-ink-soft">{{ $expense->expense_date?->format('M j, Y') }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $styles = [
                                            'recorded' => ['bg-emerald-100', 'text-emerald-800'],
                                            'void' => ['bg-maroon-100', 'text-maroon-800'],
                                        ];
                                        [$bg, $text] = $styles[$expense->status->value] ?? ['bg-navy-100', 'text-navy-600'];
                                    @endphp
                                    <span class="inline-flex rounded-full {{ $bg }} px-2.5 py-1 text-xs font-bold uppercase tracking-wide {{ $text }}">{{ $expense->status->label() }}</span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-ink-soft">{{ $expense->recordedBy?->name ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.expenses.show', $expense) }}" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900" aria-label="View {{ $expense->expense_number }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12z" />
                                            </svg>
                                        </a>
                                        @unless ($expense->status->isVoid())
                                            <a href="{{ route('admin.expenses.edit', $expense) }}" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900" aria-label="Edit {{ $expense->expense_number }}">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2 2 0 112.8 2.8L11 15l-4 1 1-4 9.6-9.4z" />
                                                </svg>
                                            </a>
                                        @endunless
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-navy-100 px-6 py-4">
                {{ $expenses->links() }}
            </div>
        </div>
    @else
        <div class="mt-8">
            <x-empty-state
                title="No expenses found"
                description="No expense records match your current filters. Adjust the filters or record a new association expense."
                action_label="Record Expense"
                action_href="{{ route('admin.expenses.create') }}"
            />
        </div>
    @endif
</x-layouts.admin>
