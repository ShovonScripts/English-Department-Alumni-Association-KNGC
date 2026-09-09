<x-layouts.app title="Membership" description="Learn about EDAA-KNGC membership categories, tiers, benefits, and how to join the English Department Alumni Association of Kabi Nazrul Government College.">

    <x-page-header
        title="Membership"
        description="Join the English Department Alumni Association KNGC and stay connected with fellow alumni, scholars, and teachers across generations."
        eyebrow="Join Us"
        :breadcrumbs="[['label' => 'Membership']]"
    />

    {{-- What is EDAA-KNGC --}}
    <section class="section-pad bg-white">
        <div class="container-page">
            <x-section-heading
                eyebrow="About Membership"
                title="What is EDAA-KNGC?"
                description="The English Department Alumni Association KNGC is a non-political, non-profit, social and welfare-oriented community dedicated to lifelong fellowship, academic mentorship, and community service."
            />

            <div class="mt-12 grid gap-8 md:grid-cols-2">
                <div class="card-lift rounded-3xl border border-navy-100 bg-gradient-to-br from-navy-50/60 to-white p-8 sm:p-10 shadow-sm">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-navy-900 text-gold-300 shadow">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="mt-6 font-serif text-xl font-bold text-navy-950">Academic & Cultural Legacy</h3>
                    <p class="mt-3 text-sm leading-relaxed text-ink-soft">
                        Rooted in Kabi Nazrul Government College's founding in 1874, membership in the Association preserves our shared love of language, literature, and educational excellence. Members actively support departmental lectures, journals, and literary festivals.
                    </p>
                </div>

                <div class="card-lift rounded-3xl border border-navy-100 bg-gradient-to-br from-maroon-50/60 to-white p-8 sm:p-10 shadow-sm">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-maroon-700 text-gold-300 shadow">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.4-1.7M9 20H4v-2a3 3 0 015.4-1.7M16 3.1a3 3 0 110 5.8M11 7a3 3 0 11-6 0 3 3 0 016 0zm5 7.5a3 3 0 10-6 0" />
                        </svg>
                    </div>
                    <h3 class="mt-6 font-serif text-xl font-bold text-navy-950">Lifelong Welfare & Networking</h3>
                    <p class="mt-3 text-sm leading-relaxed text-ink-soft">
                        Enjoy mutual welfare support, professional networking spanning diverse fields (academics, civil service, media, enterprise), and a platform to give back to current students through mentorship and scholarships.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Membership Categories --}}
    @if ($membershipTypes->isNotEmpty())
        <section class="bg-cream py-16 sm:py-20 lg:py-24 border-y border-navy-100">
            <div class="container-page">
                <x-section-heading
                    eyebrow="Categories"
                    title="Membership Categories"
                    description="Choose the membership category that best corresponds with your departmental graduation."
                />

                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($membershipTypes as $type)
                        <div class="card-lift shine group relative flex flex-col justify-between overflow-hidden rounded-3xl border border-navy-100 bg-white/95 p-8 shadow-sm backdrop-blur-md transition-all duration-300 hover:border-gold-400/60 hover:shadow-xl">
                            <div class="h-1.5 w-12 rounded-full bg-gold-400 mb-6 transition-all group-hover:w-20"></div>
                            <div>
                                <h3 class="font-serif text-2xl font-bold text-navy-950 transition-colors group-hover:text-maroon-700">{{ $type->name }}</h3>
                                @if ($type->description)
                                    <p class="mt-3 text-sm leading-relaxed text-ink-soft">{{ $type->description }}</p>
                                @endif
                            </div>
                            <div class="mt-8 border-t border-navy-50 pt-5">
                                <a href="{{ route('membership.apply') }}" class="focus-ring inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-maroon-700 transition-colors hover:text-maroon-900">
                                    Apply for this category &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Membership Tiers --}}
    @if ($membershipTiers->isNotEmpty())
        <section class="section-pad bg-white">
            <div class="container-page">
                <x-section-heading
                    eyebrow="Levels"
                    title="Membership Recognition Tiers"
                    description="Tiers reflect levels of ongoing engagement, voluntary contributions, and distinction within the Association."
                />

                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($membershipTiers as $tier)
                        <div class="card-lift group relative flex items-start gap-4 rounded-3xl border border-navy-100 bg-white p-7 shadow-sm transition-all duration-300 hover:border-gold-400/60 hover:shadow-xl">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-navy-950 to-navy-800 font-serif text-base font-bold text-gold-300 shadow ring-1 ring-gold-500/30">
                                {{ strtoupper(substr($tier->name, 0, 2)) }}
                            </span>
                            <div class="min-w-0 flex-1">
                                <h3 class="font-serif text-lg font-bold text-navy-950">{{ $tier->name }}</h3>
                                @if ($tier->badge_label)
                                    <span class="mt-1 inline-block rounded-full bg-gold-50 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-gold-700 border border-gold-300">
                                        {{ $tier->badge_label }}
                                    </span>
                                @endif
                                @if ($tier->description)
                                    <p class="mt-2.5 text-xs leading-relaxed text-ink-soft">{{ $tier->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- How to Apply (4-Step Timeline) --}}
    <section class="bg-gradient-to-b from-navy-950 via-navy-900 to-navy-950 py-20 text-white sm:py-28 relative overflow-hidden">
        <div class="pointer-events-none absolute inset-0 opacity-10" aria-hidden="true">
            <div class="absolute -right-32 -top-32 h-96 w-96 rounded-full bg-gold-400 blur-3xl"></div>
            <div class="absolute -left-32 -bottom-32 h-96 w-96 rounded-full bg-maroon-500 blur-3xl"></div>
        </div>

        <div class="container-page relative">
            <div class="text-center max-w-2xl mx-auto">
                <span class="inline-flex items-center gap-2 rounded-full border border-gold-400/30 bg-gold-500/10 px-4 py-1 text-xs font-bold uppercase tracking-[0.2em] text-gold-300">
                    Simple Process
                </span>
                <h2 class="mt-4 font-serif text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight">
                    How to <span class="italic text-gold-300">Become a Member</span>
                </h2>
                <p class="mt-4 text-base text-navy-200">
                    The registration procedure is streamlined and transparent. Follow these 4 straightforward steps to activate your membership.
                </p>
            </div>

            <div class="mt-16 grid gap-8 sm:grid-cols-2 lg:grid-cols-4 relative">
                @foreach ([
                    ['step' => '01', 'title' => 'Learn & Prepare', 'description' => 'Review the membership categories and prepare your academic background details.'],
                    ['step' => '02', 'title' => 'Submit Application', 'description' => 'Fill out our secure online form with your personal, contact, and graduation info.'],
                    ['step' => '03', 'title' => 'Committee Review', 'description' => 'The Executive Committee verifies records. You can track your status live online.'],
                    ['step' => '04', 'title' => 'Access Portal', 'description' => 'Upon approval, receive your digital ID card, directory badge, and portal access.'],
                ] as $item)
                    <div class="relative rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-md transition-all duration-300 hover:bg-white/10 hover:border-gold-400/40">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-gold-400 to-gold-600 font-serif text-lg font-bold text-navy-950 shadow-lg shadow-gold-500/20">
                            {{ $item['step'] }}
                        </span>
                        <h3 class="mt-5 font-serif text-lg font-bold text-white">{{ $item['title'] }}</h3>
                        <p class="mt-2 text-xs leading-relaxed text-navy-200">{{ $item['description'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-14 text-center flex flex-col sm:flex-row items-center justify-center gap-4">
                <x-button href="{{ route('membership.apply') }}" variant="gold" size="lg" :icon="true">
                    Start Membership Application
                </x-button>
                <a href="{{ route('member.login') }}" class="focus-ring inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/5 px-6 py-3.5 text-sm font-semibold text-white transition-colors hover:bg-white/10 hover:border-gold-400">
                    Existing Member Login
                </a>
            </div>
        </div>
    </section>

    {{-- Privacy & Security Notice --}}
    <section class="bg-cream py-16 sm:py-20">
        <div class="container-page">
            <div class="mx-auto max-w-3xl rounded-3xl border border-navy-100 bg-white p-8 sm:p-12 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-navy-100 text-navy-900">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>
                    <h3 class="font-serif text-xl font-bold text-navy-950">Your Information & Privacy</h3>
                </div>
                <div class="space-y-4 text-sm leading-relaxed text-ink-soft">
                    <p>
                        Your privacy matters. Information submitted in your membership application is used solely by the EDAA-KNGC Executive Committee for verification and Association welfare purposes.
                    </p>
                    <p>
                        Members maintain full control over their public alumni directory visibility through their Member Portal settings. Contact details, national identification, and administrative audit records are strictly confidential and never shared publicly.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Meet Our Members CTA --}}
    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="rounded-3xl bg-gradient-to-br from-navy-950 via-navy-900 to-maroon-950 p-10 text-white sm:p-14 shadow-2xl">
                <div class="grid items-center gap-8 lg:grid-cols-2">
                    <div>
                        <x-section-heading
                            eyebrow="Directory"
                            title="Meet Our Members"
                            description="Explore our community of verified graduates, educators, and scholars across batches and professions."
                            dark
                        />
                    </div>
                    <div class="lg:justify-self-end">
                        <x-button href="{{ route('members.index') }}" variant="gold" size="lg" :icon="true">
                            View Member Directory
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
