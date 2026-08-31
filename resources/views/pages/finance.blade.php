<x-layouts.app
    title="Financial Transparency"
    description="View the aggregate financial overview and transparency information of {{ config('site.name') }}."
>

    <x-page-header
        title="Financial Transparency"
        description="A transparent overview of the financial position of {{ config('site.short_name') }}."
        eyebrow="Transparency"
        :breadcrumbs="[['label' => 'Finance']]"
    />

    {{-- Financial Overview --}}
    <section class="section-pad bg-white">
        <div class="container-page">
            <x-section-heading
                eyebrow="Financial Overview"
                title="Association Funds"
                description="Aggregate financial records maintained by the Association. Individual member payments and expense records are not publicly disclosed."
            />

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                {{-- Total Collections --}}
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-8 text-center">
                    <p class="text-sm font-medium uppercase tracking-wider text-emerald-700">Total Collections</p>
                    <p class="mt-3 font-serif text-4xl font-semibold tracking-tight text-emerald-800">
                        {{ \App\Services\FinanceService::formatBalance($totalCollections) }}
                    </p>
                    <p class="mt-2 text-xs text-emerald-600">Organizational dues collected (paid + partial)</p>
                </div>

                {{-- Total Expenses --}}
                <div class="rounded-lg border border-maroon-200 bg-maroon-50 p-8 text-center">
                    <p class="text-sm font-medium uppercase tracking-wider text-maroon-700">Total Expenses</p>
                    <p class="mt-3 font-serif text-4xl font-semibold tracking-tight text-maroon-800">
                        {{ \App\Services\FinanceService::formatBalance($totalExpenses) }}
                    </p>
                    <p class="mt-2 text-xs text-maroon-600">Association spending (recorded expenses)</p>
                </div>

                {{-- Current Balance --}}
                <div class="rounded-lg border border-navy-200 bg-white p-8 text-center shadow-sm sm:col-span-2 lg:col-span-1">
                    <p class="text-sm font-medium uppercase tracking-wider text-ink-soft">Current Balance</p>
                    <p class="mt-3 font-serif text-4xl font-semibold tracking-tight {{ $currentBalance < 0 ? 'text-maroon-700' : 'text-navy-950' }}">
                        {{ \App\Services\FinanceService::formatBalance($currentBalance) }}
                    </p>
                    <p class="mt-2 text-xs text-ink-soft">Total collections minus total expenses</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Current Month --}}
    <section class="bg-cream py-16 sm:py-20 lg:py-24">
        <div class="container-page">
            <x-section-heading
                eyebrow="Current Period"
                title="{{ now()->format('F Y') }}"
                description="Monthly financial activity for the current period."
            />

            <div class="mt-10 grid gap-6 sm:grid-cols-3">
                <div class="rounded-lg border border-navy-100 bg-white p-8 text-center shadow-sm">
                    <p class="text-sm font-medium uppercase tracking-wider text-ink-soft">Collected</p>
                    <p class="mt-3 font-serif text-3xl font-semibold tracking-tight text-navy-950">
                        {{ \App\Services\FinanceService::formatBalance($monthCollections) }}
                    </p>
                </div>
                <div class="rounded-lg border border-navy-100 bg-white p-8 text-center shadow-sm">
                    <p class="text-sm font-medium uppercase tracking-wider text-ink-soft">Spent</p>
                    <p class="mt-3 font-serif text-3xl font-semibold tracking-tight text-navy-950">
                        {{ \App\Services\FinanceService::formatBalance($monthExpenses) }}
                    </p>
                </div>
                <div class="rounded-lg border border-navy-100 bg-white p-8 text-center shadow-sm">
                    <p class="text-sm font-medium uppercase tracking-wider text-ink-soft">Balance</p>
                    <p class="mt-3 font-serif text-3xl font-semibold tracking-tight {{ $monthBalance < 0 ? 'text-maroon-700' : 'text-navy-950' }}">
                        {{ \App\Services\FinanceService::formatBalance($monthBalance) }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Yearly Summary --}}
    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <x-section-heading
                    eyebrow="Annual Report"
                    title="Yearly Summary — {{ $year }}"
                    description="Month-by-month overview of collections and expenses."
                />

                {{-- Year selector --}}
                <form method="GET" action="{{ route('finance.public') }}" class="shrink-0">
                    <label for="year" class="sr-only">Select year</label>
                    <select id="year" name="year" onchange="this.form.submit()" class="rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                        @foreach ($availableYears as $y)
                            <option value="{{ $y }}" @selected($y === $year)>{{ $y }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="mt-8 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
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
                                    <td class="px-6 py-3.5 text-right text-navy-950">
                                        {{ $row['collections'] > 0 ? '৳'.number_format($row['collections']) : '—' }}
                                    </td>
                                    <td class="px-6 py-3.5 text-right text-navy-950">
                                        {{ $row['expenses'] > 0 ? '৳'.number_format($row['expenses']) : '—' }}
                                    </td>
                                    <td class="px-6 py-3.5 text-right font-semibold {{ $row['balance'] < 0 ? 'text-maroon-700' : 'text-navy-950' }}">
                                        {{ \App\Services\FinanceService::formatBalance($row['balance']) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-cream font-semibold">
                            <tr>
                                <td class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-ink-soft">Year Total</td>
                                <td class="px-6 py-3.5 text-right text-navy-950">{{ \App\Services\FinanceService::formatBalance(collect($yearly)->sum('collections')) }}</td>
                                <td class="px-6 py-3.5 text-right text-navy-950">{{ \App\Services\FinanceService::formatBalance(collect($yearly)->sum('expenses')) }}</td>
                                <td class="px-6 py-3.5 text-right {{ collect($yearly)->sum('balance') < 0 ? 'text-maroon-700' : 'text-navy-950' }}">
                                    {{ \App\Services\FinanceService::formatBalance(collect($yearly)->sum('balance')) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- Expense Category Breakdown --}}
    <section class="bg-cream py-16 sm:py-20 lg:py-24">
        <div class="container-page">
            <x-section-heading
                eyebrow="Where Funds Go"
                title="Expense Breakdown"
                description="How association funds are allocated across activity categories."
            />

            @if ($breakdown->count())
                <div class="mt-10 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-navy-100 text-sm">
                            <thead class="bg-cream">
                                <tr>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</th>
                                    <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-ink-soft">Total</th>
                                    <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-ink-soft">Share</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-navy-50">
                                @foreach ($breakdown as $item)
                                    @php
                                        $percentage = $breakdownTotal > 0 ? round(($item->total / $breakdownTotal) * 100) : 0;
                                    @endphp
                                    <tr class="transition-colors hover:bg-cream/60">
                                        <td class="px-6 py-3.5 font-medium text-navy-950">{{ $item->name }}</td>
                                        <td class="px-6 py-3.5 text-right text-navy-950">৳{{ number_format($item->total) }}</td>
                                        <td class="px-6 py-3.5 text-right text-ink-soft">{{ $percentage }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="mt-10">
                    <x-empty-state
                        compact
                        title="No expenses recorded"
                        description="No recorded expenses are available for the selected period."
                    />
                </div>
            @endif
        </div>
    </section>

    {{-- Transparency Statement --}}
    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="mx-auto max-w-3xl rounded-lg border border-navy-100 bg-cream p-8 sm:p-10">
                <x-section-heading
                    eyebrow="Transparency"
                    title="About This Page"
                    align="center"
                />

                <div class="mt-6 space-y-4 text-sm leading-relaxed text-ink-soft">
                    <p>
                        Financial information shown on this page represents aggregate records maintained by the
                        {{ config('site.name') }}. Individual member payments and individual expense records
                        are not publicly disclosed.
                    </p>
                    <p>
                        Total Collections reflect organizational dues received from members (paid and partial
                        payments only). Void and waived records are excluded. Total Expenses reflect association
                        spending recorded by administrators. Void expenses are excluded.
                    </p>
                    <p>
                        The Current Balance is calculated as Total Collections minus Total Expenses. A negative
                        balance indicates that recorded expenses exceed recorded collections for the period shown.
                    </p>
                </div>

                @if ($lastUpdatedAt)
                    <p class="mt-6 text-center text-xs text-ink-soft">
                        Financial data updated through {{ $lastUpdatedAt->format('j F Y') }}.
                    </p>
                @endif
            </div>
        </div>
    </section>

</x-layouts.app>
