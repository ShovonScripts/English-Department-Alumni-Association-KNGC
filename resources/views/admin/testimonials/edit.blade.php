<x-layouts.admin title="Edit Testimonial">
    <div class="mb-8">
        <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Edit Testimonial</h1>
        <p class="mt-1 text-sm text-ink-soft">Update this testimonial.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-md border border-maroon-200 bg-maroon-50 px-4 py-3 text-sm font-medium text-maroon-800">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
        <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="quote" class="mb-1.5 block text-sm font-semibold text-navy-950">
                    Quote <span class="text-maroon-600">*</span>
                </label>
                <textarea
                    id="quote"
                    name="quote"
                    rows="4"
                    required
                    maxlength="1000"
                    placeholder="Enter the testimonial quote..."
                    class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 resize-none"
                >{{ old('quote', $testimonial->quote) }}</textarea>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="author_name" class="mb-1.5 block text-sm font-semibold text-navy-950">
                        Author Name <span class="text-maroon-600">*</span>
                    </label>
                    <input
                        type="text"
                        id="author_name"
                        name="author_name"
                        value="{{ old('author_name', $testimonial->author_name) }}"
                        required
                        placeholder="e.g. Professor Milki Amatul Mogni"
                        class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400"
                    >
                </div>
                <div>
                    <label for="author_title" class="mb-1.5 block text-sm font-semibold text-navy-950">Author Title</label>
                    <input
                        type="text"
                        id="author_title"
                        name="author_title"
                        value="{{ old('author_title', $testimonial->author_title) }}"
                        placeholder="e.g. Past President, EDAA"
                        class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400"
                    >
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="author_batch" class="mb-1.5 block text-sm font-semibold text-navy-950">Author Batch</label>
                    <input
                        type="text"
                        id="author_batch"
                        name="author_batch"
                        value="{{ old('author_batch', $testimonial->author_batch) }}"
                        placeholder="e.g. Class of 1987"
                        class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400"
                    >
                </div>
                <div>
                    <label for="sort_order" class="mb-1.5 block text-sm font-semibold text-navy-950">Sort Order</label>
                    <input
                        type="number"
                        id="sort_order"
                        name="sort_order"
                        value="{{ old('sort_order', $testimonial->sort_order) }}"
                        min="0"
                        class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950"
                    >
                </div>
            </div>

            <div>
                <label for="image" class="mb-1.5 block text-sm font-semibold text-navy-950">Speaker Image</label>
                @if ($testimonial->image_url)
                    <div class="mb-3">
                        <img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->author_name }}" class="h-20 w-20 rounded-full object-cover ring-2 ring-gold-500/40">
                    </div>
                @endif
                <input
                    type="file"
                    id="image"
                    name="image"
                    accept="image/jpeg,image/png,image/webp"
                    class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 file:mr-4 file:rounded file:border-0 file:bg-navy-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-navy-800"
                >
                <p class="mt-1 text-xs text-ink-soft">JPEG, PNG or WebP. Max 8MB. Leave empty to keep current image.</p>
            </div>

            <div class="flex items-center gap-3">
                <input
                    type="checkbox"
                    id="is_active"
                    name="is_active"
                    value="1"
                    {{ old('is_active', $testimonial->is_active ? '1' : '0') === '1' ? 'checked' : '' }}
                    class="focus-ring h-4 w-4 rounded border-navy-300 text-maroon-600"
                >
                <label for="is_active" class="text-sm font-semibold text-navy-950">Active (shown on home page)</label>
            </div>

            <div class="flex items-center gap-3">
                <x-button type="submit" variant="gold">Update Testimonial</x-button>
                <a href="{{ route('admin.testimonials.index') }}" class="focus-ring inline-flex h-10 items-center justify-center rounded-md px-4 text-sm font-semibold text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.admin>
