@php
    $alumniStory = $alumniStory ?? null;
    $inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
@endphp

{{-- Story Information --}}
<section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Story Information</h2>
    <p class="mt-1 text-sm text-ink-soft">Core details about the story.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="title" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Title *</label>
            <input type="text" id="title" name="title" value="{{ old('title', $alumniStory?->title) }}" required placeholder="e.g. From Classroom to Global Career" class="{{ $inputClass }} {{ $errors->has('title') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('title')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="alumni_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Alumni *</label>
            <select id="alumni_id" name="alumni_id" required class="{{ $inputClass }} {{ $errors->has('alumni_id') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
                <option value="">Select alumni</option>
                @foreach ($alumniList as $a)
                    <option value="{{ $a->id }}" @selected(old('alumni_id', $alumniStory?->alumni_id) == $a->id)>{{ $a->full_name }}{{ $a->batch ? " — Batch {$a->batch}" : '' }}{{ $a->graduation_year ? " ({$a->graduation_year})" : '' }}</option>
                @endforeach
            </select>
            @error('alumni_id')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="author_name" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Author Name</label>
            <input type="text" id="author_name" name="author_name" value="{{ old('author_name', $alumniStory?->author_name) }}" placeholder="e.g. Mercy Uche" class="{{ $inputClass }}">
            @error('author_name')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="excerpt" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Excerpt *</label>
            <textarea id="excerpt" name="excerpt" rows="3" maxlength="1000" class="{{ $inputClass }} {{ $errors->has('excerpt') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">{{ old('excerpt', $alumniStory?->excerpt) }}</textarea>
            @error('excerpt')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="content" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Content *</label>
            <textarea id="content" name="content" rows="12" class="{{ $inputClass }} {{ $errors->has('content') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">{{ old('content', $alumniStory?->content) }}</textarea>
            @error('content')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>

{{-- Publishing --}}
<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Publishing</h2>
    <p class="mt-1 text-sm text-ink-soft">Control when and how the story appears.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div>
            <label for="status" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status *</label>
            <select id="status" name="status" class="{{ $inputClass }}">
                <option value="draft" @selected(old('status', $alumniStory?->status ?? 'draft') === 'draft')>Draft — not visible publicly</option>
                <option value="published" @selected(old('status', $alumniStory?->status ?? 'draft') === 'published')>Published — visible publicly</option>
            </select>
            @error('status')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="published_at" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Published At</label>
            <input type="datetime-local" id="published_at" name="published_at" value="{{ old('published_at', $alumniStory?->published_at?->format('Y-m-d\TH:i')) }}" class="{{ $inputClass }}">
            @error('published_at')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>

{{-- Display --}}
<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Display</h2>
    <p class="mt-1 text-sm text-ink-soft">Featured state and ordering.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div>
            <label for="sort_order" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Sort order</label>
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $alumniStory?->sort_order ?? 0) }}" min="0" class="{{ $inputClass }}">
            @error('sort_order')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-end">
            <label class="inline-flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-3">
                <input type="checkbox" name="is_featured" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500" @checked(old('is_featured', $alumniStory?->is_featured))>
                <span class="text-sm font-medium text-navy-950">Featured on homepage</span>
            </label>
        </div>
    </div>
</section>

{{-- Media --}}
<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Media</h2>
    <p class="mt-1 text-sm text-ink-soft">Cover image for the story.</p>

    <div class="mt-6">
        <label for="cover_image" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Cover image</label>
            <div class="flex items-center gap-4">
                <img id="preview-img" src="{{ $alumniStory?->cover_image_url ?? '' }}" alt="" class="h-24 w-40 rounded-lg object-cover ring-4 ring-gold-500/30 {{ $alumniStory?->cover_image_url ? '' : 'hidden' }}">
                <span id="preview-fallback" class="flex h-24 w-40 items-center justify-center rounded-lg border-2 border-dashed border-navy-200 bg-cream text-xs text-ink-soft {{ $alumniStory?->cover_image_url ? 'hidden' : '' }}" aria-hidden="true">
                    No image
                </span>
                <input
                    type="file"
                    id="cover_image"
                    name="cover_image"
                    accept="image/*"
                    class="block w-full text-sm text-ink-soft file:mr-4 file:rounded-md file:border-0 file:bg-navy-900 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-navy-800"
                >
            </div>
            <p class="mt-2 text-xs text-ink-soft">JPEG, PNG or WebP, up to 8MB.</p>
            @error('cover_image')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>
        @if ($alumniStory?->cover_image)
            <label class="mt-3 inline-flex items-center gap-2">
                <input type="checkbox" name="clear_image" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500">
                <span class="text-sm text-navy-950">Remove current image</span>
            </label>
        @endif
    </div>
</section>

@push('scripts')
    <script>
    (function() {
        const input = document.getElementById('cover_image');
        const img = document.getElementById('preview-img');
        const fallback = document.getElementById('preview-fallback');
        if (input && img) {
            input.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        img.src = e.target.result;
                        img.classList.remove('hidden');
                        if (fallback) fallback.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    })();
    </script>
@endpush
