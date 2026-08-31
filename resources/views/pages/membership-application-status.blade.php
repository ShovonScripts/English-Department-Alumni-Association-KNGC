<x-layouts.app title="Application Status" description="Track the status of your EDAA-KNGC membership application.">

    @push('head')
        <meta name="robots" content="noindex, nofollow">
    @endpush

    <x-page-header
        title="Application Status"
        description="Track the progress of your membership application."
        eyebrow="Status"
        :breadcrumbs="[
            ['label' => 'Membership', 'href' => route('membership')],
            ['label' => 'Application Status'],
        ]"
    />

    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="mx-auto max-w-xl">
                @if (session('application_submitted'))
                    <div class="mb-6 flex items-start gap-3 rounded-lg border border-green-200 bg-green-50 p-5 text-green-800" role="status">
                        <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-semibold">Application Submitted</p>
                            <p class="mt-1 text-sm">Your membership application has been received and is being processed.</p>
                        </div>
                    </div>
                @endif

                <div class="rounded-xl border border-navy-100 bg-white p-8 shadow-sm sm:p-10">
                    <div class="text-center">
                        <span class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-navy-900 font-serif text-lg font-bold text-gold-300">
                            {{ strtoupper(substr($application->application_number, -4)) }}
                        </span>
                        <h2 class="mt-4 font-serif text-2xl font-semibold text-navy-950">Application {{ $application->application_number }}</h2>
                        <p class="mt-2 text-sm text-ink-soft">
                            Submitted {{ $application->submitted_at->format('d M Y') }}
                        </p>
                    </div>

                    {{-- Status Badge --}}
                    <div class="mt-6 flex justify-center">
                        @php
                            $statusColor = match($application->status->value) {
                                'pending' => 'bg-gold-100 text-gold-800 border-gold-300',
                                'under_review' => 'bg-navy-100 text-navy-800 border-navy-300',
                                'approved' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                'rejected' => 'bg-maroon-100 text-maroon-800 border-maroon-300',
                                'changes_requested' => 'bg-amber-100 text-amber-800 border-amber-300',
                                'cancelled' => 'bg-navy-100 text-navy-800 border-navy-300',
                                default => 'bg-navy-100 text-navy-800 border-navy-300',
                            };
                        @endphp
                        <span class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-sm font-semibold {{ $statusColor }}">
                            {{ $application->status->label() }}
                        </span>
                    </div>

                    {{-- Application Details --}}
                    <div class="mt-8 space-y-4 text-sm">
                        <div class="flex items-center justify-between border-b border-navy-100 pb-3">
                            <span class="text-ink-soft">Membership Type</span>
                            <span class="font-medium text-navy-950">{{ $application->membershipType->name ?? '—' }}</span>
                        </div>
                        @if ($application->requestedTier)
                            <div class="flex items-center justify-between border-b border-navy-100 pb-3">
                                <span class="text-ink-soft">Requested Tier</span>
                                <span class="font-medium text-navy-950">{{ $application->requestedTier->name }}</span>
                            </div>
                        @endif
                        <div class="flex items-center justify-between border-b border-navy-100 pb-3">
                            <span class="text-ink-soft">Submitted</span>
                            <span class="font-medium text-navy-950">{{ $application->submitted_at->format('d M Y, h:i A') }}</span>
                        </div>
                    </div>

                    {{-- Next Steps --}}
                    <div class="mt-8 rounded-lg bg-cream p-6">
                        <h3 class="font-semibold text-navy-950">What happens next?</h3>
                        <div class="mt-3 space-y-2 text-sm text-ink-soft">
                            @switch($application->status->value)
                                @case('pending')
                                    <p>Your application is in the queue and will be reviewed by the Executive Committee. This typically takes a few business days.</p>
                                    @break
                                @case('under_review')
                                    <p>Your application is currently being reviewed by the Executive Committee. You will be notified of any updates.</p>
                                    @break
                                @case('approved')
                                    <p>Congratulations! Your membership has been approved. You will receive further instructions regarding fee payment and onboarding.</p>
                                    @break
                                @case('rejected')
                                    <p>We appreciate your interest. Unfortunately, your application was not approved at this time. You may reapply in the future.</p>
                                    @break
                                @case('changes_requested')
                                    <p>The committee has requested changes or additional information. Please check your email for details and resubmit when ready.</p>
                                    @break
                                @default
                                    <p>Your application status has been updated. Please check back later for more information.</p>
                            @endswitch
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
