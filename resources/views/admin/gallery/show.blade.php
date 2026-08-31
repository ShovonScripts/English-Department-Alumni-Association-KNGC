<x-layouts.admin :title="$album->title">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">{{ $album->title }}</h1>
            <p class="mt-1 text-sm text-ink-soft">Album details and photos.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.gallery.edit', $album) }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2 2 0 112.8 2.8L11 15l-4 1 1-4 9.6-9.4z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.gallery.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                &larr; Back to Gallery
            </a>
        </div>
    </div>

    {{-- Upload Photos Form --}}
    <section class="mb-8 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
        <h2 class="font-serif text-xl font-semibold text-navy-950">Upload Photos</h2>
        <p class="mt-1 text-sm text-ink-soft">Add new photos to this album.</p>

        <form method="POST" action="{{ route('admin.gallery.photos.store', $album) }}" enctype="multipart/form-data" class="mt-6">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="photos" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Select Photos</label>
                    <input
                        type="file"
                        id="photos"
                        name="photos[]"
                        multiple
                        accept="image/*"
                        class="block w-full text-sm text-ink-soft file:mr-4 file:rounded-md file:border-0 file:bg-navy-900 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-navy-800"
                    >
                    <p class="mt-2 text-xs text-ink-soft">Select multiple images at once. JPEG, PNG or WebP, up to 5MB each.</p>
                    @error('photos')
                        <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
                    @enderror
                    @error('photos.*')
                        <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="photo_title" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Title (applied to all)</label>
                        <input type="text" id="photo_title" name="title" placeholder="e.g. Group Photo" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                        @error('title')
                            <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="photo_caption" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Caption (applied to all)</label>
                        <input type="text" id="photo_caption" name="caption" placeholder="e.g. Taken during the main event" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                        @error('caption')
                            <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="photo_alt_text" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Alt Text (applied to all)</label>
                    <input type="text" id="photo_alt_text" name="alt_text" placeholder="e.g. Alumni group photo at the main hall" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    @error('alt_text')
                        <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
                    @enderror
                </div>

                <x-button type="submit" variant="gold">Upload Photos</x-button>
            </div>
        </form>
    </section>

    <div class="grid gap-8 lg:grid-cols-3">
        <div class="space-y-8 lg:col-span-2">
            {{-- Album Cover --}}
            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Cover Image</h2>
                <div class="mt-4">
                    @if ($album->cover_image)
                        <img src="{{ $album->cover_image_url }}" alt="{{ $album->title }}" class="w-full rounded-lg object-cover ring-4 ring-gold-500/30">
                    @else
                        <div class="flex h-40 items-center justify-center rounded-lg border-2 border-dashed border-navy-200 bg-cream">
                            <span class="text-sm text-ink-soft">No cover image</span>
                        </div>
                    @endif
                </div>
            </section>

            {{-- Album Photos --}}
            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Album Photos <span class="text-sm font-normal text-ink-soft">({{ $album->photos_count ?? $album->photos->count() }})</span></h2>

                @if ($album->photos->isNotEmpty())
                    <div class="mt-6 grid gap-6 sm:grid-cols-2">
                        @foreach ($album->photos as $photo)
                            <div class="group rounded-lg border border-navy-100 bg-cream/50 p-4" x-data="{ editing: false }">
                                <div class="aspect-video overflow-hidden rounded-lg bg-navy-100">
                                    <img src="{{ $photo->thumbnail_url ?? $photo->url }}" alt="{{ $photo->alt_text ?? $photo->title }}" class="h-full w-full object-cover">
                                </div>

                                {{-- Display Mode --}}
                                <div x-show="!editing" class="mt-3">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <p class="text-sm font-semibold text-navy-950">{{ $photo->title ?? 'Untitled' }}</p>
                                            @if ($photo->caption)
                                                <p class="mt-0.5 text-xs text-ink-soft">{{ $photo->caption }}</p>
                                            @endif
                                        </div>
                                        @if ($photo->status === 'published')
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-xs font-semibold text-navy-800">
                                                <span class="h-1.5 w-1.5 rounded-full bg-navy-600" aria-hidden="true"></span>
                                                Published
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-maroon-100 px-2.5 py-1 text-xs font-semibold text-maroon-800">
                                                <span class="h-1.5 w-1.5 rounded-full bg-maroon-600" aria-hidden="true"></span>
                                                Hidden
                                            </span>
                                        @endif
                                    </div>
                                    <div class="mt-2 flex items-center gap-2 text-xs text-ink-soft">
                                        <span>Sort: {{ $photo->sort_order }}</span>
                                    </div>
                                    <div class="mt-3 flex items-center gap-1">
                                        <button type="button" @click="editing = true" class="focus-ring inline-flex h-8 items-center gap-1.5 rounded-md px-2.5 text-xs font-semibold text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2 2 0 112.8 2.8L11 15l-4 1 1-4 9.6-9.4z" />
                                            </svg>
                                            Edit
                                        </button>
                                        <form method="POST" action="{{ route('admin.gallery.photos.destroy', [$album, $photo]) }}" onsubmit="return confirm('Delete this photo? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="focus-ring inline-flex h-8 items-center gap-1.5 rounded-md px-2.5 text-xs font-semibold text-maroon-600 transition-colors hover:bg-maroon-50 hover:text-maroon-800">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.8 12a2 2 0 01-2 1.8H7.8a2 2 0 01-2-1.8L5 7m5 4v6m4-6v6m-9-10h14M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                {{-- Edit Mode --}}
                                <div x-show="editing" x-cloak class="mt-3">
                                    <form method="POST" action="{{ route('admin.gallery.photos.update', [$album, $photo]) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="space-y-3">
                                            <div>
                                                <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Title</label>
                                                <input type="text" name="title" value="{{ old('title', $photo->title) }}" class="w-full rounded-md border border-navy-300 bg-white px-3 py-2 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                                                @error('title')
                                                    <p class="mt-1 text-xs font-medium text-maroon-700">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Caption</label>
                                                <input type="text" name="caption" value="{{ old('caption', $photo->caption) }}" class="w-full rounded-md border border-navy-300 bg-white px-3 py-2 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                                                @error('caption')
                                                    <p class="mt-1 text-xs font-medium text-maroon-700">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Alt Text</label>
                                                <input type="text" name="alt_text" value="{{ old('alt_text', $photo->alt_text) }}" class="w-full rounded-md border border-navy-300 bg-white px-3 py-2 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                                                @error('alt_text')
                                                    <p class="mt-1 text-xs font-medium text-maroon-700">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="grid gap-3 sm:grid-cols-2">
                                                <div>
                                                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</label>
                                                    <select name="status" class="w-full rounded-md border border-navy-300 bg-white px-3 py-2 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                                                        <option value="published" @selected(old('status', $photo->status) === 'published')>Published</option>
                                                        <option value="hidden" @selected(old('status', $photo->status) === 'hidden')>Hidden</option>
                                                    </select>
                                                    @error('status')
                                                        <p class="mt-1 text-xs font-medium text-maroon-700">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Sort Order</label>
                                                    <input type="number" name="sort_order" value="{{ old('sort_order', $photo->sort_order) }}" min="0" class="w-full rounded-md border border-navy-300 bg-white px-3 py-2 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                                                    @error('sort_order')
                                                        <p class="mt-1 text-xs font-medium text-maroon-700">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <x-button type="submit" variant="gold">Save</x-button>
                                                <button type="button" @click="editing = false" class="focus-ring inline-flex items-center gap-2 rounded-md px-3 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                                                    Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="mt-6 flex flex-col items-center justify-center rounded-lg border-2 border-dashed border-navy-200 bg-cream py-12">
                        <svg class="h-12 w-12 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" />
                        </svg>
                        <p class="mt-3 text-sm font-semibold text-navy-950">No photos yet</p>
                        <p class="mt-1 text-xs text-ink-soft">Upload photos using the form above.</p>
                    </div>
                @endif
            </section>
        </div>

        <aside class="space-y-8">
            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-navy-950">Album Details</h2>
                <div class="mt-4 space-y-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</p>
                        @if ($album->status === 'published')
                            <span class="mt-1 inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-xs font-semibold text-navy-800">
                                <span class="h-1.5 w-1.5 rounded-full bg-navy-600" aria-hidden="true"></span>
                                Published
                            </span>
                        @else
                            <span class="mt-1 inline-flex items-center gap-1.5 rounded-full bg-maroon-100 px-2.5 py-1 text-xs font-semibold text-maroon-800">
                                <span class="h-1.5 w-1.5 rounded-full bg-maroon-600" aria-hidden="true"></span>
                                Hidden
                            </span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Event</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $album->event?->title ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Photos</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $album->photos_count ?? $album->photos->count() }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Sort Order</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $album->sort_order }}</p>
                    </div>
                </div>
            </section>

            @if ($album->description)
                <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                    <h2 class="font-serif text-lg font-semibold text-navy-950">Description</h2>
                    <p class="mt-4 text-sm leading-relaxed text-navy-950">{{ $album->description }}</p>
                </section>
            @endif

            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-navy-950">Timestamps</h2>
                <div class="mt-4 space-y-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Created</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $album->created_at->format('M j, Y g:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Updated</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $album->updated_at->format('M j, Y g:i A') }}</p>
                    </div>
                </div>
            </section>
        </aside>
    </div>
</x-layouts.admin>
