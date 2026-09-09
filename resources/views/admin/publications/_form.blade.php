@php
    $publication = $publication ?? null;
    $inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
@endphp

{{-- Publication Information --}}
<section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Publication Information</h2>
    <p class="mt-1 text-sm text-ink-soft">Core details about the publication.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="title" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Title *</label>
            <input type="text" id="title" name="title" value="{{ old('title', $publication?->title) }}" required placeholder="e.g. Annual Research Report" class="{{ $inputClass }} {{ $errors->has('title') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('title')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="subtitle" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Subtitle</label>
            <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $publication?->subtitle) }}" placeholder="e.g. A Comprehensive Overview" class="{{ $inputClass }}">
            @error('subtitle')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="publication_category_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</label>
            <select id="publication_category_id" name="publication_category_id" class="{{ $inputClass }}">
                <option value="">No category</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('publication_category_id', $publication?->publication_category_id) == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('publication_category_id')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="author" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Author</label>
            <input type="text" id="author" name="author" value="{{ old('author', $publication?->author) }}" placeholder="e.g. Mercy Uche" class="{{ $inputClass }}">
            @error('author')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="publisher" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Publisher</label>
            <input type="text" id="publisher" name="publisher" value="{{ old('publisher', $publication?->publisher) }}" placeholder="e.g. EDAA Press" class="{{ $inputClass }}">
            @error('publisher')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="publication_date" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Publication Date</label>
            <input type="date" id="publication_date" name="publication_date" value="{{ old('publication_date', $publication?->publication_date?->format('Y-m-d')) }}" class="{{ $inputClass }}">
            @error('publication_date')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="description" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Description</label>
            <textarea id="description" name="description" rows="6" class="{{ $inputClass }} {{ $errors->has('description') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">{{ old('description', $publication?->description) }}</textarea>
            @error('description')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>

{{-- Publishing --}}
<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Publishing</h2>
    <p class="mt-1 text-sm text-ink-soft">Control when and how the publication appears.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div>
            <label for="status" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status *</label>
            <select id="status" name="status" class="{{ $inputClass }}">
                <option value="draft" @selected(old('status', $publication?->status ?? 'draft') === 'draft')>Draft — not visible publicly</option>
                <option value="published" @selected(old('status', $publication?->status ?? 'draft') === 'published')>Published — visible publicly</option>
            </select>
            @error('status')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="sort_order" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Sort order</label>
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $publication?->sort_order ?? 0) }}" min="0" class="{{ $inputClass }}">
            @error('sort_order')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-end">
            <label class="inline-flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-3">
                <input type="checkbox" name="is_featured" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500" @checked(old('is_featured', $publication?->is_featured))>
                <span class="text-sm font-medium text-navy-950">Featured on homepage</span>
            </label>
        </div>
    </div>
</section>

{{-- Cover --}}
<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Cover</h2>
    <p class="mt-1 text-sm text-ink-soft">Cover image for the publication.</p>

    <div class="mt-6">
        <label for="cover_image" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Cover image</label>
            <div class="flex items-center gap-4">
                <img id="preview-img" src="{{ $publication?->cover_image_url ?? '' }}" alt="" class="h-24 w-40 rounded-lg object-cover ring-4 ring-gold-500/30 {{ $publication?->cover_image_url ? '' : 'hidden' }}">
                <span id="preview-fallback" class="flex h-24 w-40 items-center justify-center rounded-lg border-2 border-dashed border-navy-200 bg-cream text-xs text-ink-soft {{ $publication?->cover_image_url ? 'hidden' : '' }}" aria-hidden="true">
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
        @if ($publication?->cover_image)
            <label class="mt-3 inline-flex items-center gap-2">
                <input type="checkbox" name="clear_image" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500">
                <span class="text-sm text-navy-950">Remove current image</span>
            </label>
        @endif
    </div>
</section>

{{-- Document --}}
<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Document</h2>
    <p class="mt-1 text-sm text-ink-soft">PDF document attached to this publication.</p>

    <div class="mt-6">
        <label for="document" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Document file</label>
        <input
            type="file"
            id="document"
            name="document"
            accept=".pdf"
            class="block w-full text-sm text-ink-soft file:mr-4 file:rounded-md file:border-0 file:bg-navy-900 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-navy-800"
        >
        <p class="mt-2 text-xs text-ink-soft">PDF only, up to 10MB.</p>
        @error('document')
            <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
        @enderror
        @if ($publication?->document_path)
            <div class="mt-3 flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-3">
                <svg class="h-5 w-5 shrink-0 text-maroon-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                <span class="text-sm text-navy-950">{{ $publication->document_original_name }}</span>
                <span class="text-xs text-ink-soft">({{ \Illuminate\Support\Number::format($publication->document_size) }}B)</span>
            </div>
            <label class="mt-3 inline-flex items-center gap-2">
                <input type="checkbox" name="clear_document" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500">
                <span class="text-sm text-navy-950">Remove current document</span>
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
