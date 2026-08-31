<x-layouts.app
    :title="'Home'"
    :description="'The English Department Alumni Association KNGC connects graduates, students, and teachers through a shared love of language, literature, and lifelong community.'"
>

    {{-- 1. Hero --}}
    <section class="relative overflow-hidden bg-navy-950 text-white">
        <div class="pointer-events-none absolute inset-0 opacity-[0.07]" aria-hidden="true">
            <div class="absolute -right-32 -top-32 h-[28rem] w-[28rem] rounded-full border-2 border-gold-400"></div>
            <div class="absolute -right-10 top-24 h-72 w-72 rounded-full border border-white/50"></div>
            <div class="absolute -left-24 bottom-0 h-80 w-80 rounded-full border border-maroon-500/70"></div>
            <div class="absolute bottom-24 left-1/3 h-40 w-40 rounded-full border border-gold-500/50"></div>
        </div>

        <div class="container-page relative grid items-center gap-12 py-20 sm:py-28 lg:grid-cols-12 lg:py-36">
            <div class="lg:col-span-8">
                <p class="mb-5 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.25em] text-gold-300">
                    <span class="inline-block h-px w-10 bg-gold-500" aria-hidden="true"></span>
                    {{ config('site.name') }}
                </p>

                <h1 class="font-serif text-4xl font-semibold leading-[1.08] tracking-tight sm:text-6xl lg:text-7xl">
                    Connected by English.<br>
                    <span class="italic text-gold-300">United by Memories.</span>
                </h1>

                <p class="mt-7 max-w-2xl text-base leading-relaxed text-navy-100 sm:text-lg">
                    The {{ config('site.name') }} unites graduates, current students, and teachers of the English Department of Kabi Nazrul Government College, Dhaka — a non-political, non-profit family built on language, literature, and lifelong welfare.
                </p>

                <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                    <x-button href="{{ route('alumni.index') }}" variant="gold" size="lg" :icon="true">
                        Explore Our Alumni
                    </x-button>
                    <x-button href="{{ route('about') }}" variant="outline-on-dark" size="lg">
                        Learn About the Association
                    </x-button>
                </div>
            </div>

            <div class="hidden lg:col-span-4 lg:block">
                <div class="relative mx-auto max-w-sm">
                    <div class="flex aspect-square items-center justify-center rounded-2xl border border-white/15 bg-white/5 backdrop-blur-md shadow-2xl shadow-black/20">
                        <div class="text-center">
                            <span class="mx-auto flex h-20 w-20 items-center justify-center rounded-xl bg-maroon-700 font-serif text-lg font-bold tracking-wide text-white ring-2 ring-gold-500/60">
                                KNGC
                            </span>
                            <p class="mt-6 font-serif text-2xl italic text-gold-300">Est. 1874</p>
                            <p class="mt-2 text-sm uppercase tracking-[0.2em] text-navy-200">English Dept. Alumni</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. About the Association --}}
    <section class="section-pad bg-white">
        <div class="container-page grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            <div>
                <x-section-heading
                    eyebrow="About the Association"
                    title="A lifelong home for lovers of language and literature"
                    description="Rooted in an institution that has served learners in Laxmi Bazar since 1874, the English Department Alumni Association KNGC unites graduates in a non-political, non-profit community. We support current students, organise cultural and humanitarian activities, and nurture a professional network that spans classrooms, careers, and continents."
                />

                <ul class="mt-8 space-y-4">
                    @foreach ([
                        ['icon' => 'M17 20h5v-2a3 3 0 00-5.4-1.7M9 20H4v-2a3 3 0 015.4-1.7M16 3.1a3 3 0 110 5.8M11 7a3 3 0 11-6 0 3 3 0 016 0z', 'text' => 'Fostering lifelong connections between alumni, students, and faculty.'],
                        ['icon' => 'M12 6.3v11.4m0-11.4A3.2 3.2 0 009.5 3.5H6.5v13h3a3.2 3.2 0 013 2.8m-.5-12.9a3.2 3.2 0 012.5-2.8h3v13h-3a3.2 3.2 0 00-3 2.8m0-12.9v11.4', 'text' => 'Celebrating scholarship, mentorship, and the written word.'],
                        ['icon' => 'M17 20h5v-2a3 3 0 00-3-3 3 3 0 00-1 .17M14 20H9m5-13a3 3 0 11-6 0 3 3 0 016 0zm5 7.5a3 3 0 10-6 0', 'text' => 'Building a professional network that supports careers and community.'],
                    ] as $item)
                        <li class="flex items-start gap-4">
                            <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-navy-900 text-gold-300">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                                </svg>
                            </span>
                            <p class="text-base leading-relaxed text-ink-soft">{{ $item['text'] }}</p>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-9">
                    <x-button href="{{ route('about') }}" variant="outline" :icon="true">More About Us</x-button>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -left-6 -top-6 hidden h-40 w-40 rounded-lg border-2 border-gold-400/40 sm:block" aria-hidden="true"></div>
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-navy-800/80 via-navy-900/80 to-maroon-900/80 p-10 backdrop-blur-md shadow-2xl shadow-navy-950/30 sm:p-14">
                    <div class="flex h-full flex-col justify-between gap-10">
                        <div>
                            <p class="font-serif text-5xl italic leading-tight text-white sm:text-6xl">"</p>
                            <blockquote class="mt-4 font-serif text-2xl italic leading-snug text-navy-100 sm:text-3xl">
                                The Department shaped our minds; the Association keeps our hearts together.
                            </blockquote>
                        </div>
                        <div>
                            <p class="font-semibold text-gold-300">Dr. Grace Adeyemi</p>
                            <p class="mt-1 text-sm text-navy-200">Past President, EDAA · Class of 1987</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. Key Statistics --}}
    <section class="bg-cream py-16 sm:py-20">
        <div class="container-page">
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <x-stat value="1874" label="Institution Established" accent />
                <x-stat value="150+" label="Years of Academic Heritage" />
                <x-stat value="3" label="Membership Categories" />
                <x-stat value="21+" label="Executive Committee Posts" />
            </div>
        </div>
    </section>

    {{-- 4. Committee Preview --}}
    @if ($committeeMembers->isNotEmpty())
        <section class="section-pad bg-white">
            <div class="container-page">
                <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                    <x-section-heading
                        eyebrow="Leadership"
                        title="Meet the executive committee"
                        description="The volunteers who guide our community and keep the association running."
                    />
                    <x-button href="{{ route('committee.index') }}" variant="outline">View Full Committee</x-button>
                </div>

                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($committeeMembers as $member)
                        <a href="{{ route('committee.show', $member) }}" class="group">
                            <article class="card-lift shine glow-top flex h-full flex-col rounded-xl border border-white/20 bg-white/80 p-8 shadow-sm backdrop-blur-sm transition-colors group-hover:border-gold-500/40">
                                <div class="flex items-center gap-5">
                                    @if ($member->profile_photo_url)
                                        <img src="{{ $member->profile_photo_url }}" alt="{{ $member->name }}" class="h-14 w-14 rounded-full object-cover ring-2 ring-gold-500/40">
                                    @else
                                        <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-maroon-700 font-serif text-base font-semibold text-white" aria-hidden="true">
                                            {{ \Illuminate\Support\Str::initials($member->name) }}
                                        </span>
                                    @endif
                                    <div>
                                        <h3 class="font-serif text-lg font-semibold text-navy-950 group-hover:text-maroon-700">{{ $member->name }}</h3>
                                        <p class="text-sm font-medium uppercase tracking-wide text-maroon-600">{{ $member->position }}</p>
                                    </div>
                                </div>

                                @if ($member->short_bio)
                                    <p class="mt-4 flex-1 text-sm leading-relaxed text-ink-soft">{{ $member->short_bio }}</p>
                                @endif
                            </article>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- 5. Upcoming Events --}}
    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                <x-section-heading
                    eyebrow="Upcoming Events"
                    title="What's happening in our community"
                    description="Lectures, reunions, and literary evenings — there is always a reason to come home."
                />
                <x-button href="{{ route('events.index') }}" variant="outline">View All Events</x-button>
            </div>

            @if ($upcomingEvents->isNotEmpty())
                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($upcomingEvents as $event)
                        <x-event-card
                            :title="$event->title"
                            :date="$event->event_date"
                            :time="$event->formatted_time"
                            :location="$event->venue"
                            :category="$event->category?->name"
                            :href="route('events.show', $event)"
                        />
                    @endforeach
                </div>
            @else
                <div class="mt-12">
                    <x-empty-state
                        title="No upcoming events"
                        description="Check back soon for our next gathering."
                        compact
                    />
                </div>
            @endif
        </div>
    </section>

    {{-- 6. Featured Alumni --}}
    <section class="bg-navy-950 py-16 text-white sm:py-20 lg:py-24">
        <div class="container-page">
            <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                <x-section-heading
                    eyebrow="Featured Alumni"
                    title="Where our graduates have landed"
                    description="From acclaimed writers to educators and cultural leaders, our alumni carry the Department's name across the world."
                    dark
                />
                <x-button href="{{ route('alumni.index') }}" variant="light">Meet More Alumni</x-button>
            </div>

            @if ($featuredAlumni->isNotEmpty())
                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($featuredAlumni as $alumnus)
                        <x-alumni-card
                            :name="$alumnus->full_name"
                            :graduation_year="$alumnus->graduation_year"
                            :role="$alumnus->designation"
                            :field="$alumnus->organization"
                            :image="$alumnus->profile_photo_url"
                            :batch="$alumnus->batch"
                            :country="$alumnus->country"
                            :membership_type="$alumnus->publicMembership?->type"
                            :membership_tier="$alumnus->publicMembership?->tier"
                            href="{{ route('alumni.show', $alumnus) }}"
                        />
                    @endforeach
                </div>
            @else
                <div class="mt-12">
                    <x-empty-state
                        title="Featured alumni coming soon"
                        description="We are adding stories from featured graduates. Check back soon to meet them."
                        compact
                    />
                </div>
            @endif
        </div>
    </section>

    {{-- 6b. Our Members --}}
    @if ($publicMembers->isNotEmpty())
        <section class="section-pad bg-white">
            <div class="container-page">
                <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                    <x-section-heading
                        eyebrow="Our Members"
                        title="Meet our members"
                        description="Alumni who are part of the EDAA-KNGC family."
                    />
                    <x-button href="{{ route('members.index') }}" variant="outline">View All Members</x-button>
                </div>

                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($publicMembers as $membership)
                        <x-member-card :alumni="$membership->alumni" :membership="$membership" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- 7. Latest News --}}
    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                <x-section-heading
                    eyebrow="Latest News"
                    title="From the Department and the Association"
                    description="Updates, announcements, and notes from the community."
                />
                <x-button href="{{ route('news.index') }}" variant="outline">All News</x-button>
            </div>

            @if ($latestNews->isNotEmpty())
                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($latestNews as $article)
                        <x-news-card
                            :title="$article->title"
                            :excerpt="$article->excerpt"
                            :date="$article->published_at"
                            :category="$article->category?->name"
                            :author="$article->author_name"
                            :href="route('news.show', $article)"
                            :image="$article->featured_image_url"
                        />
                    @endforeach
                </div>
            @else
                <div class="mt-12">
                    <x-empty-state
                        title="No news yet"
                        description="Check back soon for updates from the association."
                        compact
                    />
                </div>
            @endif
        </div>
    </section>

    {{-- 8. Alumni Stories --}}
    <section class="bg-cream py-16 sm:py-20 lg:py-24">
        <div class="container-page">
            <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                <x-section-heading
                    eyebrow="Alumni Stories"
                    title="Memories worth sharing"
                    description="Short reflections from alumni on what the English Department has meant to them."
                />
                <x-button href="{{ route('stories.index') }}" variant="outline">Read All Stories</x-button>
            </div>

            @if ($latestStories->isNotEmpty())
                <div class="mt-12 grid gap-6 lg:grid-cols-3">
                    @foreach ($latestStories as $story)
                        <x-story-card
                            :name="$story->alumni?->full_name"
                            :graduation_year="$story->alumni?->graduation_year"
                            :quote="$story->excerpt"
                            :role="$story->alumni?->designation"
                            :image="$story->cover_image_url"
                            :href="route('stories.show', $story)"
                        />
                    @endforeach
                </div>
            @else
                <div class="mt-12">
                    <x-empty-state
                        title="No stories yet"
                        description="Alumni stories will appear here once they are published."
                    />
                </div>
            @endif
        </div>
    </section>

    {{-- 9. Gallery Preview --}}
    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                <x-section-heading
                    eyebrow="Gallery"
                    title="Moments from our community"
                    description="A glimpse of reunions, lectures, and celebrations."
                />
                <x-button href="{{ route('gallery.index') }}" variant="outline">View Gallery</x-button>
            </div>

            @if ($latestAlbums->isNotEmpty())
                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($latestAlbums as $album)
                        <x-gallery-card
                            :title="$album->title"
                            :category="$album->event?->title"
                            :image="$album->cover_image_url"
                            :count="$album->photos_count"
                            :href="route('gallery.show', $album)"
                        />
                    @endforeach
                </div>
            @else
                <div class="mt-12">
                    <x-empty-state
                        title="No albums yet"
                        description="Photo albums will appear here once they are published."
                    />
                </div>
            @endif
        </div>
    </section>

    {{-- 10. Publications --}}
    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                <x-section-heading
                    eyebrow="Publications"
                    title="Reports, magazines & research"
                    description="Browse our collection of departmental publications and research documents."
                />
                <x-button href="{{ route('publications.index') }}" variant="outline">View All</x-button>
            </div>

            @if ($latestPublications->isNotEmpty())
                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($latestPublications as $pub)
                        <x-publication-card
                            :title="$pub->title"
                            :type="$pub->category?->name"
                            :author="$pub->author"
                            :year="$pub->publication_date?->format('Y')"
                            :description="$pub->description"
                            :href="route('publications.show', $pub)"
                        />
                    @endforeach
                </div>
            @else
                <div class="mt-12">
                    <x-empty-state
                        title="No publications yet"
                        description="Publications will appear here once they are published."
                    />
                </div>
            @endif
        </div>
    </section>

    {{-- 10b. Member Leaderboard (Feature 14) — top verified contributors --}}
    @if ($leaderboardEnabled)
        <section class="bg-cream py-16 sm:py-20" aria-labelledby="home-leaderboard-heading">
            <div class="container-page">
                <x-section-heading
                    eyebrow="Member Leaderboard"
                    title="Recognizing our contributors"
                    description="Members who have made verified financial contributions to EDAA-KNGC."
                />

                @if ($topContributors->isEmpty())
                    <div class="mx-auto mt-10 max-w-xl rounded-lg border border-navy-100 bg-white p-8 text-center shadow-sm">
                        <p class="font-serif text-lg font-semibold text-navy-950">No contributors yet</p>
                        <p class="mt-2 text-sm text-ink-soft">Verified member contributions will be recognized here once recorded.</p>
                    </div>
                @else
                    <ol class="mx-auto mt-10 grid max-w-4xl gap-5 sm:grid-cols-3">
                        @foreach ($topContributors as $contributor)
                            <li
                                @class([
                                    'rounded-lg border bg-white p-6 text-center shadow-sm',
                                    'border-gold-400 ring-1 ring-gold-400/50' => $loop->first,
                                    'border-navy-100' => ! $loop->first,
                                ])
                            >
                                <span
                                    @class([
                                        'inline-flex h-9 w-9 items-center justify-center rounded-full font-serif text-sm font-bold',
                                        'bg-gold-500 text-navy-950' => $loop->first,
                                        'bg-navy-900 text-gold-300' => ! $loop->first,
                                    ])
                                >{{ $contributor->leaderboard_rank }}</span>
                                <span class="sr-only">{{ \Illuminate\Support\Number::ordinal($contributor->leaderboard_rank) }} place</span>

                                <p class="mt-3 truncate font-serif text-base font-semibold text-navy-950" title="{{ $contributor->alumni_name }}">
                                    {{ $contributor->alumni_name }}
                                </p>
                                <p class="mt-0.5 truncate text-xs font-medium uppercase tracking-wider text-ink-soft">
                                    {{ $contributor->tier_name ?? 'Member' }}
                                </p>
                                <p class="mt-3 text-[11px] font-semibold uppercase tracking-widest text-maroon-700">Verified Contribution</p>
                                <p class="text-lg font-bold tabular-nums text-navy-950">{{ $contributor->formatted_contribution }}</p>
                            </li>
                        @endforeach
                    </ol>
                @endif

                @if ($leaderboardEnabled)
                    <div class="mt-9 text-center">
                        <a href="{{ route('leaderboard.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md border border-navy-900 px-5 py-2.5 text-sm font-semibold text-navy-900 transition-colors hover:bg-navy-900 hover:text-gold-300">
                            View Full Leaderboard →
                        </a>
                    </div>
                @endif
            </div>
        </section>
    @endif

    {{-- 11. Call to Action --}}
    <section class="relative overflow-hidden bg-maroon-700 py-16 text-white sm:py-20">
        <div class="pointer-events-none absolute inset-0 opacity-[0.08]" aria-hidden="true">
            <div class="absolute -right-20 -top-20 h-80 w-80 rounded-full border-2 border-gold-300"></div>
            <div class="absolute bottom-0 left-1/4 h-48 w-48 rounded-full border border-white/50"></div>
        </div>

        <div class="container-page relative text-center">
            <x-section-heading
                eyebrow="Join Us"
                title="Become a member of the EDAA family"
                description="Whether you graduated last year or decades ago, there is a place for you here."
                align="center"
                dark
            />
            <div class="mt-9 flex flex-col justify-center gap-3 sm:flex-row">
                <x-button href="{{ route('membership.apply') }}" variant="gold" size="lg" :icon="true">
                    Become a Member
                </x-button>
                <x-button href="{{ route('events.index') }}" variant="light" size="lg">
                    See Upcoming Events
                </x-button>
            </div>
        </div>
    </section>

</x-layouts.app>