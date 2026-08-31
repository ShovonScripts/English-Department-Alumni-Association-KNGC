@php
    $ogImage = $story->cover_image_url;
    $authorName = $story->author_name;
    $imageUrl = $story->cover_image_url;
    $publishedDate = $story->published_at?->toIso8601String();
    $modifiedDate = $story->updated_at?->toIso8601String();
    $headline = $story->title;
    $description = $story->excerpt;
@endphp

<x-layouts.app
    :title="$story->title . ' | Alumni Stories'"
    :description="$story->excerpt"
    :image="$ogImage"
>
    @push('head')
        <script type="application/ld+json">
        {!! json_encode(array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $headline,
            'description' => $description,
            'image' => $imageUrl ? [url($imageUrl)] : null,
            'datePublished' => $publishedDate,
            'dateModified' => $modifiedDate,
            'author' => $authorName ? ['@type' => 'Person', 'name' => $authorName] : ($story->alumni ? ['@type' => 'Person', 'name' => $story->alumni->full_name, 'url' => route('alumni.show', $story->alumni)] : null),
            'publisher' => ['@type' => 'Organization', 'name' => 'English Department Alumni Association KNGC'],
            'url' => route('stories.show', $story),
        ], fn ($v) => $v !== null), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
        </script>
    @endpush

    <nav class="bg-cream py-4" aria-label="Breadcrumb">
        <div class="container-page">
            <ol class="flex flex-wrap items-center gap-2 text-sm text-ink-soft">
                <li><a href="{{ route('home') }}" class="transition-colors hover:text-maroon-700">Home</a></li>
                <li aria-hidden="true"><svg class="h-3 w-3 text-navy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg></li>
                <li><a href="{{ route('stories.index') }}" class="transition-colors hover:text-maroon-700">Stories</a></li>
                <li aria-hidden="true"><svg class="h-3 w-3 text-navy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg></li>
                <li class="font-medium text-navy-950" aria-current="page">{{ \Illuminate\Support\Str::limit($story->title, 50) }}</li>
            </ol>
        </div>
    </nav>

    <article class="section-pad bg-white">
        <div class="container-page max-w-4xl">
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950 sm:text-4xl lg:text-5xl">{{ $story->title }}</h1>

            <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-ink-soft">
                @if ($story->author_name)
                    <span class="font-medium text-navy-900">By {{ $story->author_name }}</span>
                @endif
                <time datetime="{{ $story->published_at?->format('Y-m-d') }}">{{ $story->published_at?->format('F j, Y') }}</time>
            </div>

            @if ($story->cover_image_url)
                <figure class="mt-10">
                    <img src="{{ $story->cover_image_url }}" alt="{{ $story->title }}" class="w-full rounded-xl object-cover" style="max-height: 480px;">
                </figure>
            @endif

            <div class="prose prose-lg mt-10 max-w-none text-navy-950">
                {!! nl2br(e($story->content)) !!}
            </div>

            {{-- Alumni Attribution --}}
            @if ($story->alumni)
                <div class="mt-12 rounded-lg border border-navy-100 bg-cream p-8">
                    <h2 class="font-serif text-lg font-semibold text-navy-950">About the Alumni</h2>
                    <div class="mt-4 flex items-center gap-4">
                        @if ($story->alumni->profile_photo_url)
                            <img src="{{ $story->alumni->profile_photo_url }}" alt="{{ $story->alumni->full_name }}" class="h-16 w-16 rounded-full object-cover ring-4 ring-gold-500/30">
                        @else
                            <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-navy-900 font-serif text-lg font-semibold text-gold-300 ring-4 ring-gold-500/30" aria-hidden="true">
                                {{ \Illuminate\Support\Str::initials($story->alumni->full_name) }}
                            </span>
                        @endif
                        <div>
                            <a href="{{ route('alumni.show', $story->alumni) }}" class="font-serif text-lg font-semibold text-navy-950 transition-colors hover:text-maroon-700">{{ $story->alumni->full_name }}</a>
                            @if ($story->alumni->batch || $story->alumni->graduation_year)
                                <p class="mt-0.5 text-sm text-ink-soft">
                                    {{ collect([$story->alumni->batch ? "Batch {$story->alumni->batch}" : null, $story->alumni->graduation_year])->filter()->implode(' · ') }}
                                </p>
                            @endif
                            @if ($story->alumni->profession || $story->alumni->organization)
                                <p class="mt-0.5 text-sm text-ink-soft">
                                    {{ collect([$story->alumni->profession, $story->alumni->organization])->filter()->implode(' · ') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </article>

    @if ($relatedStories->isNotEmpty())
        <section class="bg-cream py-16 sm:py-20">
            <div class="container-page">
                <x-section-heading
                    eyebrow="More Stories"
                    title="Related stories"
                    description="You may also be interested in these stories."
                />

                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($relatedStories as $related)
                        <x-story-card
                            :name="$related->alumni?->full_name"
                            :graduation_year="$related->alumni?->graduation_year"
                            :quote="$related->excerpt"
                            :role="$related->alumni?->designation"
                            :image="$related->cover_image_url"
                            :href="route('stories.show', $related)"
                        />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.app>
