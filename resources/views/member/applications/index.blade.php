<x-layouts.app :title="'My Applications'">
    <section class="bg-navy-950 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-3xl font-bold text-white">Membership Applications</h1>
            <p class="mt-2 text-sm text-white/60">Track your membership application history</p>
        </div>
    </section>

    <section class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <aside class="lg:col-span-1">
                    <div class="rounded-lg border border-navy-100 bg-white p-4 shadow-sm">
                        <x-member.sidebar />
                    </div>
                </aside>

                <main class="lg:col-span-3">
                    <div class="premium-card">
                        <div class="border-b border-navy-100 px-6 py-4 bg-white">
                            <h2 class="font-serif text-lg font-semibold text-navy-950">Applications</h2>
                        </div>

                        @if ($applications->count() > 0)
                            <div class="divide-y divide-navy-50 bg-white">
                                @foreach ($applications as $application)
                                    <div class="px-6 py-5 hover:bg-navy-50/30 transition-colors">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-3">
                                                    <h3 class="text-sm font-medium text-navy-900">{{ $application->membershipType?->name ?? 'Membership' }}</h3>
                                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                                        {{ match($application->status) {
                                                            \App\Enums\ApplicationStatus::Approved => 'bg-emerald-50 text-emerald-700',
                                                            \App\Enums\ApplicationStatus::Pending, \App\Enums\ApplicationStatus::UnderReview => 'bg-amber-50 text-amber-700',
                                                            \App\Enums\ApplicationStatus::Rejected => 'bg-red-50 text-red-700',
                                                            \App\Enums\ApplicationStatus::ChangesRequested => 'bg-blue-50 text-blue-700',
                                                            default => 'bg-navy-50 text-navy-600',
                                                        } }}">
                                                        {{ ucfirst(str_replace('_', ' ', $application->status->value)) }}
                                                    </span>
                                                </div>
                                                <p class="mt-1 text-xs text-ink-soft">Submitted {{ $application->created_at->format('M d, Y') }}</p>
                                                @if ($application->notes)
                                                    <p class="mt-2 text-sm text-ink-soft line-clamp-2 bg-navy-50/50 p-3 rounded border border-navy-50">{{ $application->notes }}</p>
                                                @endif
                                                @if ($application->reviewed_at)
                                                    <p class="mt-2 text-xs text-ink-soft flex items-center gap-1.5"><svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Reviewed on {{ $application->reviewed_at->format('M d, Y') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t border-navy-100 px-6 py-4 bg-white">
                                {{ $applications->withQueryString()->links() }}
                            </div>
                        @else
                            <div class="px-6 py-12 text-center bg-white">
                                <svg class="mx-auto h-12 w-12 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                <p class="mt-3 text-sm text-ink-soft">You haven't submitted any membership applications yet.</p>
                            </div>
                        @endif
                    </div>
                </main>
            </div>
        </div>
    </section>
</x-layouts.app>
