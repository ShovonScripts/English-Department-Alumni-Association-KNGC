<x-layouts.app
    :title="$member->name . ' — ' . $member->position"
    :description="$member->short_bio ?? $member->name . ', ' . $member->position . ' at the English Department Alumni Association KNGC.'"
    :image="$member->profile_photo_url"
>

    <x-page-header
        :title="$member->name"
        :description="$member->position"
        eyebrow="Committee Profile"
        :breadcrumbs="[['label' => 'Committee', 'url' => route('committee.index')], ['label' => $member->name]]"
    />

    <section class="section-pad bg-cream">
        <div class="container-page">
            <div class="grid gap-8 lg:grid-cols-3">
                {{-- Profile card --}}
                <div class="lg:col-span-1">
                    <div class="rounded-lg border border-navy-100 bg-white p-8 text-center shadow-sm lg:sticky lg:top-8">
                        @if ($member->profile_photo_url)
                            <img src="{{ $member->profile_photo_url }}" alt="Portrait of {{ $member->name }}" class="mx-auto h-36 w-36 rounded-full object-cover ring-4 ring-gold-500/30">
                        @else
                            <span class="mx-auto flex h-36 w-36 items-center justify-center rounded-full bg-navy-900 font-serif text-4xl font-semibold text-gold-300 ring-4 ring-gold-500/30" aria-hidden="true">
                                {{ \Illuminate\Support\Str::initials($member->name) }}
                            </span>
                        @endif

                        <h2 class="mt-6 font-serif text-2xl font-semibold text-navy-950">{{ $member->name }}</h2>

                        <p class="mt-1 text-sm font-medium text-maroon-700">{{ $member->position }}</p>

                        @if ($member->short_bio)
                            <p class="mt-3 text-sm leading-relaxed text-ink-soft">{{ $member->short_bio }}</p>
                        @endif

                        @if ($member->linkedin_url || $member->website_url)
                            <div class="mt-7 flex flex-col gap-3">
                                @if ($member->linkedin_url)
                                    <x-button href="{{ \App\Support\UrlHelper::safeHref($member->linkedin_url) }}" variant="outline" :icon="true" target="_blank" rel="noopener noreferrer">LinkedIn</x-button>
                                @endif
                                @if ($member->website_url)
                                    <x-button href="{{ \App\Support\UrlHelper::safeHref($member->website_url) }}" variant="outline" :icon="true" target="_blank" rel="noopener noreferrer">Website</x-button>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="mt-6">
                        <x-button href="{{ route('committee.index') }}" variant="navy">Back to Committee</x-button>
                    </div>
                </div>

                {{-- Details --}}
                <div class="lg:col-span-2">
                    @if ($member->biography)
                        <div class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                            <h2 class="font-serif text-xl font-semibold text-navy-950">About</h2>
                            <p class="mt-4 text-base leading-relaxed text-ink-soft">{{ $member->biography }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>
