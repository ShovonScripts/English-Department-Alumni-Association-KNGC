@php
    $album = $album ?? null;
    $inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
@endphp

{{-- Album Information --}}
<section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Album Information</h2>
    <p class="mt-1 text-sm text-ink-soft">Core details about the album.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="title" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Title *</label>
            <input type="text" id="title" name="title" value="{{ old('title', $album?->title) }}" required placeholder="e.g. Alumni Reunion 2026" class="{{ $inputClass }} {{ $errors->has('title') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('title')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="description" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Description</label>
            <textarea id="description" name="description" rows="4" class="{{ $inputClass }}">{{ old('description', $album?->description) }}</textarea>
            @error('description')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="event_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Event</label>
            <select id="event_id" name="event_id" class="{{ $inputClass }}">
                <option value="">No event</option>
                @foreach ($events as $event)
                    <option value="{{ $event->id }}" @selected(old('event_id', $album?->event_id) == $event->id)>{{ $event->title }} — {{ $event->event_date?->format('M j, Y') }}</option>
                @endforeach
            </select>
            @error('event_id')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>

{{-- Display --}}
<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Display</h2>
    <p class="mt-1 text-sm text-ink-soft">Control visibility and ordering.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div>
            <label for="status" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status *</label>
            <select id="status" name="status" class="{{ $inputClass }}">
                <option value="published" @selected(old('status', $album?->status ?? 'published') === 'published')>Published — visible publicly</option>
                <option value="hidden" @selected(old('status', $album?->status ?? 'published') === 'hidden')>Hidden — not visible publicly</option>
            </select>
            @error('status')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="sort_order" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Sort Order</label>
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $album?->sort_order ?? 0) }}" min="0" class="{{ $inputClass }}">
            @error('sort_order')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>

{{-- Media --}}
<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Media</h2>
    <p class="mt-1 text-sm text-ink-soft">Cover image for the album.</p>

    <div class="mt-6">
        <label for="cover_image" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Cover Image</label>
        <div x-data="{ preview: @js($album?->cover_image_url), updatePreview(event) { const file = event.target.files[0]; if (!file) return; const reader = new FileReader(); reader.onload = (e) => this.preview = e.target.result; reader.readAsDataURL(file); } }">
            <div class="flex items-center gap-4">
                <template x-if="preview">
                    <img :src="preview" alt="" class="h-24 w-40 rounded-lg object-cover ring-4 ring-gold-500/30">
                </template>
                <template x-if="!preview">
                    <span class="flex h-24 w-40 items-center justify-center rounded-lg border-2 border-dashed border-navy-200 bg-cream text-xs text-ink-soft" aria-hidden="true">
                        No image
                    </span>
                </template>
                <input
                    type="file"
                    id="cover_image"
                    name="cover_image"
                    accept="image/*"
                    @change="updatePreview"
                    class="block w-full text-sm text-ink-soft file:mr-4 file:rounded-md file:border-0 file:bg-navy-900 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-navy-800"
                >
            </div>
            <p class="mt-2 text-xs text-ink-soft">JPEG, PNG or WebP, up to 2MB.</p>
            @error('cover_image')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>
        @if ($album?->cover_image)
            <label class="mt-3 inline-flex items-center gap-2">
                <input type="checkbox" name="clear_image" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500">
                <span class="text-sm text-navy-950">Remove current image</span>
            </label>
        @endif
    </div>
</section>
