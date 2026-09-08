<x-layouts.app title="Alumni" description="Meet the graduates of the English Department — writers, educators, and leaders across the world.">

    <x-page-header
        title="Our Alumni"
        description="Thousands of graduates, one shared foundation in language and literature. Explore the community that began in our lecture halls."
        eyebrow="The Community"
        :breadcrumbs="[['label' => 'Alumni']]"
    />

    {{-- Highlight strip --}}
    <section class="bg-cream py-12 sm:py-16">
        <div class="container-page grid gap-5 sm:grid-cols-3">
            <x-stat value="{{ number_format($totalAlumni) }}" label="Registered Alumni" />
            <x-stat value="{{ number_format($totalCountries) }}" label="Countries Represented" accent />
            <x-stat value="{{ number_format($totalBatches) }}" label="Alumni Batches" />
        </div>
    </section>

    {{-- Featured alumni --}}
    @if ($featuredAlumni->isNotEmpty())
        <section class="section-pad bg-white">
            <div class="container-page">
                <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                    <x-section-heading
                        eyebrow="Featured Alumni"
                        title="Voices of the Department"
                        description="A selection of graduates who continue to carry the English Department's name across the world."
                    />
                </div>

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
            </div>
        </section>
    @endif

    {{-- Searchable directory --}}
    <section class="section-pad bg-cream">
        <div class="container-page">
            <x-section-heading
                eyebrow="Alumni Directory"
                title="Search the community"
                description="Find classmates and colleagues by name, profession, organization, batch, or graduation year."
            />

            <form method="GET" action="{{ route('alumni.index') }}" class="mt-10 rounded-2xl border border-navy-100 bg-white/95 p-6 shadow-sm backdrop-blur-md sm:p-8">
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-5">
                    <div class="lg:col-span-2">
                        <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                        <input
                            type="search"
                            id="search"
                            name="search"
                            value="{{ $filters['search'] }}"
                            placeholder="Name, profession or organization"
                            class="w-full rounded-xl border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"
                        >
                    </div>

                    <div>
                        <label for="batch" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Batch</label>
                        <select id="batch" name="batch" class="w-full rounded-xl border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All batches</option>
                            @foreach ($batches as $batch)
                                <option value="{{ $batch }}" @selected($filters['batch'] == $batch)>Batch {{ $batch }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="graduation_year" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Graduation Year</label>
                        <select id="graduation_year" name="graduation_year" class="w-full rounded-xl border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All years</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}" @selected($filters['graduation_year'] == $year)>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="country" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Country</label>
                        <select id="country" name="country" class="w-full rounded-xl border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All countries</option>
                            @foreach ($countries as $option)
                                <option value="{{ $option }}" @selected($filters['country'] == $option)>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap items-center justify-between gap-4 border-t border-navy-50 pt-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <x-button type="submit" variant="navy" class="rounded-xl px-5">Search Alumni</x-button>
                        @if ($filters['search'] !== '' || $filters['batch'] || $filters['graduation_year'] || $filters['country'])
                            <a href="{{ route('alumni.index') }}" class="focus-ring inline-flex items-center gap-1.5 rounded-xl px-3.5 py-2 text-xs font-bold text-maroon-700 transition-colors hover:bg-maroon-50">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Clear all filters
                            </a>
                        @endif
                    </div>

                    {{-- Active Results Counter --}}
                    <div class="text-xs font-medium text-ink-soft">
                        Showing <span class="font-bold text-navy-950">{{ $alumni->total() }}</span> alumni
                    </div>
                </div>

                {{-- Active Filter Chips --}}
                @if ($filters['search'] || $filters['batch'] || $filters['graduation_year'] || $filters['country'])
                    <div class="mt-4 flex flex-wrap items-center gap-2 border-t border-navy-50 pt-3 text-xs">
                        <span class="font-semibold text-navy-600">Active Filters:</span>
                        @if ($filters['search'])
                            <span class="inline-flex items-center gap-1 rounded-full bg-navy-100 px-3 py-1 font-medium text-navy-900">
                                Keyword: "{{ $filters['search'] }}"
                            </span>
                        @endif
                        @if ($filters['batch'])
                            <span class="inline-flex items-center gap-1 rounded-full bg-gold-100 px-3 py-1 font-semibold text-gold-900">
                                Batch {{ $filters['batch'] }}
                            </span>
                        @endif
                        @if ($filters['graduation_year'])
                            <span class="inline-flex items-center gap-1 rounded-full bg-maroon-100 px-3 py-1 font-semibold text-maroon-900">
                                Year: {{ $filters['graduation_year'] }}
                            </span>
                        @endif
                        @if ($filters['country'])
                            <span class="inline-flex items-center gap-1 rounded-full bg-navy-100 px-3 py-1 font-medium text-navy-900">
                                {{ $filters['country'] }}
                            </span>
                        @endif
                    </div>
                @endif
            </form>

            @if ($alumni->isNotEmpty())
                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($alumni as $alumnus)
                        <x-alumni-card
                            :name="$alumnus->full_name"
                            :graduation_year="$alumnus->graduation_year"
                            :role="$alumnus->designation"
                            :field="$alumnus->organization"
                            :image="$alumnus->profile_photo_url"
                            :batch="$alumnus->batch"
                            :country="$alumnus->country"
                            :bio="$alumnus->bio"
                            :membership_type="$alumnus->publicMembership?->type"
                            :membership_tier="$alumnus->publicMembership?->tier"
                            href="{{ route('alumni.show', $alumnus) }}"
                        />
                    @endforeach
                </div>

                <div class="mt-12 flex justify-center">
                    {{ $alumni->links() }}
                </div>
            @else
                <div class="mt-10">
                    <x-empty-state
                        title="No alumni match your search"
                        description="Try adjusting your search terms or clearing the filters to see the full directory."
                        action_label="Clear all filters"
                        action_href="{{ route('alumni.index') }}"
                    />
                </div>
            @endif
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-white py-16 sm:py-20">
        <div class="container-page">
            <div class="rounded-3xl bg-gradient-to-br from-navy-950 via-navy-900 to-maroon-950 p-10 text-white sm:p-14 shadow-2xl">
                <div class="grid items-center gap-8 lg:grid-cols-2">
                    <div>
                        <x-section-heading
                            eyebrow="Get Listed"
                            title="Want to be part of the directory?"
                            description="Membership is the key to the directory. Register your profile and join the EDAA family as verified alumni."
                            dark
                        />
                    </div>
                    <div class="lg:justify-self-end">
                        <x-button href="{{ route('membership.apply') }}" variant="gold" size="lg" :icon="true">Become a Member</x-button>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>