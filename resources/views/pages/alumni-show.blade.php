<x-layouts.app :title="$alumni->full_name . ' | Alumni'" :description="trim($alumni->designation.' · '.$alumni->organization, ' · ')" :image="$alumni->profile_photo_url">

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-navy-950 pt-20 pb-16">
        <div class="absolute inset-0 bg-gradient-to-br from-navy-950 via-navy-900 to-maroon-950/40"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23ffffff%22%20fill-opacity%3D%220.03%22%3E%3Cpath%20d%3D%22M36%2034v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6%2034v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6%204V0H4v4H0v2h4v4h2V6h4V4H6z%22%2F%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E')] opacity-50"></div>

        <div class="container-page relative z-10">
            {{-- Breadcrumb --}}
            <nav class="mb-8" aria-label="Breadcrumb">
                <ol class="flex items-center gap-2 text-xs text-navy-300">
                    <li><a href="{{ route('home') }}" class="transition-colors hover:text-gold-300">Home</a></li>
                    <li><span class="text-navy-500">/</span></li>
                    <li><a href="{{ route('alumni.index') }}" class="transition-colors hover:text-gold-300">Alumni</a></li>
                    <li><span class="text-navy-500">/</span></li>
                    <li class="text-gold-300">{{ $alumni->full_name }}</li>
                </ol>
            </nav>

            <div class="flex flex-col items-center gap-8 text-center sm:flex-row sm:text-left">
                {{-- Avatar --}}
                @if ($alumni->profile_photo_url)
                    <img
                        src="{{ $alumni->profile_photo_url }}"
                        alt="Portrait of {{ $alumni->full_name }}"
                        class="h-32 w-32 shrink-0 rounded-full object-cover ring-4 ring-gold-500/40 shadow-xl shadow-gold-500/10 sm:h-40 sm:w-40"
                    >
                @else
                    <span class="flex h-32 w-32 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-gold-500/20 to-maroon-500/20 font-serif text-4xl font-bold text-gold-300 ring-4 ring-gold-500/40 shadow-xl shadow-gold-500/10 sm:h-40 sm:w-40" aria-hidden="true">
                        {{ \Illuminate\Support\Str::initials($alumni->full_name) }}
                    </span>
                @endif

                <div class="flex-1">
                    <h1 class="font-serif text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ $alumni->full_name }}</h1>

                    @if ($alumni->designation || $alumni->organization)
                        <p class="mt-2 text-lg text-gold-300/90">
                            {{ collect([$alumni->designation, $alumni->organization])->filter()->implode(' at ') }}
                        </p>
                    @endif

                    @if ($alumni->location)
                        <p class="mt-1.5 flex items-center justify-center gap-1.5 text-sm text-navy-200 sm:justify-start">
                            <svg class="h-4 w-4 text-navy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            {{ $alumni->location }}
                        </p>
                    @endif

                    @if ($alumni->publicMembership)
                        <div class="mt-4">
                            <x-membership-badge :type="$alumni->publicMembership->type" :tier="$alumni->publicMembership->tier" />
                        </div>
                    @endif

                    @if ($leaderboard)
                        <div class="mt-4 rounded-md border border-gold-500/40 bg-gold-500/10 px-4 py-3 text-center backdrop-blur-sm">
                            <p class="text-sm font-semibold text-white">
                                <span class="text-gold-300">#{{ $leaderboard['rank'] }}</span>
                                <span class="sr-only">{{ \Illuminate\Support\Number::ordinal($leaderboard['rank']) }} place</span>
                                on Member Leaderboard
                            </p>
                            <p class="mt-2 text-[11px] font-semibold uppercase tracking-widest text-gold-200/70">Verified Contribution</p>
                            <p class="text-base font-bold tabular-nums text-gold-100">৳{{ number_format($leaderboard['contribution']) }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Content --}}
    <section class="section-pad bg-cream">
        <div class="container-page">
            <div class="grid gap-8 lg:grid-cols-3">

                {{-- Sidebar --}}
                <div class="lg:col-span-1">
                    <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm lg:sticky lg:top-8">
                        @if ($alumni->linkedin_url || $alumni->website_url)
                            <h2 class="text-xs font-semibold uppercase tracking-widest text-ink-soft">Links</h2>
                            <ul class="mt-5 space-y-4">
                                @if ($alumni->linkedin_url)
                                    <li>
                                        <a href="{{ \App\Support\UrlHelper::safeHref($alumni->linkedin_url) }}" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-3 rounded-md p-2 -m-2 transition-colors hover:bg-cream">
                                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-navy-50 text-navy-600 transition-colors group-hover:bg-maroon-50 group-hover:text-maroon-700">
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M6.9 8.6H3.6V20h3.3V8.6zM5.3 7.2a1.9 1.9 0 100-3.8 1.9 1.9 0 000 3.8zM20.4 13.4c0-3.3-1.8-4.9-4.2-4.9-1.9 0-2.8 1.1-3.3 1.8V8.6H9.6V20h3.3v-6c0-1.6.8-2.6 2.1-2.6 1.3 0 1.9.9 1.9 2.6v6h3.5v-6.6z" /></svg>
                                            </span>
                                            <span class="text-sm text-navy-950 transition-colors group-hover:text-maroon-700">LinkedIn Profile</span>
                                        </a>
                                    </li>
                                @endif
                                @if ($alumni->website_url)
                                    <li>
                                        <a href="{{ \App\Support\UrlHelper::safeHref($alumni->website_url) }}" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-3 rounded-md p-2 -m-2 transition-colors hover:bg-cream">
                                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-navy-50 text-navy-600 transition-colors group-hover:bg-maroon-50 group-hover:text-maroon-700">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                                            </span>
                                            <span class="text-sm text-navy-950 transition-colors group-hover:text-maroon-700">Personal Website</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        @endif

                        <div class="mt-6 border-t border-navy-100 pt-6">
                            <a href="{{ route('alumni.index') }}" class="focus-ring flex items-center justify-center gap-2 rounded-md border border-navy-200 px-4 py-2.5 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                                Back to Directory
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Main content --}}
                <div class="space-y-8 lg:col-span-2">

                    {{-- Bio --}}
                    @if ($alumni->bio)
                        <div class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                            <h2 class="flex items-center gap-2 font-serif text-lg font-semibold text-navy-950">
                                <svg class="h-5 w-5 text-maroon-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                About
                            </h2>
                            <p class="mt-4 text-[15px] leading-relaxed text-ink-soft">{{ $alumni->bio }}</p>
                        </div>
                    @endif

                    {{-- Quick facts --}}
                    <div class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                        <h2 class="flex items-center gap-2 font-serif text-lg font-semibold text-navy-950">
                            <svg class="h-5 w-5 text-maroon-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            Quick Facts
                        </h2>
                        <dl class="mt-6 grid gap-5 sm:grid-cols-2">
                            @if ($alumni->batch)
                                <div class="flex items-start gap-3 rounded-md bg-cream/60 p-3">
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Batch</dt>
                                    <dd class="ml-auto text-sm font-semibold text-navy-950">{{ $alumni->batch }}</dd>
                                </div>
                            @endif
                            @if ($alumni->session)
                                <div class="flex items-start gap-3 rounded-md bg-cream/60 p-3">
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Session</dt>
                                    <dd class="ml-auto text-sm font-semibold text-navy-950">{{ $alumni->session }}</dd>
                                </div>
                            @endif
                            @if ($alumni->graduation_year)
                                <div class="flex items-start gap-3 rounded-md bg-cream/60 p-3">
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Graduation</dt>
                                    <dd class="ml-auto text-sm font-semibold text-navy-950">{{ $alumni->graduation_year }}</dd>
                                </div>
                            @endif
                            @if ($alumni->degree)
                                <div class="flex items-start gap-3 rounded-md bg-cream/60 p-3">
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Degree</dt>
                                    <dd class="ml-auto text-sm font-semibold text-navy-950">{{ $alumni->degree }}</dd>
                                </div>
                            @endif
                            @if ($alumni->student_id)
                                <div class="flex items-start gap-3 rounded-md bg-cream/60 p-3">
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Student ID</dt>
                                    <dd class="ml-auto font-mono text-sm font-semibold text-navy-950">{{ $alumni->student_id }}</dd>
                                </div>
                            @endif
                            @if ($alumni->profession)
                                <div class="flex items-start gap-3 rounded-md bg-cream/60 p-3">
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Profession</dt>
                                    <dd class="ml-auto text-sm font-semibold text-navy-950">{{ $alumni->profession }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    {{-- Alumni Stories --}}
                    @if ($stories->isNotEmpty())
                        <div class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                            <h2 class="flex items-center gap-2 font-serif text-lg font-semibold text-navy-950">
                                <svg class="h-5 w-5 text-maroon-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                                Alumni Stories
                            </h2>
                            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                                @foreach ($stories as $story)
                                    <a href="{{ route('stories.show', $story) }}" class="group block rounded-lg border border-navy-100 p-5 transition-all duration-200 hover:border-gold-500/40 hover:bg-cream hover:shadow-sm">
                                        <h3 class="font-serif text-base font-semibold text-navy-950 transition-colors group-hover:text-maroon-700">{{ $story->title }}</h3>
                                        <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-ink-soft">{{ $story->excerpt }}</p>
                                        <time class="mt-3 flex items-center gap-1.5 text-xs text-ink-soft" datetime="{{ $story->published_at?->format('Y-m-d') }}">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            {{ $story->published_at?->format('M j, Y') }}
                                        </time>
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
