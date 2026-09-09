<x-layouts.admin title="Expense Details">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">{{ $expense->expense_number }}</h1>
            <p class="mt-1 text-sm text-ink-soft">Association expense record.</p>
        </div>
        <a href="{{ route('admin.expenses.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
            &larr; Back to Expenses
        </a>
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

    <div class="grid gap-8 lg:grid-cols-3">
        {{-- Amount summary --}}
        <div>
            <section class="rounded-lg border p-8 text-center shadow-sm {{ $expense->status->isVoid() ? 'border-maroon-200 bg-maroon-50' : 'border-navy-100 bg-white' }}">
                <p class="text-xs font-semibold uppercase tracking-widest text-ink-soft">Amount Spent</p>
                <p class="mt-3 font-serif text-5xl font-semibold tracking-tight {{ $expense->status->isVoid() ? 'text-maroon-400 line-through' : 'text-navy-950' }}">{{ $expense->formattedAmount() }}</p>

                @php
                    $styles = [
                        'recorded' => ['bg-emerald-100', 'text-emerald-800'],
                        'void' => ['bg-maroon-100', 'text-maroon-800'],
                    ];
                    [$bg, $text] = $styles[$expense->status->value] ?? ['bg-navy-100', 'text-navy-600'];
                @endphp
                <span class="mt-4 inline-flex rounded-full {{ $bg }} px-3 py-1 text-xs font-bold uppercase tracking-wide {{ $text }}">{{ $expense->status->label() }}</span>

                @if ($expense->status->isVoid())
                    <p class="mt-6 rounded-md bg-maroon-100/60 px-3 py-2 text-xs font-medium text-maroon-800">
                        This expense is void — it does not count toward total expenses or the current balance.
                    </p>
                @endif

                <div class="mt-10 flex flex-wrap items-center justify-center gap-3 border-t border-navy-100 pt-8">
                    @unless ($expense->status->isVoid())
                        <x-button href="{{ route('admin.expenses.edit', $expense) }}" variant="navy">Edit Expense</x-button>
                    @else
                        <p class="max-w-xs text-xs text-ink-soft">
                            Voided expenses are locked. If a correction is needed, record a new expense — history stays intact.
                        </p>
                    @endunless
                </div>

                @unless ($expense->status->isVoid())
                    <details class="mt-8 border-t border-navy-100 pt-6">
                        <summary class="focus-ring cursor-pointer rounded text-sm font-semibold text-maroon-700 hover:text-maroon-900">Void this expense…</summary>
                        <form method="POST" action="{{ route('admin.expenses.void', $expense) }}" class="mt-4 max-w-xl" onsubmit="return confirm('Are you sure you want to void this expense? {{ $expense->expense_number }} ({{ $expense->formattedAmount() }}) will be retained for audit but excluded from all totals.');">
                            @csrf
                            <label for="void_reason" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Void Reason (required, kept in audit trail) *</label>
                            <textarea id="void_reason" name="void_reason" rows="2" required minlength="5" maxlength="1000" placeholder="e.g. Duplicate entry." class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"></textarea>
                            @error('void_reason')
                                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
                            @enderror
                            <x-button type="submit" variant="maroon" size="sm">Void Expense</x-button>
                        </form>
                    </details>
                @endunless

                <details class="mt-4 pt-6">
                    <summary class="focus-ring cursor-pointer rounded text-sm font-semibold text-maroon-700 hover:text-maroon-900">Delete this expense permanently…</summary>
                    <form method="POST" action="{{ route('admin.expenses.destroy', $expense) }}" class="mt-4 max-w-xl" onsubmit="return confirm('PERMANENTLY DELETE {{ $expense->expense_number }}? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <p class="mb-3 text-xs text-maroon-700">This will permanently remove the expense record from the database. Consider voiding instead for audit trail purposes.</p>
                        <x-button type="submit" variant="maroon" size="sm">Delete Permanently</x-button>
                    </form>
                </details>
            </section>
        </div>

        {{-- Record details --}}
        <div class="lg:col-span-2">
            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Record Information</h2>

                <dl class="mt-6 grid gap-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Expense Number</dt>
                        <dd class="mt-1 font-mono text-sm font-semibold text-navy-950">{{ $expense->expense_number }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $expense->status->label() }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $expense->category?->name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Currency</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $expense->currency }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Expense Date</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $expense->expense_date?->format('M j, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Reference</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $expense->reference ?: 'No reference recorded.' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Title</dt>
                        <dd class="mt-1 text-sm font-medium text-navy-950">{{ $expense->title }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Description</dt>
                        <dd class="mt-1 text-sm leading-relaxed text-navy-950">{{ $expense->description ?: 'No description recorded.' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Recorded By</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $expense->recordedBy?->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Recorded / Updated</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $expense->created_at?->format('M j, Y') }} · {{ $expense->updated_at?->format('M j, Y') }}</dd>
                    </div>

                    @if ($expense->status->isVoid())
                        <div class="sm:col-span-2 rounded-md border border-maroon-200 bg-maroon-50 p-4">
                            <dt class="text-xs font-bold uppercase tracking-wider text-maroon-800">Voided</dt>
                            <dd class="mt-1 text-sm text-maroon-800">
                                {{ $expense->voided_at?->format('M j, Y, g:i A') }}
                                by {{ $expense->voidedBy?->name }}<br>
                                <span class="italic">“{{ $expense->void_reason }}”</span>
                            </dd>
                        </div>
                    @endif
                </dl>
            </section>
        </div>
    </div>
</x-layouts.admin>
