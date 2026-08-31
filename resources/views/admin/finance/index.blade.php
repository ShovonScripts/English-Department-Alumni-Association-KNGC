<x-layouts.admin title="Finance">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Finance</h1>
            <p class="mt-1 text-sm text-ink-soft">
                Association funds overview — collections, expenses, and balance. Internal only; never shown publicly.
            </p>
        </div>

        {{-- Public Finance Toggle --}}
        <div class="flex items-center gap-4">
            <div class="inline-flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-3">
                <span class="text-sm font-medium text-navy-950">Public Finance</span>
                <form method="POST" action="{{ route('admin.finance.togglePublic') }}">
                    @csrf
                    <x-button
                        type="submit"
                        :variant="$publicEnabled ? 'emerald' : 'navy'"
                        size="sm"
                    >
                        {{ $publicEnabled ? 'Enabled' : 'Disabled' }}
                    </x-button>
                </form>
                <span class="text-xs text-ink-soft">
                    {{ $publicEnabled ? 'Aggregate data visible on /finance' : 'Public finance page is hidden' }}
                </span>
            </div>
            @if ($publicEnabled)
                <a href="{{ route('finance.public') }}" target="_blank" rel="noopener noreferrer" class="focus-ring inline-flex items-center gap-2 rounded-md px-3 py-2 text-sm font-semibold text-maroon-700 transition-colors hover:bg-maroon-50">
                    View Public Finance →
                </a>
            @endif
        </div>
    </div>

    {{-- Period selector --}}
    <form method="GET" action="{{ route('admin.finance.index') }}" class="mb-8 flex flex-wrap items-end gap-4 rounded-lg border border-navy-100 bg-white p-5 shadow-sm">
        <div>
            <label for="year" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Year</label>
            <select id="year" name="year" class="rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                @foreach ($availableYears as $availableYear)
                    <option value="{{ $availableYear }}" @selected($availableYear === $year)>{{ $availableYear }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="month" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Month (breakdown filter)</label>
            <select id="month" name="month" class="rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                <option value="">Whole year</option>
                @foreach (range(1, 12) as $m)
                    <option value="{{ $m }}" @selected($selectedMonth === $m)>{{ \Illuminate\Support\Carbon::create($year, $m, 1)->format('F') }}</option>
                @endforeach
            </select>
        </div>
        <x-button type="submit" variant="navy" size="sm">Apply</x-button>
    </form>

    {{-- 1. Financial overview --}}
    <section aria-labelledby="finance-overview">
        <h2 id="finance-overview" class="font-serif text-xl font-semibold text-navy-950">Financial Overview</h2>
        <div class="mt-4 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-6">
                <p class="text-sm font-medium uppercase tracking-wider text-emerald-700">Total Collections</p>
                <p class="mt-2 font-serif text-4xl font-semibold tracking-tight text-emerald-800">{{ \App\Services\FinanceService::formatBalance($totalCollections) }}</p>
                <p class="mt-1 text-xs text-emerald-600">{{ number_format($collectionCount) }} valid payment records · paid + partial only</p>
            </div>
            <div class="rounded-lg border border-maroon-200 bg-maroon-50 p-6">
                <p class="text-sm font-medium uppercase tracking-wider text-maroon-700">Total Expenses</p>
                <p class="mt-2 font-serif text-4xl font-semibold tracking-tight text-maroon-800">{{ \App\Services\FinanceService::formatBalance($totalExpenses) }}</p>
                <p class="mt-1 text-xs text-maroon-600">{{ number_format($expenseCount) }} recorded expenses · void excluded</p>
            </div>
            <div class="rounded-lg border border-navy-200 bg-white p-6 shadow-sm sm:col-span-2 lg:col-span-1">
                <p class="text-sm font-medium uppercase tracking-wider text-ink-soft">Current Balance</p>
                <p class="mt-2 font-serif text-4xl font-semibold tracking-tight {{ $currentBalance < 0 ? 'text-maroon-700' : 'text-navy-950' }}">{{ \App\Services\FinanceService::formatBalance($currentBalance) }}</p>
                <p class="mt-1 text-xs text-ink-soft">Total collections minus total expenses</p>
            </div>
        </div>
    </section>

    {{-- 2. Current month --}}
    <section class="mt-10" aria-labelledby="finance-current-month">
        <h2 id="finance-current-month" class="font-serif text-xl font-semibold text-navy-950">This Month — {{ now()->format('F Y') }}</h2>
        <div class="mt-4 grid gap-5 sm:grid-cols-3">
            <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium uppercase tracking-wider text-ink-soft">Collected</p>
                <p class="mt-2 font-serif text-3xl font-semibold tracking-tight text-navy-950">{{ \App\Services\FinanceService::formatBalance($monthCollections) }}</p>
            </div>
            <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium uppercase tracking-wider text-ink-soft">Spent</p>
                <p class="mt-2 font-serif text-3xl font-semibold tracking-tight text-navy-950">{{ \App\Services\FinanceService::formatBalance($monthExpenses) }}</p>
            </div>
            <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium uppercase tracking-wider text-ink-soft">Balance</p>
                <p class="mt-2 font-serif text-3xl font-semibold tracking-tight {{ $monthBalance < 0 ? 'text-maroon-700' : 'text-navy-950' }}">{{ \App\Services\FinanceService::formatBalance($monthBalance) }}</p>
            </div>
        </div>
    </section>

    {{-- 3+4. Selected year: monthly collections vs expenses --}}
    <section class="mt-10" aria-labelledby="finance-yearly">
        <h2 id="finance-yearly" class="font-serif text-xl font-semibold text-navy-950">Collections vs Expenses — {{ $year }}</h2>
        <div class="mt-4 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-navy-100 text-sm">
                    <thead class="bg-cream">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Month</th>
                            <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-ink-soft">Collections</th>
                            <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-ink-soft">Expenses</th>
                            <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-ink-soft">Balance</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-navy-50">
                        @foreach ($yearly as $row)
                            <tr class="transition-colors hover:bg-cream/60">
                                <td class="px-6 py-3.5 font-medium text-navy-950">{{ $row['label'] }}</td>
                                <td class="px-6 py-3.5 text-right text-navy-950">{{ $row['collections'] > 0 ? '৳'.number_format($row['collections']) : '—' }}</td>
                                <td class="px-6 py-3.5 text-right text-navy-950">{{ $row['expenses'] > 0 ? '৳'.number_format($row['expenses']) : '—' }}</td>
                                <td class="px-6 py-3.5 text-right font-semibold {{ $row['balance'] < 0 ? 'text-maroon-700' : 'text-navy-950' }}">{{ \App\Services\FinanceService::formatBalance($row['balance']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-cream font-semibold">
                        <tr>
                            <td class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-ink-soft">Year Total</td>
                            <td class="px-6 py-3.5 text-right text-navy-950">{{ \App\Services\FinanceService::formatBalance(collect($yearly)->sum('collections')) }}</td>
                            <td class="px-6 py-3.5 text-right text-navy-950">{{ \App\Services\FinanceService::formatBalance(collect($yearly)->sum('expenses')) }}</td>
                            <td class="px-6 py-3.5 text-right {{ collect($yearly)->sum('balance') < 0 ? 'text-maroon-700' : 'text-navy-950' }}">{{ \App\Services\FinanceService::formatBalance(collect($yearly)->sum('balance')) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>

    {{-- 5. Expense category breakdown --}}
    <section class="mt-10" aria-labelledby="finance-breakdown">
        <h2 id="finance-breakdown" class="font-serif text-xl font-semibold text-navy-950">
            Expense Category Breakdown
            <span class="text-sm font-normal text-ink-soft">{{ $selectedMonth ? \Illuminate\Support\Carbon::create($year, $selectedMonth, 1)->format('F Y') : $year }}</span>
        </h2>

        @if ($breakdown->count())
            <div class="mt-4 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-navy-100 text-sm">
                        <thead class="bg-cream">
                            <tr>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</th>
                                <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-ink-soft">Total Expenses</th>
                                <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-ink-soft">Share</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-navy-50">
                            @foreach ($breakdown as $item)
                                @php
                                    $percentage = $breakdownTotal > 0 ? round(($item->total / $breakdownTotal) * 100) : 0;
                                @endphp
                                <tr class="transition-colors hover:bg-cream/60">
                                    <td class="px-6 py-3.5 font-medium text-navy-950">{{ $item->name }} <span class="text-xs font-normal text-ink-soft">({{ number_format($item->count) }})</span></td>
                                    <td class="px-6 py-3.5 text-right text-navy-950">৳{{ number_format($item->total) }}</td>
                                    <td class="px-6 py-3.5 text-right text-ink-soft">{{ $percentage }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="mt-4">
                <x-empty-state compact title="No expenses in this period" description="Recorded (non-void) expenses will appear here grouped by category." />
            </div>
        @endif
    </section>

    {{-- 6+7. Recent transactions --}}
    <section class="mt-10 grid gap-8 lg:grid-cols-2" aria-label="Recent transactions">
        <div>
            <h2 class="font-serif text-xl font-semibold text-navy-950">Recent Collections</h2>
            <div class="mt-4 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
                @if ($recentCollections->count())
                    <ul class="divide-y divide-navy-50">
                        @foreach ($recentCollections as $payment)
                            <li>
                                <a href="{{ route('admin.payments.show', $payment) }}" class="focus-ring flex items-center justify-between gap-3 px-5 py-3.5 transition-colors hover:bg-cream/60">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-medium text-navy-950">{{ $payment->membership?->alumni?->full_name ?? $payment->membership?->membership_number ?? 'Member' }}</p>
                                        <p class="font-mono text-xs text-ink-soft">{{ $payment->payment_number }} · {{ $payment->paid_at?->format('M j, Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-emerald-700">+{{ $payment->formattedAmount() }}</p>
                                        <p class="text-xs text-ink-soft">{{ $payment->status->label() }}</p>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="px-5 py-8 text-center text-sm text-ink-soft">No collections recorded yet.</p>
                @endif
            </div>
        </div>
        <div>
            <h2 class="font-serif text-xl font-semibold text-navy-950">Recent Expenses</h2>
            <div class="mt-4 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
                @if ($recentExpenses->count())
                    <ul class="divide-y divide-navy-50">
                        @foreach ($recentExpenses as $expense)
                            <li>
                                <a href="{{ route('admin.expenses.show', $expense) }}" class="focus-ring flex items-center justify-between gap-3 px-5 py-3.5 transition-colors hover:bg-cream/60">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-medium text-navy-950">{{ $expense->title }}</p>
                                        <p class="font-mono text-xs text-ink-soft">{{ $expense->expense_number }} · {{ $expense->expense_date?->format('M j, Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-maroon-700">−{{ $expense->formattedAmount() }}</p>
                                        <p class="text-xs text-ink-soft">{{ $expense->category?->name }}</p>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="px-5 py-8 text-center text-sm text-ink-soft">No expenses recorded yet.</p>
                @endif
            </div>
        </div>
    </section>
</x-layouts.admin>
