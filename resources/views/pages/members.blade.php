<x-layouts.app title="Members" description="Browse the public member directory of the English Department Alumni Association KNGC. Find alumni by name, batch, profession, and more.">

    <x-page-header
        title="Member Directory"
        description="Meet the alumni who form the backbone of the English Department Alumni Association KNGC."
        eyebrow="Our Community"
        :breadcrumbs="[['label' => 'Members']]"
    />

    {{-- Statistics --}}
    <section class="bg-cream py-12 sm:py-16">
        <div class="container-page grid gap-5 sm:grid-cols-2 lg:grid-cols-5">
            <x-stat value="{{ number_format($stats['total_members']) }}" label="Public Members" accent />
            <x-stat value="{{ number_format($stats['total_types']) }}" label="Membership Types" />
            <x-stat value="{{ number_format($stats['total_tiers']) }}" label="Membership Tiers" />
            <x-stat value="{{ number_format($stats['total_countries']) }}" label="Countries" />
            <x-stat value="{{ number_format($stats['total_batches']) }}" label="Batches" />
        </div>
    </section>

    {{-- Search & Filters --}}
    <section class="section-pad bg-white">
        <div class="container-page">
            <x-section-heading
                eyebrow="Search & Filter"
                title="Find a member"
                description="Search by name, student ID, profession, organization, or batch. Combine filters to narrow results."
            />

            <form method="GET" action="{{ route('members.index') }}" class="mt-10 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <div class="lg:col-span-2">
                        <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                        <input
                            type="search"
                            id="search"
                            name="search"
                            value="{{ $filters['search'] }}"
                            placeholder="Name, student ID, profession, organization, or batch"
                            class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"
                        >
                    </div>

                    <div>
                        <label for="batch" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Batch</label>
                        <select id="batch" name="batch" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All batches</option>
                            @foreach ($batches as $b)
                                <option value="{{ $b }}" @selected($filters['batch'] == $b)>{{ $b }}</option>
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
                </div>

                <div class="mt-4 grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <label for="country" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Country</label>
                        <select id="country" name="country" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All countries</option>
                            @foreach ($countries as $option)
                                <option value="{{ $option }}" @selected($filters['country'] == $option)>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="profession" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Profession</label>
                        <select id="profession" name="profession" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All professions</option>
                            @foreach ($professions as $prof)
                                <option value="{{ $prof }}" @selected($filters['profession'] == $prof)>{{ $prof }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="membership_type_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Type</label>
                        <select id="membership_type_id" name="membership_type_id" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All types</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" @selected($filters['membership_type_id'] == $type->id)>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="membership_tier_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Tier</label>
                        <select id="membership_tier_id" name="membership_tier_id" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All tiers</option>
                            @foreach ($tiers as $tier)
                                <option value="{{ $tier->id }}" @selected($filters['membership_tier_id'] == $tier->id)>{{ $tier->name }}</option>
                            @endforeach
                            <option value="none" @selected($filters['membership_tier_id'] == 'none')">No Tier</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap items-center gap-3">
                    <x-button type="submit" variant="navy">Search Members</x-button>
                    @if ($members->total() > 0 || $filters['search'] !== '' || $filters['batch'] || $filters['graduation_year'] || $filters['country'] || $filters['profession'] || $filters['membership_type_id'] || $filters['membership_tier_id'])
                        <a href="{{ route('members.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                            Clear filters
                        </a>
                    @endif
                </div>
            </form>

            {{-- Results --}}
            @if ($members->isNotEmpty())
                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($members as $membership)
                        <x-member-card :alumni="$membership->alumni" :membership="$membership" />
                    @endforeach
                </div>

                <div class="mt-12 flex justify-center">
                    {{ $members->links() }}
                </div>
            @else
                <div class="mt-10">
                    @if ($filters['search'] !== '' || $filters['batch'] || $filters['graduation_year'] || $filters['country'] || $filters['profession'] || $filters['membership_type_id'] || $filters['membership_tier_id'])
                        <x-empty-state
                            title="No members match your search"
                            description="Try adjusting your search terms or clearing the filters to see the full directory."
                            action_label="Clear all filters"
                            action_href="{{ route('members.index') }}"
                        />
                    @else
                        <x-empty-state
                            title="Member directory is currently being updated"
                            description="Check back soon to meet our public members."
                        />
                    @endif
                </div>
            @endif
        </div>
    </section>

    {{-- Membership Categories --}}
    @if ($types->isNotEmpty())
        <section class="bg-cream py-16 sm:py-20 lg:py-24">
            <div class="container-page">
                <x-section-heading
                    eyebrow="Categories"
                    title="Membership Categories"
                    description="Understand what the membership badges represent."
                />

                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($types as $type)
                        <div class="card-lift rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                            <h3 class="font-serif text-xl font-semibold text-navy-950">{{ $type->name }}</h3>
                            @if ($type->description)
                                <p class="mt-3 text-sm leading-relaxed text-ink-soft">{{ $type->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Membership Tiers --}}
    @if ($tiers->isNotEmpty())
        <section class="section-pad bg-white">
            <div class="container-page">
                <x-section-heading
                    eyebrow="Levels"
                    title="Membership Tiers"
                    description="Tiers reflect levels of engagement and recognition within the Association."
                />

                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($tiers as $tier)
                        <div class="card-lift flex items-start gap-4 rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-navy-900 font-serif text-sm font-bold text-gold-300">
                                {{ strtoupper(substr($tier->name, 0, 2)) }}
                            </span>
                            <div>
                                <h3 class="font-semibold text-navy-950">{{ $tier->name }}</h3>
                                @if ($tier->badge_label)
                                    <p class="mt-1 text-xs font-medium uppercase tracking-wider text-maroon-600">{{ $tier->badge_label }}</p>
                                @endif
                                @if ($tier->description)
                                    <p class="mt-2 text-sm leading-relaxed text-ink-soft">{{ $tier->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="bg-white py-16 sm:py-20">
        <div class="container-page">
            <div class="rounded-lg bg-navy-950 p-10 text-white sm:p-12">
                <div class="grid items-center gap-8 lg:grid-cols-2">
                    <div>
                        <x-section-heading
                            eyebrow="Get Listed"
                            title="Want to be part of the directory?"
                            description="Membership is the key to the directory. Register your interest and we will invite you to join the Association."
                            dark
                        />
                    </div>
                    <div class="lg:justify-self-end">
                        <x-button href="{{ route('membership.apply') }}" variant="gold" :icon="true">Become a Member</x-button>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>
