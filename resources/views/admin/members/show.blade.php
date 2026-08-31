<x-layouts.admin title="Member Details">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Membership {{ $membership->membership_number }}</h1>
            <p class="mt-1 text-sm text-ink-soft">Detailed record for this registered member.</p>
        </div>
        <a href="{{ route('admin.members.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
            &larr; Back to Members
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

    <div class="grid gap-8 lg:grid-cols-3">
        {{-- Member card --}}
        <div>
            <section class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                <div class="flex flex-col items-center text-center">
                    @if ($membership->alumni?->profile_photo_url)
                        <img src="{{ $membership->alumni->profile_photo_url }}" alt="" class="h-24 w-24 rounded-full object-cover ring-4 ring-gold-500/30">
                    @else
                        <span class="flex h-24 w-24 items-center justify-center rounded-full bg-navy-900 font-serif text-2xl font-semibold text-gold-300 ring-4 ring-gold-500/30" aria-hidden="true">
                            {{ \Illuminate\Support\Str::initials($membership->alumni?->full_name ?? '') }}
                        </span>
                    @endif

                    <h2 class="mt-5 font-serif text-xl font-semibold text-navy-950">{{ $membership->alumni?->full_name ?? 'Unknown alumni' }}</h2>

                    @if ($membership->alumni?->student_id)
                        <p class="mt-1 font-mono text-xs text-ink-soft">{{ $membership->alumni->student_id }}</p>
                    @endif

                    <p class="mt-1 text-sm text-ink-soft">{{ $membership->alumni?->profession ?? '—' }}</p>
                    <p class="text-xs text-ink-soft">
                        Batch {{ $membership->alumni?->batch ?? '—' }}@if($membership->alumni?->graduation_year) · Class of {{ $membership->alumni->graduation_year }}@endif
                    </p>
                    @if ($membership->alumni?->location)
                        <p class="mt-1 text-xs text-ink-soft">{{ $membership->alumni->location }}</p>
                    @endif
                </div>

                <dl class="mt-6 space-y-3 border-t border-navy-100 pt-6 text-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="font-medium text-ink-soft">Alumni profile</dt>
                        <dd><a href="{{ route('admin.alumni.show', $membership->alumni) }}" class="focus-ring rounded font-semibold text-maroon-700 transition-colors hover:text-maroon-900">View record</a></dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="font-medium text-ink-soft">Public page</dt>
                        <dd><a href="{{ route('alumni.show', $membership->alumni) }}" target="_blank" rel="noopener noreferrer" class="focus-ring rounded font-semibold text-maroon-700 transition-colors hover:text-maroon-900">Open</a></dd>
                    </div>
                </dl>
            </section>
        </div>

        {{-- Membership details --}}
        <div class="lg:col-span-2">
            <section class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm sm:p-10">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h2 class="font-serif text-xl font-semibold text-navy-950">Membership Record</h2>
                        <p class="mt-1 font-mono text-sm font-semibold text-maroon-700">{{ $membership->membership_number }}</p>
                    </div>
                    <x-membership-badge :type="$membership->type" :tier="$membership->tier" />
                </div>

                <dl class="mt-8 grid gap-x-8 gap-y-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Type</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $membership->type?->name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Tier</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $membership->tier?->badge_label ? $membership->tier->badge_label.' — '.$membership->tier->name : 'Not assigned' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</dt>
                        <dd class="mt-1">
                            @php
                                $statusStyles = [
                                    'active' => ['bg-emerald-100', 'text-emerald-800', 'bg-emerald-500'],
                                    'pending' => ['bg-gold-500/20', 'text-gold-700', 'bg-gold-500'],
                                    'suspended' => ['bg-maroon-100', 'text-maroon-800', 'bg-maroon-600'],
                                    'cancelled' => ['bg-navy-100', 'text-navy-600', 'bg-navy-400'],
                                    'expired' => ['bg-navy-100', 'text-navy-600', 'bg-navy-400'],
                                ];
                                [$bg, $text, $dot] = $statusStyles[$membership->status] ?? ['bg-navy-100', 'text-navy-600', 'bg-navy-400'];
                            @endphp
                            <span class="inline-flex items-center gap-1.5 rounded-full {{ $bg }} px-2.5 py-1 text-xs font-semibold {{ $text }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $dot }}" aria-hidden="true"></span>
                                {{ ucfirst($membership->status) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Visibility</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $membership->is_public ? 'Public — shown on the alumni profile' : 'Private — admin only' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Leaderboard</dt>
                        <dd class="mt-1 text-sm text-navy-950">
                            <span class="font-semibold {{ $membership->show_on_leaderboard ? 'text-emerald-700' : 'text-maroon-700' }}">
                                {{ $membership->show_on_leaderboard ? 'Visible' : 'Hidden' }}
                            </span>
                            @if ($membership->verifiedContributionTotal() > 0)
                                — Verified contribution ৳{{ number_format($membership->verifiedContributionTotal()) }}
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Joined Date</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $membership->joined_at?->format('M j, Y') ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Approved Date</dt>
                        <dd class="mt-1 text-sm text-navy-950">{{ $membership->approved_at?->format('M j, Y') ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Admin Notes</dt>
                        <dd class="mt-1 text-sm leading-relaxed text-navy-950">{{ $membership->notes ?: 'No notes recorded.' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Current Applicable Fee</dt>
                        <dd class="mt-1 text-sm font-semibold text-navy-950">
                            @if ($currentFee)
                                {{ $currentFee->formattedAmount() }} — {{ $currentFee->frequencyLabel() }}
                                @if ($currentFee->amount == 0)
                                    <span class="block mt-1 text-xs font-normal text-ink-soft">{{ $currentFee->description }}</span>
                                @endif
                            @else
                                <span class="font-normal text-ink-soft">No active fee plan</span>
                            @endif
                        </dd>
                    </div>
                </dl>

                <div class="mt-10 flex flex-wrap items-center gap-3 border-t border-navy-100 pt-8">
                    <x-button href="{{ route('admin.members.edit', $membership) }}" variant="navy">Edit Membership</x-button>

                    <form method="POST" action="{{ route('admin.members.public-toggle', $membership) }}">
                        @csrf
                        <x-button type="submit" variant="{{ $membership->is_public ? 'outline' : 'gold' }}">
                            {{ $membership->is_public ? 'Hide Publicly' : 'Show Publicly' }}
                        </x-button>
                    </form>

                    @if ($membership->status === \App\Models\Membership::STATUS_ACTIVE)
                        <form method="POST" action="{{ route('admin.members.suspend', $membership) }}">
                            @csrf
                            <x-button type="submit" variant="outline">Suspend</x-button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.members.activate', $membership) }}">
                            @csrf
                            <x-button type="submit" variant="gold">Activate</x-button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('admin.members.destroy', $membership) }}" onsubmit="return confirm('Delete membership {{ $membership->membership_number }}? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="focus-ring inline-flex items-center rounded-md px-3.5 py-2 text-sm font-semibold text-maroon-600 transition-colors hover:bg-maroon-50">
                            Delete
                        </button>
                    </form>
                </div>
            </section>

            {{-- Member Portal Account (Feature 19) --}}
            <section class="mt-8 rounded-lg border border-navy-100 bg-white p-8 shadow-sm sm:p-10">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h2 class="font-serif text-xl font-semibold text-navy-950">Member Portal Account</h2>
                        <p class="mt-1 text-sm text-ink-soft">Linked user account for the member portal.</p>
                    </div>
                </div>

                <dl class="mt-6 grid gap-x-8 gap-y-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Account Status</dt>
                        <dd class="mt-1">
                            @if ($membership->alumni?->user)
                                <span class="inline-flex items-center gap-1.5 rounded-full {{ $membership->alumni->user->isDisabled() ? 'bg-red-100 text-red-800' : 'bg-emerald-100 text-emerald-800' }} px-2.5 py-1 text-xs font-semibold">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $membership->alumni->user->isDisabled() ? 'bg-red-500' : 'bg-emerald-500' }}" aria-hidden="true"></span>
                                    {{ $membership->alumni->user->isDisabled() ? 'Disabled' : 'Active' }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-xs font-semibold text-navy-600">
                                    <span class="h-1.5 w-1.5 rounded-full bg-navy-400" aria-hidden="true"></span>
                                    No Account
                                </span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Verification Status</dt>
                        <dd class="mt-1">
                            @if ($membership->alumni?->user)
                                <span class="inline-flex items-center gap-1.5 rounded-full {{ $membership->alumni->user->isVerified() ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }} px-2.5 py-1 text-xs font-semibold">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $membership->alumni->user->isVerified() ? 'bg-emerald-500' : 'bg-amber-500' }}" aria-hidden="true"></span>
                                    {{ $membership->alumni->user->isVerified() ? 'Verified' : 'Unverified' }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-xs font-semibold text-navy-600">
                                    <span class="h-1.5 w-1.5 rounded-full bg-navy-400" aria-hidden="true"></span>
                                    N/A
                                </span>
                            @endif
                        </dd>
                    </div>
                    @if ($membership->alumni?->user)
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Email</dt>
                            <dd class="mt-1 text-sm text-navy-950">{{ $membership->alumni->user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Registered</dt>
                            <dd class="mt-1 text-sm text-navy-950">{{ $membership->alumni->user->created_at->format('M j, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Verified At</dt>
                            <dd class="mt-1 text-sm text-navy-950">{{ $membership->alumni->user->verified_at?->format('M j, Y') ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Last Login</dt>
                            <dd class="mt-1 text-sm text-navy-950">{{ $membership->alumni->user->last_login_at?->format('M j, Y g:ia') ?? 'Never' }}</dd>
                        </div>
                    @endif
                </dl>

                @if ($membership->alumni?->user)
                    <div class="mt-10 flex flex-wrap items-center gap-3 border-t border-navy-100 pt-8">
                        @if ($membership->alumni->user->isVerified())
                            <form method="POST" action="{{ route('admin.members.unverify', $membership) }}" onsubmit="return confirm('Revoke verification for this account? This will restrict their access.');">
                                @csrf
                                <x-button type="submit" variant="outline">Revoke Verification</x-button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.members.verify', $membership) }}">
                                @csrf
                                <x-button type="submit" variant="gold">Verify Account</x-button>
                            </form>
                        @endif

                        @if ($membership->alumni->user->isDisabled())
                            <form method="POST" action="{{ route('admin.members.enable', $membership) }}">
                                @csrf
                                <x-button type="submit" variant="navy">Enable Account</x-button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.members.disable', $membership) }}" onsubmit="return confirm('Disable this account? They will be immediately logged out and unable to log in.');">
                                @csrf
                                <button type="submit" class="focus-ring inline-flex items-center rounded-md px-3.5 py-2 text-sm font-semibold text-maroon-600 transition-colors hover:bg-maroon-50">
                                    Disable Account
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </section>

            {{-- Fee & Payment Summary (Feature 13) --}}
            <section class="mt-8 rounded-lg border border-navy-100 bg-white p-8 shadow-sm sm:p-10">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h2 class="font-serif text-xl font-semibold text-navy-950">Fee & Payment Summary</h2>
                        <p class="mt-1 text-sm text-ink-soft">Manual collections recorded for this member.</p>
                    </div>
                    <x-button href="{{ route('admin.payments.create', ['membership_id' => $membership->id]) }}" variant="gold" size="sm">Record Payment</x-button>
                </div>

                @if ($summary && !$summary['waived'])
                    <dl class="mt-6 grid gap-x-8 gap-y-6 sm:grid-cols-3">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Total Collected</dt>
                            <dd class="mt-1 font-serif text-2xl font-semibold text-emerald-700">৳{{ number_format($summary['collected']) }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Outstanding</dt>
                            <dd class="mt-1 font-serif text-2xl font-semibold {{ $summary['outstanding'] > 0 ? 'text-maroon-700' : 'text-navy-950' }}">৳{{ number_format($summary['outstanding']) }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Payment Count</dt>
                            <dd class="mt-1 font-serif text-2xl font-semibold text-navy-950">{{ number_format($paymentCount) }}</dd>
                        </div>
                    </dl>
                    @if ($summary['overpaid'] > 0)
                        <p class="mt-4 rounded-md bg-gold-500/10 px-4 py-2.5 text-sm font-medium text-gold-700">
                            Overpaid by ৳{{ number_format($summary['overpaid']) }} against the current fee. No refund has been created.
                        </p>
                    @endif
                @elseif ($summary?->waived)
                    <p class="mt-6 rounded-md bg-navy-50 px-4 py-3 text-sm text-navy-700">
                        This obligation has been waived by the association — nothing is outstanding and no cash was collected.
                    </p>
                @else
                    <p class="mt-6 rounded-md bg-navy-50 px-4 py-3 text-sm text-navy-700">
                        No active fee plan applies to this membership type, so there is no outstanding obligation.
                    </p>
                @endif

                @if ($recentPayments->isNotEmpty())
                    <h3 class="mt-8 text-xs font-bold uppercase tracking-wider text-ink-soft">Recent Payments</h3>
                    <ul class="mt-3 divide-y divide-navy-100 rounded-md border border-navy-100">
                        @foreach ($recentPayments as $payment)
                            <li class="flex flex-wrap items-center justify-between gap-3 px-4 py-3 text-sm">
                                <span class="font-mono text-xs font-semibold text-navy-900">{{ $payment->payment_number }}</span>
                                <span class="font-semibold text-navy-950">{{ $payment->formattedAmount() }}</span>
                                @php
                                    $styles = [
                                        'paid' => ['bg-emerald-100', 'text-emerald-800'],
                                        'partial' => ['bg-gold-500/20', 'text-gold-700'],
                                        'waived' => ['bg-navy-100', 'text-navy-600'],
                                        'void' => ['bg-maroon-100', 'text-maroon-800'],
                                    ];
                                    [$bg, $text] = $styles[$payment->status->value] ?? ['bg-navy-100', 'text-navy-600'];
                                @endphp
                                <span class="inline-flex rounded-full {{ $bg }} px-2 py-0.5 text-[11px] font-bold uppercase tracking-wide {{ $text }}">{{ $payment->status->label() }}</span>
                                <span class="text-ink-soft">{{ $payment->paid_at?->format('M j, Y') }}</span>
                                @if ($payment->reference)
                                    <span class="hidden text-xs text-ink-soft sm:inline">{{ $payment->reference }}</span>
                                @endif
                                <a href="{{ route('admin.payments.show', $payment) }}" class="focus-ring rounded font-medium text-maroon-700 hover:text-maroon-900">View</a>
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('admin.payments.index', ['membership_id' => $membership->id]) }}" class="focus-ring mt-4 inline-flex items-center gap-2 rounded-md text-sm font-semibold text-maroon-700 hover:text-maroon-900">
                        View Payment History →
                    </a>
                @else
                    <p class="mt-6 text-sm text-ink-soft">No payments have been recorded for this membership yet.</p>
                @endif
            </section>
        </div>
    </div>
</x-layouts.admin>
