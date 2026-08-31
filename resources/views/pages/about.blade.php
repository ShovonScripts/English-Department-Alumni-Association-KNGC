<x-layouts.app title="About" description="Learn about the history, mission, and values of the English Department Alumni Association KNGC.">

    <x-page-header
        title="About EDAA-KNGC"
        description="The English Department Alumni Association KNGC — a non-political, non-profit, social and welfare-oriented family of English Department graduates of Kabi Nazrul Government College, Dhaka."
        eyebrow="Who We Are"
        :breadcrumbs="[['label' => 'About']]"
    />

    {{-- Nature of the Organisation --}}
    <section class="bg-white pt-10">
        <div class="container-page flex flex-wrap items-center justify-center gap-3">
            @foreach (['Non-Political', 'Non-Profit', 'Social & Welfare-Oriented'] as $trait)
                <span class="inline-flex items-center gap-2 rounded-full border border-gold-500/40 bg-gold-50 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-maroon-700">
                    <span class="h-1.5 w-1.5 rounded-full bg-maroon-600" aria-hidden="true"></span>
                    {{ $trait }}
                </span>
            @endforeach
        </div>
    </section>

    {{-- Objectives & Vision --}}
    <section class="section-pad bg-white">
        <div class="container-page grid gap-6 lg:grid-cols-2">
            <div class="rounded-lg border border-navy-100 bg-cream p-8 sm:p-10">
                <span class="flex h-12 w-12 items-center justify-center rounded-md bg-navy-900 text-gold-300">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <h2 class="mt-5 font-serif text-2xl font-semibold text-navy-950">Our Objectives</h2>
                <ul class="mt-4 space-y-2 leading-relaxed text-ink-soft">
                    <li>· To strengthen the bond among the alumni of the English Department.</li>
                    <li>· To support the academic and professional development of current students.</li>
                    <li>· To organise cultural, social, and humanitarian activities.</li>
                    <li>· To enhance communication, networking, and cooperation among members.</li>
                    <li>· To contribute to the overall development of Kabi Nazrul Government College.</li>
                </ul>
            </div>

            <div class="rounded-lg border border-navy-100 bg-cream p-8 sm:p-10">
                <span class="flex h-12 w-12 items-center justify-center rounded-md bg-maroon-700 text-white">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.5 12s3.5-7 9.5-7 9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7z" />
                    </svg>
                </span>
                <h2 class="mt-5 font-serif text-2xl font-semibold text-navy-950">Our Vision</h2>
                <p class="mt-4 leading-relaxed text-ink-soft">
                    A lifelong family of English Department graduates of KNGC — one that keeps every former student connected to the institution that shaped them, supports the writers and readers of tomorrow, and serves the wider community in the welfare-oriented spirit of our constitution.
                </p>
            </div>
        </div>
    </section>

    {{-- History --}}
    <section class="bg-cream py-16 sm:py-20 lg:py-24">
        <div class="container-page grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            <div class="relative order-2 lg:order-1">
                <div class="absolute -right-6 -bottom-6 hidden h-40 w-40 rounded-lg border-2 border-gold-400/40 sm:block" aria-hidden="true"></div>
                <div class="relative overflow-hidden rounded-xl bg-gradient-to-br from-navy-800 via-navy-900 to-maroon-900 p-10 sm:p-14">
                    <p class="font-serif text-6xl italic leading-none text-gold-300">1874</p>
                    <p class="mt-4 font-serif text-2xl italic leading-snug text-navy-100">
                        The year Mohasania Madrasah was founded through the Mohsin Fund — the institution that would become Kabi Nazrul Government College.
                    </p>
                    <p class="mt-6 text-sm uppercase tracking-[0.2em] text-navy-200">Established by the philanthropy of Haji Muhammad Mohsin</p>
                </div>
            </div>

            <div class="order-1 lg:order-2">
                <x-section-heading
                    eyebrow="Our History"
                    title="From Mohasania Madrasah to KNGC"
                    description="Our alma mater has served learners in Laxmi Bazar, Dhaka for over 150 years — and our Association carries that legacy forward."
                />

                <ul class="mt-8 space-y-8">
                    @foreach ([
                        ['year' => '1874', 'text' => 'Mohasania Madrasah is established through a grant from the Mohsin Fund of Haji Muhammad Mohsin, built on the model of Calcutta Alia Madrasah.'],
                        ['year' => '1915', 'text' => 'The institute becomes Dhaka High Madrasah; a year later its Anglo-Persian department separates as Dhaka Government Muslim High School.'],
                        ['year' => '1921', 'text' => 'With the establishment of the University of Dhaka, the school is upgraded to a college and renamed Islamia Intermediate College.'],
                        ['year' => '1968', 'text' => 'The college section is named Government College, Dhaka.'],
                        ['year' => '1972', 'text' => 'The institution receives its current name — Kabi Nazrul Government College (KNGC).'],
                        ['year' => '2017–2025', 'text' => 'KNGC is affiliated with the University of Dhaka, deepening its academic tradition.'],
                        ['year' => 'Today', 'text' => 'The English Department Alumni Association KNGC unites generations of graduates under one constitution — non-political, non-profit, and devoted to welfare.'],
                    ] as $milestone)
                        <li class="flex gap-5">
                            <span class="flex w-20 shrink-0 font-serif text-lg font-semibold text-maroon-700">{{ $milestone['year'] }}</span>
                            <span class="relative pl-5">
                                <span class="absolute left-0 top-2 h-2 w-2 rounded-full bg-gold-500" aria-hidden="true"></span>
                                <p class="leading-relaxed text-ink-soft">{{ $milestone['text'] }}</p>
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- Values --}}
    <section class="section-pad bg-white">
        <div class="container-page">
            <x-section-heading
                eyebrow="What We Stand For"
                title="Our values"
                description="The principles that guide everything the Association does."
                align="center"
            />

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    ['title' => 'Community', 'icon' => 'M17 20h5v-2a3 3 0 00-5.4-1.7M9 20H4v-2a3 3 0 015.4-1.7M16 3.1a3 3 0 110 5.8M11 7a3 3 0 11-6 0 3 3 0 016 0z', 'text' => 'We believe the bonds formed in the lecture hall should last a lifetime, and we work to keep them alive.'],
                    ['title' => 'Scholarship', 'icon' => 'M12 6.3v11.4m0-11.4A3.2 3.2 0 009.5 3.5H6.5v13h3a3.2 3.2 0 013 2.8m-.5-12.9a3.2 3.2 0 012.5-2.8h3v13h-3a3.2 3.2 0 00-3 2.8m0-12.9v11.4', 'text' => 'We champion language and literature, celebrating excellence in writing, teaching, and critical thought.'],
                    ['title' => 'Giving Back', 'icon' => 'M14 10h4.8M14 14h2.6M7 7a3 3 0 116 0 3 3 0 01-6 0zm7 9a4 4 0 00-8 0M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'text' => 'We invest in the next generation of students through mentorship, awards, and practical support.'],
                    ['title' => 'Inclusion', 'icon' => 'M4.3 12a8 8 0 1115.4 0M2 12a10 10 0 1020 0 10 10 0 00-20 0zm7 0a3 3 0 116 0 3 3 0 01-6 0zm9.5 7l-1-1.5M4 19l1-1.5', 'text' => 'Every graduate belongs here, wherever they live, work, or write — we welcome all voices.'],
                    ['title' => 'Integrity', 'icon' => 'M9 12l2 2 4-4m5.6 3.6a9 9 0 11-12.7-12.7 9 9 0 0112.7 12.7z', 'text' => 'We manage our resources, programmes, and promises with honesty and transparency.'],
                    ['title' => 'Legacy', 'icon' => 'M12 6.3v11.4M8.5 8.5L12 6.3l3.5 2.2M12 17.7V12m0 0l3.5-2.2', 'text' => 'We honour the teachers and writers who came before us and preserve the stories that made us who we are.'],
                ] as $value)
                    <div class="card-lift rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                        <span class="flex h-12 w-12 items-center justify-center rounded-md bg-navy-900 text-gold-300">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $value['icon'] }}" />
                            </svg>
                        </span>
                        <h3 class="mt-5 font-serif text-xl font-semibold text-navy-950">{{ $value['title'] }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-ink-soft">{{ $value['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Membership --}}
    <section class="section-pad bg-cream">
        <div class="container-page">
            <x-section-heading
                eyebrow="Membership"
                title="Join the Association"
                description="Per Article 4 of our constitution, applicants complete the prescribed form and pay the required fee. Teachers of the English Department serve as Honorary Members."
                align="center"
            />

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    [
                        'title' => 'General Member',
                        'detail' => 'For former students of the English Department, KNGC.',
                        'fee' => 'BDT 50 — one-time registration fee',
                    ],
                    [
                        'title' => 'Executive Committee Member',
                        'detail' => 'General members holding at least a Bachelor’s degree are eligible to contest Executive Committee elections.',
                        'fee' => 'BDT 100 — monthly',
                    ],
                    [
                        'title' => 'Lifetime & Honorary Members',
                        'detail' => 'Lifetime membership is determined by the Executive Committee; teachers of the Department are Honorary Members.',
                        'fee' => 'As decided by the Executive Committee',
                    ],
                ] as $tier)
                    <div class="card-lift rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                        <h3 class="font-serif text-xl font-semibold text-navy-950">{{ $tier['title'] }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-ink-soft">{{ $tier['detail'] }}</p>
                        <p class="mt-5 inline-flex rounded-full bg-navy-900 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-gold-300">{{ $tier['fee'] }}</p>
                    </div>
                @endforeach
            </div>

            <p class="mx-auto mt-10 max-w-3xl text-center text-sm leading-relaxed text-ink-soft">
                The Association is governed by its constitution: an Executive Committee elected for two-year terms, a three-member Election Commission, and an Advisory Council led by the Head of the Department. Financial accounts are audited at least twice a year.
            </p>
        </div>
    </section>

    {{-- CTA --}}
    <section class="relative overflow-hidden bg-navy-950 py-16 text-white sm:py-20">
        <div class="pointer-events-none absolute inset-0 opacity-[0.07]" aria-hidden="true">
            <div class="absolute -left-20 -top-20 h-80 w-80 rounded-full border-2 border-gold-400"></div>
            <div class="absolute bottom-0 right-1/4 h-48 w-48 rounded-full border border-white/40"></div>
        </div>
        <div class="container-page relative text-center">
            <x-section-heading
                eyebrow="Join the Story"
                title="Become part of our community"
                description="Your story belongs in our history. Reconnect, give back, and grow with us."
                align="center"
                dark
            />
            <div class="mt-9 flex flex-col justify-center gap-3 sm:flex-row">
                <x-button href="{{ route('contact') }}" variant="gold" size="lg" :icon="true">Become a Member</x-button>
                <x-button href="{{ route('committee.index') }}" variant="outline-on-dark" size="lg">Meet the Committee</x-button>
            </div>
        </div>
    </section>

</x-layouts.app>