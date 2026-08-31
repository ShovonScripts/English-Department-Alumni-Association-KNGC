@php
    $ogImage = $publication->cover_image_url;
    $authorName = $publication->author;
    $imageUrl = $publication->cover_image_url;
    $publishedDate = $publication->publication_date?->toIso8601String();
    $headline = $publication->title;
    $description = $publication->description;
    $documentType = $publication->document_original_name
        ? strtoupper(pathinfo($publication->document_original_name, PATHINFO_EXTENSION))
        : null;
    $schemaType = in_array($publication->category?->slug, ['research', 'journal', 'thesis'])
        ? 'ScholarlyArticle'
        : 'CreativeWork';
@endphp

<x-layouts.app
    :title="$publication->title . ' | Publications'"
    :description="$publication->description"
    :image="$ogImage"
>
    @push('head')
        <script type="application/ld+json">
        {!! json_encode(array_filter([
            '@context' => 'https://schema.org',
            '@type' => $schemaType,
            'headline' => $headline,
            'description' => $description,
            'image' => $imageUrl,
            'datePublished' => $publishedDate,
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
                <li><a href="{{ route('publications.index') }}" class="transition-colors hover:text-maroon-700">Publications</a></li>
                <li aria-hidden="true"><svg class="h-3 w-3 text-navy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg></li>
                <li class="font-medium text-navy-950" aria-current="page">{{ \Illuminate\Support\Str::limit($publication->title, 50) }}</li>
            </ol>
        </div>
    </nav>

    <article class="section-pad bg-white">
        <div class="container-page max-w-4xl">
            @if ($publication->category)
                <span class="inline-flex rounded-full bg-navy-900 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-gold-300">{{ $publication->category->name }}</span>
            @endif

            <h1 class="mt-4 font-serif text-3xl font-semibold tracking-tight text-navy-950 sm:text-4xl lg:text-5xl">{{ $publication->title }}</h1>

            @if ($publication->subtitle)
                <p class="mt-3 text-lg text-ink-soft">{{ $publication->subtitle }}</p>
            @endif

            <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-ink-soft">
                @if ($publication->author)
                    <span class="font-medium text-navy-900">By {{ $publication->author }}</span>
                @endif
                @if ($publication->publisher)
                    <span>{{ $publication->publisher }}</span>
                @endif
                @if ($publication->publication_date)
                    <time datetime="{{ $publication->publication_date->format('Y-m-d') }}">{{ $publication->publication_date->format('F j, Y') }}</time>
                @endif
            </div>

            @if ($publication->cover_image_url)
                <figure class="mt-10">
                    <img src="{{ $publication->cover_image_url }}" alt="{{ $publication->title }}" class="w-full rounded-xl object-cover" style="max-height: 480px;">
                </figure>
            @endif

            <div class="mt-10 grid gap-10 lg:grid-cols-[1fr_280px]">
                <div class="prose prose-lg max-w-none text-navy-950">
                    {!! nl2br(e($publication->description)) !!}
                </div>

                @if ($publication->document_url)
                    <aside class="lg:order-last">
                        <div class="sticky top-24 rounded-xl border border-navy-100 bg-cream p-6 shadow-sm">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-navy-900 text-gold-300">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.3v11.4m0-11.4A3.2 3.2 0 009.5 3.5H6.5v13h3a3.2 3.2 0 013 2.8m-.5-12.9a3.2 3.2 0 012.5-2.8h3v13h-3a3.2 3.2 0 00-3 2.8m0-12.9v11.4" />
                                    </svg>
                                </span>
                                <div>
                                    @if ($documentType)
                                        <span class="rounded-full bg-maroon-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-maroon-700">{{ $documentType }}</span>
                                    @endif
                                    @if ($publication->formatted_document_size)
                                        <p class="mt-1 text-xs text-ink-soft">{{ $publication->formatted_document_size }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col gap-3">
                                <a href="{{ \App\Support\UrlHelper::safeHref($publication->document_url) }}" target="_blank" rel="noopener noreferrer"
                                    class="focus-ring inline-flex items-center justify-center gap-2 rounded-md bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-navy-800">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View PDF
                                </a>
                                <a href="{{ \App\Support\UrlHelper::safeHref($publication->document_url) }}" download
                                    class="focus-ring inline-flex items-center justify-center gap-2 rounded-md border border-navy-300 px-5 py-2.5 text-sm font-semibold text-navy-900 transition-colors hover:bg-navy-50">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Download PDF
                                </a>
                            </div>

                            <dl class="mt-6 space-y-4 border-t border-navy-200 pt-6 text-sm">
                                @if ($publication->author)
                                    <div>
                                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Author</dt>
                                        <dd class="mt-1 font-medium text-navy-950">{{ $publication->author }}</dd>
                                    </div>
                                @endif
                                @if ($publication->publisher)
                                    <div>
                                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Publisher</dt>
                                        <dd class="mt-1 font-medium text-navy-950">{{ $publication->publisher }}</dd>
                                    </div>
                                @endif
                                @if ($publication->publication_date)
                                    <div>
                                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Publication Date</dt>
                                        <dd class="mt-1 font-medium text-navy-950">{{ $publication->publication_date->format('F j, Y') }}</dd>
                                    </div>
                                @endif
                                @if ($publication->category)
                                    <div>
                                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</dt>
                                        <dd class="mt-1 font-medium text-navy-950">{{ $publication->category->name }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </aside>
                @endif
            </div>

            <div class="mt-12">
                <a href="{{ route('publications.index') }}" class="focus-ring inline-flex items-center gap-2 text-sm font-semibold text-maroon-700 transition-colors hover:text-maroon-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                    </svg>
                    Back to Publications
                </a>
            </div>
        </div>
    </article>

    @if ($relatedPublications && $relatedPublications->isNotEmpty())
        <section class="bg-cream py-16 sm:py-20">
            <div class="container-page">
                <x-section-heading
                    eyebrow="More Publications"
                    title="Related publications"
                    description="You may also be interested in these publications."
                />

                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($relatedPublications as $related)
                        <x-publication-card
                            :title="$related->title"
                            :type="$related->document_original_name ? pathinfo($related->document_original_name, PATHINFO_EXTENSION) : null"
                            :author="$related->author"
                            :year="$related->publication_date?->format('Y')"
                            :description="$related->description"
                            :href="route('publications.show', $related)"
                        />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.app>
