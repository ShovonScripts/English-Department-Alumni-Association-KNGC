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

            <form method="GET" action="{{ route('alumni.index') }}" class="mt-10 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-5">
                    <div class="lg:col-span-2">
                        <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                        <input
                            type="search"
                            id="search"
                            name="search"
                            value="{{ $filters['search'] }}"
                            placeholder="Name, profession or organization"
                            class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"
                        >
                    </div>

                    <div>
                        <label for="batch" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Batch</label>
                        <select id="batch" name="batch" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All batches</option>
                            @foreach ($batches as $batch)
                                <option value="{{ $batch }}" @selected($filters['batch'] == $batch)>{{ $batch }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="graduation_year" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Graduation Year</label>
                        <select id="graduation_year" name="graduation_year" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All years</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}" @selected($filters['graduation_year'] == $year)>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="country" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Country</label>
                        <select id="country" name="country" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All countries</option>
                            @foreach ($countries as $option)
                                <option value="{{ $option }}" @selected($filters['country'] == $option)>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap items-center gap-3">
                    <x-button type="submit" variant="navy">Search Alumni</x-button>
                    @if ($alumni->total() > 0 || $filters['search'] !== '' || $filters['batch'] || $filters['graduation_year'] || $filters['country'])
                        <a href="{{ route('alumni.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                            Clear filters
                        </a>
                    @endif
                </div>
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
            <div class="rounded-lg bg-navy-950 p-10 text-white sm:p-12">
                <div class="grid items-center gap-8 lg:grid-cols-2">
                    <div>
                        <x-section-heading
                            eyebrow="Get Listed"
                            title="Want to be part of the directory?"
                            description="Membership is the key to the directory. Register your interest and we will invite you to join the Association as new records are added."
                            dark
                        />
                    </div>
                    <div class="lg:justify-self-end">
                        <x-button href="{{ route('contact') }}" variant="gold" :icon="true">Become a Member</x-button>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>