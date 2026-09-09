@php
    $pressRelease = $pressRelease ?? null;
    $inputClass = 'input-field';
@endphp

<section class="premium-card p-6 sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Basic Information</h2>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="title" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Title *</label>
            <input type="text" id="title" name="title" value="{{ old('title', $pressRelease?->title) }}" required
                class="{{ $inputClass }} {{ $errors->has('title') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('title')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="excerpt" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Excerpt / Summary</label>
            <textarea id="excerpt" name="excerpt" rows="3" maxlength="1000"
                class="{{ $inputClass }} {{ $errors->has('excerpt') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}"
                placeholder="Brief summary of the press release (optional)">{{ old('excerpt', $pressRelease?->excerpt) }}</textarea>
            @error('excerpt')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="content" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Content</label>
            <textarea id="content" name="content" rows="12"
                class="{{ $inputClass }} {{ $errors->has('content') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}"
                placeholder="Full content of the press release (optional)">{{ old('content', $pressRelease?->content) }}</textarea>
            @error('content')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="external_url" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">External URL</label>
            <input type="url" id="external_url" name="external_url" value="{{ old('external_url', $pressRelease?->external_url) }}"
                placeholder="https://example.com/original-article"
                class="{{ $inputClass }} {{ $errors->has('external_url') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('external_url')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
            <p class="mt-1.5 text-xs text-ink-soft">Optional link to an external source.</p>
        </div>
    </div>
</section>

<section class="mt-6 premium-card p-6 sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Media</h2>
    <p class="mt-1 text-sm text-ink-soft">A press release may contain text, an image, a PDF, or any combination. All are optional.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div>
            <label for="cover_image" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Cover Image</label>
            <input type="file" id="cover_image" name="cover_image" accept="image/jpeg,image/png,image/webp"
                class="block w-full text-sm text-ink-soft file:mr-4 file:rounded-md file:border-0 file:bg-navy-900 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-navy-800">
            <p class="mt-2 text-xs text-ink-soft">JPEG, PNG, or WebP. Max 8 MB, 5000×5000 px.</p>
            @error('cover_image')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror

            <div class="mt-3">
                <img id="preview-img" src="{{ $pressRelease?->cover_image_url ?? '' }}" alt="Preview" class="h-24 w-40 rounded-lg object-cover ring-4 ring-gold-500/30 {{ $pressRelease?->cover_image_url ? '' : 'hidden' }}">
                <span id="preview-fallback" class="text-xs text-ink-soft {{ $pressRelease?->cover_image_url ? 'hidden' : '' }}">No image selected</span>
            </div>

            @if ($pressRelease?->cover_image)
                <label class="mt-3 inline-flex items-center gap-2">
                    <input type="checkbox" name="clear_image" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500">
                    <span class="text-sm text-navy-950">Remove current image</span>
                </label>
            @endif
        </div>

        <div>
            <label for="document" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">PDF Document</label>
            <input type="file" id="document" name="document" accept=".pdf"
                class="block w-full text-sm text-ink-soft file:mr-4 file:rounded-md file:border-0 file:bg-navy-900 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-navy-800">
            <p class="mt-2 text-xs text-ink-soft">PDF only. Max 10 MB.</p>
            @error('document')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror

            @if ($pressRelease?->document_path)
                <div class="mt-3 flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-3">
                    <svg class="h-8 w-8 shrink-0 text-maroon-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-navy-950 truncate">{{ $pressRelease->document_original_name }}</p>
                        <p class="text-xs text-ink-soft">PDF · {{ \Illuminate\Support\Number::format($pressRelease->document_size ?? 0) }}B</p>
                    </div>
                </div>
                <label class="mt-3 inline-flex items-center gap-2">
                    <input type="checkbox" name="clear_document" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500">
                    <span class="text-sm text-navy-950">Remove current document</span>
                </label>
            @endif
        </div>
    </div>
</section>

<section class="mt-6 premium-card p-6 sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Publishing</h2>

    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <label for="status" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status *</label>
            <select id="status" name="status" required
                class="{{ $inputClass }} {{ $errors->has('status') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
                <option value="draft" @selected(old('status', $pressRelease?->status) === 'draft')>Draft</option>
                <option value="published" @selected(old('status', $pressRelease?->status) === 'published')>Published</option>
            </select>
            @error('status')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="published_at" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Publication Date</label>
            <input type="datetime-local" id="published_at" name="published_at"
                value="{{ old('published_at', $pressRelease?->published_at?->format('Y-m-d\TH:i') ?? '') }}"
                class="{{ $inputClass }}">
            <p class="mt-1.5 text-xs text-ink-soft">Leave empty to auto-set when published.</p>
        </div>

        <div>
            <label for="sort_order" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Sort Order</label>
            <input type="number" id="sort_order" name="sort_order" min="0"
                value="{{ old('sort_order', $pressRelease?->sort_order ?? 0) }}"
                class="{{ $inputClass }}">
        </div>

        <div class="flex items-end">
            <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="is_featured" value="1"
                    {{ old('is_featured', $pressRelease?->is_featured) ? 'checked' : '' }}
                    class="h-4 w-4 rounded border-navy-300 text-gold-600 focus:ring-gold-500">
                <span class="text-sm font-medium text-navy-950">Featured</span>
            </label>
        </div>
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
