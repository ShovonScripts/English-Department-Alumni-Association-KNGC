@php
    $ogImage = $news->featured_image_url;
    $authorName = $news->author_name;
    $imageUrl = $news->featured_image_url;
    $publishedDate = $news->published_at?->toIso8601String();
    $modifiedDate = $news->updated_at?->toIso8601String();
    $headline = $news->title;
    $description = $news->excerpt;
@endphp

<x-layouts.app
    :title="$news->title . ' | News'"
    :description="$news->excerpt"
    :image="$ogImage"
>
    @push('head')
        <script type="application/ld+json">
        {!! json_encode(array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'headline' => $headline,
            'description' => $description,
            'image' => $imageUrl,
            'datePublished' => $publishedDate,
            'dateModified' => $modifiedDate,
            'author' => $authorName ? ['@type' => 'Person', 'name' => $authorName] : null,
            'publisher' => ['@type' => 'Organization', 'name' => 'English Department Alumni Association KNGC'],
        ], fn ($v) => $v !== null), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
        </script>
    @endpush

    <nav class="bg-cream py-4" aria-label="Breadcrumb">
        <div class="container-page">
            <ol class="flex flex-wrap items-center gap-2 text-sm text-ink-soft">
                <li><a href="{{ route('home') }}" class="transition-colors hover:text-maroon-700">Home</a></li>
                <li aria-hidden="true"><svg class="h-3 w-3 text-navy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg></li>
                <li><a href="{{ route('news.index') }}" class="transition-colors hover:text-maroon-700">News</a></li>
                <li aria-hidden="true"><svg class="h-3 w-3 text-navy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg></li>
                <li class="font-medium text-navy-950" aria-current="page">{{ \Illuminate\Support\Str::limit($news->title, 50) }}</li>
            </ol>
        </div>
    </nav>

    <article class="section-pad bg-white">
        <div class="container-page max-w-4xl">
            @if ($news->category)
                <span class="inline-flex rounded-full bg-navy-900 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-gold-300">{{ $news->category->name }}</span>
            @endif

            <h1 class="mt-4 font-serif text-3xl font-semibold tracking-tight text-navy-950 sm:text-4xl lg:text-5xl">{{ $news->title }}</h1>

            <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-ink-soft">
                @if ($news->author_name)
                    <span class="font-medium text-navy-900">By {{ $news->author_name }}</span>
                @endif
                <time datetime="{{ $news->published_at?->format('Y-m-d') }}">{{ $news->published_at?->format('F j, Y') }}</time>
            </div>

            @if ($news->featured_image_url)
                <figure class="mt-10">
                    <img src="{{ $news->featured_image_url }}" alt="{{ $news->title }}" class="w-full rounded-xl object-cover" style="max-height: 480px;">
                </figure>
            @endif

            <div class="prose prose-lg mt-10 max-w-none text-navy-950">
                {!! nl2br(e($news->content)) !!}
            </div>
        </div>
    </article>

    @if ($relatedNews->isNotEmpty())
        <section class="bg-cream py-16 sm:py-20">
            <div class="container-page">
                <x-section-heading
                    eyebrow="More News"
                    title="Related articles"
                    description="You may also be interested in these stories."
                />

                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($relatedNews as $related)
                        <x-news-card
                            :title="$related->title"
                            :excerpt="$related->excerpt"
                            :date="$related->published_at"
                            :category="$related->category?->name"
                            :author="$related->author_name"
                            :href="route('news.show', $related)"
                            :image="$related->featured_image_url"
                        />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Comments Section --}}
    <section class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <x-comment-form
            commentable-type="App\Models\News"
            :commentable-id="$news->id"
        />
        <x-comment-list
            commentable-type="App\Models\News"
            :commentable-id="$news->id"
        />
    </section>

</x-layouts.app>
