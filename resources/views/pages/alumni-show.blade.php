<x-layouts.app :title="$alumni->full_name . ' | Alumni'" :description="trim($alumni->designation.' · '.$alumni->organization, ' · ')" :image="$alumni->profile_photo_url">

    <x-page-header
        :title="$alumni->full_name"
        :description="collect([$alumni->designation, $alumni->organization, $alumni->location])->filter()->implode(' · ')"
        eyebrow="Alumni Profile"
        :breadcrumbs="[['label' => 'Alumni', 'url' => route('alumni.index')], ['label' => $alumni->full_name]]"
    />

    <section class="section-pad bg-cream">
        <div class="container-page">
            <div class="grid gap-8 lg:grid-cols-3">
                {{-- Profile card --}}
                <div class="lg:col-span-1">
                    <div class="rounded-lg border border-navy-100 bg-white p-8 text-center shadow-sm lg:sticky lg:top-8">
                        @if ($alumni->profile_photo_url)
                            <img src="{{ $alumni->profile_photo_url }}" alt="Portrait of {{ $alumni->full_name }}" class="mx-auto h-36 w-36 rounded-full object-cover ring-4 ring-gold-500/30">
                        @else
                            <span class="mx-auto flex h-36 w-36 items-center justify-center rounded-full bg-navy-900 font-serif text-4xl font-semibold text-gold-300 ring-4 ring-gold-500/30" aria-hidden="true">
                                {{ \Illuminate\Support\Str::initials($alumni->full_name) }}
                            </span>
                        @endif

                        <h2 class="mt-6 font-serif text-2xl font-semibold text-navy-950">{{ $alumni->full_name }}</h2>

                        @if ($alumni->publicMembership)
                            <div class="mt-3">
                                <x-membership-badge :type="$alumni->publicMembership->type" :tier="$alumni->publicMembership->tier" />
                            </div>
                        @endif

                        {{-- Feature 14 — subtle aggregate acknowledgment, shown
                             only when the member opted into leaderboard display
                             and holds a positive verified contribution. Never
                             exposes individual payment records. --}}
                        @if ($leaderboard)
                            <div class="mt-5 rounded-md border border-gold-500/40 bg-cream px-4 py-3 text-center">
                                <p class="text-sm font-semibold text-navy-950">
                                    <span class="text-maroon-700">#{{ $leaderboard['rank'] }}</span>
                                    <span class="sr-only">{{ \Illuminate\Support\Number::ordinal($leaderboard['rank']) }} place</span>
                                    on Member Leaderboard
                                </p>
                                <p class="mt-2 text-[11px] font-semibold uppercase tracking-widest text-ink-soft">Verified Contribution</p>
                                <p class="text-base font-bold tabular-nums text-navy-950">৳{{ number_format($leaderboard['contribution']) }}</p>
                            </div>
                        @endif

                        @if ($alumni->designation)
                            <p class="mt-1 text-sm font-medium text-maroon-700">{{ $alumni->designation }}</p>
                        @endif

                        @if ($alumni->organization)
                            <p class="mt-1 text-sm text-ink-soft">{{ $alumni->organization }}</p>
                        @endif

                        @if ($alumni->location)
                            <p class="mt-1 text-sm text-ink-soft">{{ $alumni->location }}</p>
                        @endif

                        @if ($alumni->linkedin_url || $alumni->website_url)
                            <div class="mt-7 flex flex-col gap-3">
                                @if ($alumni->linkedin_url)
                                    <x-button href="{{ \App\Support\UrlHelper::safeHref($alumni->linkedin_url) }}" variant="outline" :icon="true" target="_blank" rel="noopener noreferrer">LinkedIn</x-button>
                                @endif
                                @if ($alumni->website_url)
                                    <x-button href="{{ \App\Support\UrlHelper::safeHref($alumni->website_url) }}" variant="outline" :icon="true" target="_blank" rel="noopener noreferrer">Website</x-button>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="mt-6">
                        <x-button href="{{ route('alumni.index') }}" variant="navy">Back to Directory</x-button>
                    </div>
                </div>

                {{-- Details --}}
                <div class="lg:col-span-2">
                    @if ($alumni->bio)
                        <div class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                            <h2 class="font-serif text-xl font-semibold text-navy-950">About</h2>
                            <p class="mt-4 text-base leading-relaxed text-ink-soft">{{ $alumni->bio }}</p>
                        </div>
                    @endif

                    <div class="mt-8 rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                        <h2 class="font-serif text-xl font-semibold text-navy-950">Academic Record</h2>
                        <dl class="mt-6 grid gap-x-8 gap-y-6 sm:grid-cols-2">
                            @if ($alumni->degree)
                                <div>
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Degree</dt>
                                    <dd class="mt-1 text-sm text-navy-950">{{ $alumni->degree }}</dd>
                                </div>
                            @endif
                            @if ($alumni->batch)
                                <div>
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Batch</dt>
                                    <dd class="mt-1 text-sm text-navy-950">{{ $alumni->batch }}</dd>
                                </div>
                            @endif
                            @if ($alumni->session)
                                <div>
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Session</dt>
                                    <dd class="mt-1 text-sm text-navy-950">{{ $alumni->session }}</dd>
                                </div>
                            @endif
                            @if ($alumni->graduation_year)
                                <div>
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Graduation Year</dt>
                                    <dd class="mt-1 text-sm text-navy-950">{{ $alumni->graduation_year }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <div class="mt-8 rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                        <h2 class="font-serif text-xl font-semibold text-navy-950">Career</h2>
                        <dl class="mt-6 grid gap-x-8 gap-y-6 sm:grid-cols-2">
                            @if ($alumni->profession)
                                <div>
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Profession</dt>
                                    <dd class="mt-1 text-sm text-navy-950">{{ $alumni->profession }}</dd>
                                </div>
                            @endif
                            @if ($alumni->designation)
                                <div>
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Designation</dt>
                                    <dd class="mt-1 text-sm text-navy-950">{{ $alumni->designation }}</dd>
                                </div>
                            @endif
                            @if ($alumni->organization)
                                <div>
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Organization</dt>
                                    <dd class="mt-1 text-sm text-navy-950">{{ $alumni->organization }}</dd>
                                </div>
                            @endif
                            @if ($alumni->location)
                                <div>
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Location</dt>
                                    <dd class="mt-1 text-sm text-navy-950">{{ $alumni->location }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    @if ($stories->isNotEmpty())
                        <div class="mt-8 rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                            <h2 class="font-serif text-xl font-semibold text-navy-950">Alumni Stories</h2>
                            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                                @foreach ($stories as $story)
                                    <a href="{{ route('stories.show', $story) }}" class="group block rounded-lg border border-navy-100 p-4 transition-colors hover:border-gold-500/40 hover:bg-cream">
                                        <h3 class="font-serif text-base font-semibold text-navy-950 transition-colors group-hover:text-maroon-700">{{ $story->title }}</h3>
                                        <p class="mt-1 line-clamp-2 text-sm text-ink-soft">{{ $story->excerpt }}</p>
                                        <time class="mt-2 block text-xs text-ink-soft" datetime="{{ $story->published_at?->format('Y-m-d') }}">{{ $story->published_at?->format('M j, Y') }}</time>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>