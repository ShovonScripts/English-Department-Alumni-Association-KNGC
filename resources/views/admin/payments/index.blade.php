<x-layouts.admin title="Payments">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Payments</h1>
            <p class="mt-1 text-sm text-ink-soft">
                Manual collection records for organizational dues. No online payments are processed.
            </p>
        </div>
        <x-button href="{{ route('admin.payments.create') }}" variant="gold">Record Payment</x-button>
    </div>

    @if (session('status'))
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
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

    @if ($filterMembership)
        <div class="mb-6 flex items-center justify-between gap-3 rounded-md border border-maroon-200 bg-maroon-50 px-4 py-3 text-sm text-maroon-800">
            <span>
                Showing payment history for
                <strong>{{ $filterMembership->alumni?->full_name }}</strong>
                ({{ $filterMembership->membership_number }})
            </span>
            <a href="{{ route('admin.payments.index') }}" class="focus-ring rounded font-semibold hover:underline">Clear member filter</a>
        </div>
    @endif

    {{-- Collection totals --}}
    <div class="mb-8 grid gap-5 sm:grid-cols-2">
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-6">
            <p class="text-sm font-medium uppercase tracking-wider text-emerald-700">Total Collected</p>
            <p class="mt-2 font-serif text-4xl font-semibold tracking-tight text-emerald-800">৳{{ number_format($totalCollected) }}</p>
            <p class="mt-1 text-xs text-emerald-600">Paid + partial records matching current filters. Void and waived excluded.</p>
        </div>
        <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium uppercase tracking-wider text-ink-soft">Valid Payments</p>
            <p class="mt-2 font-serif text-4xl font-semibold tracking-tight text-navy-950">{{ number_format($validCount) }}</p>
            <p class="mt-1 text-xs text-ink-soft">Void records are retained for audit but never counted.</p>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.payments.index') }}" class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-6">
            <div class="lg:col-span-2">
                <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                <input
                    type="search"
                    id="search"
                    name="search"
                    value="{{ $filters['search'] }}"
                    placeholder="Payment #, member, membership #, reference…"
                    class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"
                >
            </div>

            <div>
                <label for="status" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</label>
                <select id="status" name="status" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->value }}" @selected($filters['status'] === $status->value)>{{ $status->label() }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="membership_type_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Type</label>
                <select id="membership_type_id" name="membership_type_id" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}" @selected($filters['membership_type_id'] == $type->id)>{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="date_from" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">From</label>
                <input type="date" id="date_from" name="date_from" value="{{ $filters['date_from'] }}" class="w-full rounded-md border border-navy-300 bg-white px-3 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
            </div>

            <div class="flex items-end gap-2">
                <div class="flex-1">
                    <label for="date_to" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">To</label>
                    <input type="date" id="date_to" name="date_to" value="{{ $filters['date_to'] }}" class="w-full rounded-md border border-navy-300 bg-white px-3 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                </div>
                <x-button type="submit" variant="navy">Filter</x-button>
            </div>
        </div>
    </form>

    @if ($payments->isNotEmpty())
        <div class="mt-8 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-navy-100 bg-navy-50/60 text-xs uppercase tracking-wider text-ink-soft">
                            <th class="px-6 py-3.5 font-semibold">Payment #</th>
                            <th class="px-6 py-3.5 font-semibold">Member</th>
                            <th class="px-6 py-3.5 font-semibold">Membership #</th>
                            <th class="px-6 py-3.5 font-semibold">Amount</th>
                            <th class="px-6 py-3.5 font-semibold">Status</th>
                            <th class="px-6 py-3.5 font-semibold">Paid At</th>
                            <th class="px-6 py-3.5 font-semibold">Recorded By</th>
                            <th class="px-6 py-3.5 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-navy-100">
                        @foreach ($payments as $payment)
                            <tr class="transition-colors {{ $payment->status->isVoid() ? 'opacity-60' : 'hover:bg-cream/70' }}">
                                <td class="px-6 py-4 font-mono text-xs font-semibold text-navy-900">{{ $payment->payment_number }}</td>
                                <td class="px-6 py-4 font-medium text-navy-950">{{ $payment->membership?->alumni?->full_name ?? '—' }}</td>
                                <td class="px-6 py-4 font-mono text-xs text-ink-soft">{{ $payment->membership?->membership_number ?? '—' }}</td>
                                <td class="px-6 py-4 font-semibold text-navy-950">{{ $payment->formattedAmount() }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $styles = [
                                            'paid' => ['bg-emerald-100', 'text-emerald-800'],
                                            'partial' => ['bg-gold-500/20', 'text-gold-700'],
                                            'waived' => ['bg-navy-100', 'text-navy-600'],
                                            'void' => ['bg-maroon-100', 'text-maroon-800'],
                                        ];
                                        [$bg, $text] = $styles[$payment->status->value] ?? ['bg-navy-100', 'text-navy-600'];
                                    @endphp
                                    <span class="inline-flex rounded-full {{ $bg }} px-2.5 py-1 text-xs font-bold uppercase tracking-wide {{ $text }}">{{ $payment->status->label() }}</span>
                                </td>
                                <td class="px-6 py-4 text-ink-soft">{{ $payment->paid_at?->format('M j, Y') }}</td>
                                <td class="px-6 py-4 text-ink-soft">{{ $payment->recordedBy?->name ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.payments.show', $payment) }}" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900" aria-label="View {{ $payment->payment_number }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12z" />
                                            </svg>
                                        </a>
                                        @unless ($payment->status->isVoid())
                                            <a href="{{ route('admin.payments.edit', $payment) }}" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900" aria-label="Edit {{ $payment->payment_number }}">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2 2 0 112.8 2.8L11 15l-4 1 1-4 9.6-9.4z" />
                                                </svg>
                                            </a>
                                        @endunless
                                        <form method="POST" action="{{ route('admin.payments.destroy', $payment) }}" onsubmit="return confirm('PERMANENTLY DELETE {{ $payment->payment_number }}? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-maroon-600 transition-colors hover:bg-maroon-50 hover:text-maroon-900" aria-label="Delete {{ $payment->payment_number }}">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-navy-100 px-6 py-4">
                {{ $payments->links() }}
            </div>
        </div>
    @else
        <div class="mt-8">
            <x-empty-state
                title="No payments found"
                description="No collection records match your current filters. Adjust the filters or record a new payment to get started."
                action_label="Record Payment"
                action_href="{{ route('admin.payments.create') }}"
            />
        </div>
    @endif
</x-layouts.admin>
