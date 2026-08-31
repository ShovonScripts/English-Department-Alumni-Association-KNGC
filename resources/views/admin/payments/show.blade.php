<x-layouts.admin title="Payment Details">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">{{ $payment->payment_number }}</h1>
            <p class="mt-1 text-sm text-ink-soft">Manual collection record.</p>
        </div>
        <a href="{{ route('admin.payments.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
            &larr; Back to Payments
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
            <section class="rounded-lg border p-8 text-center shadow-sm {{ $payment->status->isVoid() ? 'border-maroon-200 bg-maroon-50' : 'border-navy-100 bg-white' }}">
                <p class="text-xs font-semibold uppercase tracking-widest text-ink-soft">Amount Collected</p>
                <p class="mt-3 font-serif text-5xl font-semibold tracking-tight {{ $payment->status->isVoid() ? 'text-maroon-400 line-through' : 'text-navy-950' }}">{{ $payment->formattedAmount() }}</p>

                @php
                    $styles = [
                        'paid' => ['bg-emerald-100', 'text-emerald-800'],
                        'partial' => ['bg-gold-500/20', 'text-gold-700'],
                        'waived' => ['bg-navy-100', 'text-navy-600'],
                        'void' => ['bg-maroon-100', 'text-maroon-800'],
                    ];
                    [$bg, $text] = $styles[$payment->status->value] ?? ['bg-navy-100', 'text-navy-600'];
                @endphp
                <span class="mt-4 inline-flex rounded-full {{ $bg }} px-3 py-1 text-xs font-bold uppercase tracking-wide {{ $text }}">{{ $payment->status->label() }}</span>

                @if ($obligation['waived'])
                    <p class="mt-6 rounded-md bg-navy-50 px-3 py-2 text-xs text-navy-700">
                        This obligation has been waived by the association.
                    </p>
                @elseif ($obligation['overpaid'] > 0)
                    <p class="mt-6 rounded-md bg-gold-500/10 px-3 py-2 text-xs font-medium text-gold-700">
                        Overpaid by ৳{{ number_format($obligation['overpaid']) }} — no refund created automatically.
                    </p>
                @else
                    <dl class="mt-6 space-y-2 border-t border-navy-100 pt-4 text-left text-sm">
                        <div class="flex justify-between gap-2">
                            <dt class="text-ink-soft">Expected</dt>
                            <dd class="font-semibold text-navy-950">৳{{ number_format($obligation['expected']) }}</dd>
                        </div>
                        <div class="flex justify-between gap-2">
                            <dt class="text-ink-soft">Collected</dt>
                            <dd class="font-semibold text-navy-950">৳{{ number_format($obligation['collected']) }}</dd>
                        </div>
                        <div class="flex justify-between gap-2">
                            <dt class="text-ink-soft">Outstanding</dt>
                            <dd class="font-bold {{ $obligation['outstanding'] > 0 ? 'text-maroon-700' : 'text-emerald-700' }}">৳{{ number_format($obligation['outstanding']) }}</dd>
                        </div>
                    </dl>
                @endunless
            </section>
        </div>

        {{-- Record details --}}
        <div class="lg:col-span-2">
            <section class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm sm:p-10">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Payment Record</h2>

                <dl class="mt-8 grid gap-x-8 gap-y-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Member</dt>
                        <dd class="mt-1 text-sm text-navy-950">
                            <a href="{{ route('admin.members.show', $payment->membership) }}" class="focus-ring rounded font-medium text-maroon-700 transition-colors hover:text-maroon-900">
                                {{ $payment->membership?->alumni?->full_name }}
                            </a>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Number</dt>
                        <dd class="mt-1 font-mono text-xs font-semibold text-navy-900">{{ $payment->membership?->membership_number }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Type</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $payment->membership?->type?->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Tier</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $payment->membership?->tier?->badge_label ?? 'Not assigned' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Fee Plan</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $payment->feePlan?->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Fee Plan Amount</dt>
                        <dd class="mt-1 text-sm font-semibold text-navy-950">৳{{ number_format((float) $payment->feePlan?->amount) }} <span class="font-normal text-ink-soft">({{ $payment->currency }})</span></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Payment Date</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $payment->paid_at?->format('M j, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Reference</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $payment->reference ?: '—' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Admin Notes</dt>
                        <dd class="mt-1 text-sm leading-relaxed text-navy-950">{{ $payment->notes ?: 'No notes recorded.' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Recorded By</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $payment->recordedBy?->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Recorded / Updated</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $payment->created_at?->format('M j, Y') }} · {{ $payment->updated_at?->format('M j, Y') }}</dd>
                    </div>

                    @if ($payment->status->isVoid())
                        <div class="sm:col-span-2 rounded-md border border-maroon-200 bg-maroon-50 p-4">
                            <dt class="text-xs font-bold uppercase tracking-wider text-maroon-800">Voided</dt>
                            <dd class="mt-1 text-sm text-maroon-800">
                                {{ $payment->voided_at?->format('M j, Y, g:i A') }}
                                by {{ $payment->voidedBy?->name }}<br>
                                <span class="italic">“{{ $payment->void_reason }}”</span>
                            </dd>
                        </div>
                    @endif
                </dl>

                <div class="mt-10 flex flex-wrap items-center gap-3 border-t border-navy-100 pt-8">
                    @unless ($payment->status->isVoid())
                        <x-button href="{{ route('admin.payments.edit', $payment) }}" variant="navy">Edit Payment</x-button>
                    @endunless

                    <a href="{{ route('admin.members.show', $payment->membership) }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-maroon-700 transition-colors hover:bg-maroon-50">
                        View Member Summary
                    </a>
                </div>

                @unless ($payment->status->isVoid())
                    <details class="mt-8 border-t border-navy-100 pt-6">
                        <summary class="focus-ring cursor-pointer rounded text-sm font-semibold text-maroon-700 hover:text-maroon-900">Void this payment…</summary>
                        <form method="POST" action="{{ route('admin.payments.void', $payment) }}" class="mt-4 max-w-xl" onsubmit="return confirm('Void {{ $payment->payment_number }}? The record is retained but excluded from all totals.');">
                            @csrf
                            <label for="void_reason" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Void Reason (required, kept in audit trail) *</label>
                            <textarea id="void_reason" name="void_reason" rows="2" required minlength="5" maxlength="1000" placeholder="e.g. Duplicate entry recorded in error." class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"></textarea>
                            @error('void_reason')
                                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
                            @enderror
                            <x-button type="submit" variant="maroon" size="sm">Void Payment</x-button>
                        </form>
                    </details>
                @endunless
            </section>
        </div>
    </div>
</x-layouts.admin>
