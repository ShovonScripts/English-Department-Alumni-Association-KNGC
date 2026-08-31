@php
    $ogImage = $album->cover_image_url;
    $description = $album->description;
    $albumUrl = url()->current();
@endphp

<x-layouts.app
    :title="$album->title . ' | Gallery'"
    :description="$description"
    :image="$ogImage"
>
    @push('head')
        <script type="application/ld+json">
        {!! json_encode(array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'ImageGallery',
            'name' => $album->title,
            'description' => $description,
            'image' => $ogImage,
            'datePublished' => $album->created_at?->toIso8601String(),
            'url' => $albumUrl,
        ], fn ($v) => $v !== null), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
        </script>
    @endpush

    <nav class="bg-cream py-4" aria-label="Breadcrumb">
        <div class="container-page">
            <ol class="flex flex-wrap items-center gap-2 text-sm text-ink-soft">
                <li><a href="{{ route('home') }}" class="transition-colors hover:text-maroon-700">Home</a></li>
                <li aria-hidden="true"><svg class="h-3 w-3 text-navy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg></li>
                <li><a href="{{ route('gallery.index') }}" class="transition-colors hover:text-maroon-700">Gallery</a></li>
                <li aria-hidden="true"><svg class="h-3 w-3 text-navy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg></li>
                <li class="font-medium text-navy-950" aria-current="page">{{ \Illuminate\Support\Str::limit($album->title, 50) }}</li>
            </ol>
        </div>
    </nav>

    <article
        x-data="{
            lightbox: false,
            currentIndex: 0,
            photos: @js($album->photos->map(fn ($p) => ['image_url' => $p->image_url, 'title' => $p->title, 'caption' => $p->caption, 'alt_text' => $p->alt_text])->values()->all()),
            open(index) {
                this.currentIndex = index;
                this.lightbox = true;
                document.body.style.overflow = 'hidden';
            },
            close() {
                this.lightbox = false;
                document.body.style.overflow = '';
            },
            next() {
                this.currentIndex = (this.currentIndex + 1) % this.photos.length;
            },
            prev() {
                this.currentIndex = (this.currentIndex - 1 + this.photos.length) % this.photos.length;
            },
            handleKey(e) {
                if (!this.lightbox) return;
                if (e.key === 'Escape') this.close();
                if (e.key === 'ArrowRight') this.next();
                if (e.key === 'ArrowLeft') this.prev();
            }
        }"
        x-on:keydown.window="handleKey($event)"
        class="section-pad bg-white"
    >
        <div class="container-page max-w-5xl">
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950 sm:text-4xl lg:text-5xl">{{ $album->title }}</h1>

            <div class="mt-4 flex flex-wrap items-center gap-4 text-sm text-ink-soft">
                @if ($album->event)
                    <span>
                        Event: <a href="{{ route('events.show', $album->event->slug) }}" class="font-medium text-maroon-700 transition-colors hover:text-maroon-900">{{ $album->event->title }}</a>
                    </span>
                @endif
                <span>{{ $album->photos_count }} {{ \Illuminate\Support\Str::plural('photo', $album->photos_count) }}</span>
                <time datetime="{{ $album->created_at?->format('Y-m-d') }}">{{ $album->created_at?->format('F j, Y') }}</time>
            </div>

            @if ($description)
                <div class="prose prose-lg mt-8 max-w-none text-navy-950">
                    {!! nl2br(e($description)) !!}
                </div>
            @endif

            @if ($album->photos->isNotEmpty())
                <div class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($album->photos as $index => $photo)
                        <button
                            type="button"
                            @click="open({{ $index }})"
                            class="group relative aspect-square overflow-hidden rounded-xl bg-navy-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-maroon-600 focus-visible:ring-offset-2"
                            aria-label="View photo: {{ $photo->alt_text ?: $photo->title ?: 'Photo ' . ($index + 1) }}"
                        >
                            <img
                                src="{{ $photo->image_url }}"
                                alt="{{ $photo->alt_text ?: $photo->title ?: $album->title . ' photo ' . ($index + 1) }}"
                                loading="lazy"
                                class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                            >
                        </button>
                    @endforeach
                </div>
            @else
                <div class="mt-16 flex flex-col items-center justify-center text-center">
                    <svg class="h-16 w-16 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V5.25a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v14.25a1.5 1.5 0 001.5 1.5z" />
                    </svg>
                    <p class="mt-4 text-lg font-medium text-navy-900">No photos yet</p>
                    <p class="mt-1 text-ink-soft">Photos will appear here once they are uploaded.</p>
                </div>
            @endif
        </div>

        {{-- Lightbox --}}
        <template x-if="lightbox">
            <div
                class="fixed inset-0 z-50 flex items-center justify-center bg-navy-950/80 backdrop-blur-sm"
                @click.self="close()"
                role="dialog"
                aria-modal="true"
                aria-label="Photo lightbox"
            >
                <button
                    type="button"
                    @click="close()"
                    class="absolute right-4 top-4 z-10 rounded-full bg-white/10 p-2 text-white transition-colors hover:bg-white/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
                    aria-label="Close lightbox"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <button
                    type="button"
                    @click="prev()"
                    class="absolute left-4 z-10 rounded-full bg-white/10 p-2 text-white transition-colors hover:bg-white/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
                    aria-label="Previous photo"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <div class="flex max-h-[90vh] max-w-[90vw] flex-col items-center">
                    <img
                        :src="photos[currentIndex].image_url"
                        :alt="photos[currentIndex].alt_text || photos[currentIndex].title || 'Album photo'"
                        class="max-h-[80vh] rounded-lg object-contain"
                    >
                    <div class="mt-4 text-center text-white">
                        <template x-if="photos[currentIndex].title || photos[currentIndex].caption">
                            <p class="text-sm sm:text-base" x-text="photos[currentIndex].caption || photos[currentIndex].title"></p>
                        </template>
                        <p class="mt-1 text-xs text-white/70">
                            (<span x-text="currentIndex + 1"></span> / <span x-text="photos.length"></span>)
                        </p>
                    </div>
                </div>

                <button
                    type="button"
                    @click="next()"
                    class="absolute right-4 z-10 rounded-full bg-white/10 p-2 text-white transition-colors hover:bg-white/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
                    aria-label="Next photo"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </template>
    </article>
</x-layouts.app>
