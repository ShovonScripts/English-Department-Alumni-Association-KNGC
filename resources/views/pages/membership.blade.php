<x-layouts.app title="Membership" description="Learn about EDAA-KNGC membership and how to join the English Department Alumni Association of Kabi Nazrul Government College.">

    <x-page-header
        title="Membership"
        description="Join the English Department Alumni Association KNGC and stay connected with fellow alumni, students, and teachers."
        eyebrow="Join Us"
        :breadcrumbs="[['label' => 'Membership']]"
    />

    {{-- What is EDAA-KNGC --}}
    <section class="section-pad bg-white">
        <div class="container-page">
            <x-section-heading
                eyebrow="About Membership"
                title="What is EDAA-KNGC?"
                description="The English Department Alumni Association KNGC is a non-political, non-profit, social and welfare-oriented organisation dedicated to lifelong connection, academic support, and community service."
            />

            <div class="mt-10 max-w-3xl space-y-4 text-base leading-relaxed text-ink-soft sm:text-lg">
                <p>
                    Membership in the Association supports participation in its activities, events, and community initiatives,
                    subject to the Association's rules and policies. Members enjoy opportunities for networking, mentorship,
                    and contribution to the academic and social welfare of the English Department of Kabi Nazrul Government College, Dhaka.
                </p>
                <p>
                    The Association does not guarantee specific services in exchange for membership fees. All activities and
                    benefits are governed by the constitution and decisions of the Executive Committee.
                </p>
            </div>
        </div>
    </section>

    {{-- Membership Types --}}
    @if ($membershipTypes->isNotEmpty())
        <section class="bg-cream py-16 sm:py-20 lg:py-24">
            <div class="container-page">
                <x-section-heading
                    eyebrow="Categories"
                    title="Membership Categories"
                    description="Choose the membership category that best fits your relationship with the department."
                />

                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($membershipTypes as $type)
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
    @if ($membershipTiers->isNotEmpty())
        <section class="section-pad bg-white">
            <div class="container-page">
                <x-section-heading
                    eyebrow="Levels"
                    title="Membership Tiers"
                    description="Tiers reflect levels of engagement and recognition within the Association."
                />

                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($membershipTiers as $tier)
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

    {{-- Fee Plans --}}
    @if ($feePlans->isNotEmpty())
        <section class="bg-cream py-16 sm:py-20 lg:py-24">
            <div class="container-page">
                <x-section-heading
                    eyebrow="Fees"
                    title="Applicable Fees"
                    description="Membership fees are determined by the Association and may vary by membership category."
                />

                <div class="mt-10 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-navy-100 text-sm">
                            <thead class="bg-cream">
                                <tr>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Plan</th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</th>
                                    <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-ink-soft">Amount</th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Frequency</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-navy-50">
                                @foreach ($feePlans as $plan)
                                    <tr class="transition-colors hover:bg-cream/60">
                                        <td class="px-6 py-3.5 font-medium text-navy-950">{{ $plan->name }}</td>
                                        <td class="px-6 py-3.5 text-ink-soft">{{ $plan->type->name ?? '—' }}</td>
                                        <td class="px-6 py-3.5 text-right font-semibold text-navy-950">{{ $plan->formattedAmount() }}</td>
                                        <td class="px-6 py-3.5 text-ink-soft">{{ $plan->frequency->label() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <p class="mt-4 text-sm text-ink-soft">
                    Fees are collected manually by the Association. There is no online payment system.
                    Payment information will be communicated after your application is approved.
                </p>
            </div>
        </section>
    @endif

    {{-- How to Apply --}}
    <section class="section-pad bg-white">
        <div class="container-page">
            <x-section-heading
                eyebrow="Process"
                title="How to Apply"
                description="The membership application process is simple and straightforward."
            />

            <div class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['step' => '01', 'title' => 'Learn', 'description' => 'Review the membership categories, tiers, and applicable fees on this page.'],
                    ['step' => '02', 'title' => 'Apply', 'description' => 'Complete the online application form with your personal, academic, and professional information.'],
                    ['step' => '03', 'title' => 'Review', 'description' => 'The Executive Committee will review your application. You can track the status online.'],
                    ['step' => '04', 'title' => 'Join', 'description' => 'Once approved, you become a member. Fee collection will be arranged manually.'],
                ] as $item)
                    <div class="text-center sm:text-left">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-navy-900 font-serif text-lg font-bold text-gold-300">
                            {{ $item['step'] }}
                        </span>
                        <h3 class="mt-4 font-serif text-lg font-semibold text-navy-950">{{ $item['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-ink-soft">{{ $item['description'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <x-button href="{{ route('membership.apply') }}" variant="gold" class="inline-flex">
                    Apply for Membership
                </x-button>
            </div>
        </div>
    </section>

    {{-- Privacy --}}
    <section class="bg-cream py-16 sm:py-20 lg:py-24">
        <div class="container-page">
            <div class="mx-auto max-w-3xl rounded-lg border border-navy-100 bg-white p-8 sm:p-10">
                <x-section-heading
                    align="center"
                    eyebrow="Privacy"
                    title="Your Information"
                />
                <div class="mt-6 space-y-4 text-sm leading-relaxed text-ink-soft">
                    <p>
                        The information you provide in your membership application is used solely for the purpose of
                        evaluating and processing your membership. It is not shared publicly or with third parties.
                    </p>
                    <p>
                        Public alumni profiles display only information that members have explicitly opted to share.
                        Contact details, application notes, and internal records are never publicly visible.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Meet Our Members CTA --}}
    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="rounded-lg bg-navy-950 p-10 text-white sm:p-12">
                <div class="grid items-center gap-8 lg:grid-cols-2">
                    <div>
                        <x-section-heading
                            eyebrow="Directory"
                            title="Meet Our Members"
                            description="Browse the public member directory. Find alumni by name, batch, profession, and more."
                            dark
                        />
                    </div>
                    <div class="lg:justify-self-end">
                        <x-button href="{{ route('members.index') }}" variant="gold" :icon="true">View Member Directory</x-button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
