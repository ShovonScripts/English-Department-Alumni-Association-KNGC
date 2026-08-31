<x-layouts.app
    :title="'Executive Committee'"
    :description="'Meet the executive committee that keeps the English Department Alumni Association KNGC running.'"
>

    <x-page-header
        title="Executive Committee"
        description="Volunteers who dedicate their time to keeping our community connected, organised, and growing."
        eyebrow="Leadership"
        :breadcrumbs="[['label' => 'Committee']]"
    />

    <section class="section-pad bg-white">
        <div class="container-page">
            @if ($members->isEmpty())
                <x-empty-state
                    title="Committee coming soon"
                    description="We are currently assembling the executive committee. Check back soon to meet the team."
                    compact
                />
            @else
                @php
                    $leader = $members->first();
                    $rest = $members->slice(1);
                @endphp

                {{-- Leadership card --}}
                <div class="mb-16">
                    <div class="mx-auto max-w-2xl">
                        <article class="card-lift relative flex flex-col items-center rounded-xl border border-navy-100 bg-white p-10 text-center shadow-sm sm:p-14">
                            <a href="{{ route('committee.show', $leader) }}" class="focus-ring absolute inset-0 rounded-xl" aria-label="View {{ $leader->name }}'s profile"></a>

                            @if ($leader->profile_photo_url)
                                <img src="{{ $leader->profile_photo_url }}" alt="Portrait of {{ $leader->name }}" class="h-28 w-28 rounded-full object-cover ring-4 ring-gold-500/30">
                            @else
                                <span class="flex h-28 w-28 items-center justify-center rounded-full bg-maroon-700 font-serif text-3xl font-semibold text-white ring-4 ring-gold-500/30" aria-hidden="true">
                                    {{ \Illuminate\Support\Str::initials($leader->name) }}
                                </span>
                            @endif

                            <h2 class="mt-6 font-serif text-2xl font-semibold text-navy-950">{{ $leader->name }}</h2>
                            <p class="mt-1 text-sm font-medium uppercase tracking-wide text-maroon-600">{{ $leader->position }}</p>

                            @if ($leader->short_bio)
                                <p class="mt-4 max-w-md text-sm leading-relaxed text-ink-soft">{{ $leader->short_bio }}</p>
                            @endif

                            <div class="relative z-10 mt-6 flex items-center justify-center gap-3">
                                @if ($leader->linkedin_url)
                                    <a href="{{ \App\Support\UrlHelper::safeHref($leader->linkedin_url) }}" target="_blank" rel="noopener noreferrer" class="focus-ring inline-flex h-10 w-10 items-center justify-center rounded-full border border-navy-200 text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900" aria-label="LinkedIn">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                        </svg>
                                    </a>
                                @endif
                                @if ($leader->website_url)
                                    <a href="{{ \App\Support\UrlHelper::safeHref($leader->website_url) }}" target="_blank" rel="noopener noreferrer" class="focus-ring inline-flex h-10 w-10 items-center justify-center rounded-full border border-navy-200 text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900" aria-label="Website">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </article>
                    </div>
                </div>

                @if ($rest->isNotEmpty())
                    <x-section-heading
                        eyebrow="Executive Members"
                        title="The team behind the mission"
                        description="Dedicated members who bring experience and commitment to the association."
                    />

                    <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($rest as $member)
                            <a href="{{ route('committee.show', $member) }}" class="group">
                                <article class="card-lift flex h-full flex-col rounded-lg border border-navy-100 bg-white p-8 shadow-sm transition-colors group-hover:border-gold-500/40">
                                    <div class="flex items-center gap-5">
                                        @if ($member->profile_photo_url)
                                            <img src="{{ $member->profile_photo_url }}" alt="{{ $member->name }}" class="h-16 w-16 rounded-full object-cover ring-2 ring-gold-500/40">
                                        @else
                                            <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-maroon-700 font-serif text-lg font-semibold text-white" aria-hidden="true">
                                                {{ \Illuminate\Support\Str::initials($member->name) }}
                                            </span>
                                        @endif
                                        <div>
                                            <h3 class="font-serif text-lg font-semibold text-navy-950 group-hover:text-maroon-700">{{ $member->name }}</h3>
                                            <p class="text-sm font-medium uppercase tracking-wide text-maroon-600">{{ $member->position }}</p>
                                        </div>
                                    </div>

                                    @if ($member->short_bio)
                                        <p class="mt-4 flex-1 text-sm leading-relaxed text-ink-soft">
                                            {{ $member->short_bio }}
                                        </p>
                                    @endif

                                    <div class="mt-4 flex items-center gap-2 text-xs font-semibold text-navy-600">
                                        View Profile
                                        <svg class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </article>
                            </a>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
    </section>

    {{-- CTA --}}
    <section class="relative overflow-hidden bg-maroon-700 py-16 text-white sm:py-20">
        <div class="pointer-events-none absolute inset-0 opacity-[0.08]" aria-hidden="true">
            <div class="absolute -right-20 -top-20 h-80 w-80 rounded-full border-2 border-gold-300"></div>
        </div>
        <div class="container-page relative flex flex-col items-center justify-between gap-8 text-center sm:flex-row sm:text-left">
            <div class="max-w-xl">
                <h2 class="font-serif text-3xl font-semibold sm:text-4xl">Want to give back to the community?</h2>
                <p class="mt-3 text-maroon-100">We are always looking for enthusiastic members to join sub-committees and volunteer teams.</p>
            </div>
            <x-button href="{{ route('contact') }}" variant="gold" size="lg" :icon="true">Volunteer with Us</x-button>
        </div>
    </section>

</x-layouts.app>
