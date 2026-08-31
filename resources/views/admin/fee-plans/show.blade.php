<x-layouts.admin title="Fee Plan Details">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">{{ $plan->name }}</h1>
            <p class="mt-1 text-sm text-ink-soft">Fee plan details and applicability.</p>
        </div>
        <a href="{{ route('admin.fee-plans.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
            &larr; Back to Fee Plans
        </a>
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

    <div class="grid gap-8 lg:grid-cols-3">
        {{-- Summary card --}}
        <div>
            <section class="rounded-lg border border-navy-100 bg-white p-8 text-center shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-widest text-ink-soft">{{ $plan->membershipType?->name }}</p>
                <p class="mt-4 font-serif text-5xl font-semibold tracking-tight text-navy-950">{{ $plan->formattedAmount() }}</p>
                <p class="mt-2 text-sm font-medium uppercase tracking-widest text-maroon-700">{{ $plan->frequencyLabel() }}</p>

                <div class="mt-6 flex flex-wrap items-center justify-center gap-1.5">
                    @if ($plan->is_active)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-800">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span>
                            Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-xs font-semibold text-navy-600">
                            <span class="h-1.5 w-1.5 rounded-full bg-navy-400" aria-hidden="true"></span>
                            Inactive
                        </span>
                    @endif

                    @php $timing = $plan->timingState(); @endphp
                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-bold uppercase tracking-wide
                        {{ $timing === 'current' ? 'bg-maroon-700/10 text-maroon-700' : ($timing === 'upcoming' ? 'bg-gold-500/20 text-gold-700' : 'bg-navy-100 text-navy-500') }}">
                        {{ ucfirst($timing) }}
                    </span>
                </div>
            </section>
        </div>

        {{-- Details --}}
        <div class="lg:col-span-2">
            <section class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm sm:p-10">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Plan Configuration</h2>

                <dl class="mt-8 grid gap-x-8 gap-y-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Type</dt>
                        <dd class="mt-1 text-sm text-navy-950">
                            <a href="{{ route('admin.membership-types.edit', $plan->membershipType) }}" class="focus-ring rounded font-medium text-maroon-700 transition-colors hover:text-maroon-900">
                                {{ $plan->membershipType?->name ?? '—' }}
                            </a>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Amount</dt>
                        <dd class="mt-1 text-sm font-semibold text-navy-950">{{ $plan->formattedAmount() }} <span class="font-normal text-ink-soft">({{ $plan->currency }})</span></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Frequency</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $plan->frequencyLabel() }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $plan->is_active ? 'Active' : 'Inactive' }} · {{ ucfirst($plan->timingState()) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Effective From</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $plan->effective_from?->format('M j, Y') ?? 'No start date' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Effective Until</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $plan->effective_until?->format('M j, Y') ?? 'Open-ended' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Description</dt>
                        <dd class="mt-1 text-sm leading-relaxed text-navy-950">{{ $plan->description ?: 'No description recorded.' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Sort Order</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $plan->sort_order }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Created / Updated</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $plan->created_at?->format('M j, Y') }} · {{ $plan->updated_at?->format('M j, Y') }}</dd>
                    </div>
                </dl>

                <div class="mt-10 flex flex-wrap items-center gap-3 border-t border-navy-100 pt-8">
                    <x-button href="{{ route('admin.fee-plans.edit', $plan) }}" variant="navy">Edit Fee Plan</x-button>

                    @if ($plan->is_active)
                        <form method="POST" action="{{ route('admin.fee-plans.deactivate', $plan) }}">
                            @csrf
                            <x-button type="submit" variant="outline">Deactivate</x-button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.fee-plans.activate', $plan) }}">
                            @csrf
                            <x-button type="submit" variant="gold">Activate</x-button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('admin.fee-plans.destroy', $plan) }}" onsubmit="return confirm('Delete {{ addslashes($plan->name) }}? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="focus-ring inline-flex items-center rounded-md px-3.5 py-2 text-sm font-semibold text-maroon-600 transition-colors hover:bg-maroon-50">
                            Delete
                        </button>
                    </form>
                </div>
            </section>
        </div>
    </div>
</x-layouts.admin>
