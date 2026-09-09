@php
$event = $event ?? null;
$inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
@endphp

{{-- Basic Information --}}
<section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Basic Information</h2>
    <p class="mt-1 text-sm text-ink-soft">Core details about the event.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="title" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Title *</label>
            <input type="text" id="title" name="title" value="{{ old('title', $event?->title) }}" required placeholder="e.g. Annual Alumni Lecture" class="{{ $inputClass }} {{ $errors->has('title') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('title')
            <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="category_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</label>
            <select id="category_id" name="category_id" class="{{ $inputClass }}">
                <option value="">No category</option>
                @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" @selected(old('category_id', $event?->category_id) == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id')
            <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="short_description" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Short description *</label>
            <input type="text" id="short_description" name="short_description" value="{{ old('short_description', $event?->short_description) }}" maxlength="500" placeholder="Brief summary for cards" class="{{ $inputClass }} {{ $errors->has('short_description') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('short_description')
            <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="description" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Full description *</label>
            <textarea id="description" name="description" rows="8" maxlength="10000" class="{{ $inputClass }} {{ $errors->has('description') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">{{ old('description', $event?->description) }}</textarea>
            @error('description')
            <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>

{{-- Schedule and Status --}}
<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Schedule and Status</h2>
    <p class="mt-1 text-sm text-ink-soft">When the event happens and how it appears.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div>
            <label for="event_date" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Event date *</label>
            <input type="date" id="event_date" name="event_date" value="{{ old('event_date', $event?->event_date?->format('Y-m-d')) }}" required class="{{ $inputClass }} {{ $errors->has('event_date') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('event_date')
            <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="registration_deadline" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Registration deadline</label>
            <input type="date" id="registration_deadline" name="registration_deadline" value="{{ old('registration_deadline', $event?->registration_deadline?->format('Y-m-d')) }}" class="{{ $inputClass }} {{ $errors->has('registration_deadline') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('registration_deadline')
            <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="start_time" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Start time</label>
            <input type="time" id="start_time" name="start_time" value="{{ old('start_time', $event?->start_time ? \Illuminate\Support\Carbon::parse($event->start_time)->format('H:i') : null) }}" class="{{ $inputClass }} {{ $errors->has('start_time') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('start_time')
            <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="end_time" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">End time</label>
            <input type="time" id="end_time" name="end_time" value="{{ old('end_time', $event?->end_time ? \Illuminate\Support\Carbon::parse($event->end_time)->format('H:i') : null) }}" class="{{ $inputClass }} {{ $errors->has('end_time') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('end_time')
            <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status *</label>
            <select id="status" name="status" required class="{{ $inputClass }} {{ $errors->has('status') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
                <option value="draft" @selected(old('status', $event?->status) === 'draft')>Draft</option>
                <option value="published" @selected(old('status', $event?->status) === 'published')>Published</option>
            </select>
            @error('status')
            <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="sort_order" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Sort order</label>
            <input type="number" id="sort_order" name="sort_order" min="0" value="{{ old('sort_order', $event?->sort_order ?? 0) }}" class="{{ $inputClass }} {{ $errors->has('sort_order') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('sort_order')
            <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <label class="flex items-center gap-3 text-sm font-medium text-navy-900 sm:col-span-2">
            <input type="hidden" name="is_featured" value="0">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $event?->is_featured)) class="h-4 w-4 rounded border-navy-300 text-gold-600 focus:ring-gold-500">
            Feature this event
        </label>
    </div>
</section>

{{-- Location --}}
<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Location</h2>
    <p class="mt-1 text-sm text-ink-soft">Where the event is held.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div>
            <label for="venue" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Venue</label>
            <input type="text" id="venue" name="venue" value="{{ old('venue', $event?->venue) }}" placeholder="e.g. Faculty of Arts, Great Hall" class="{{ $inputClass }}">
            @error('venue')
            <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="address" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Address</label>
            <input type="text" id="address" name="address" value="{{ old('address', $event?->address) }}" placeholder="Street address" class="{{ $inputClass }}">
            @error('address')
            <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="city" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">City</label>
            <input type="text" id="city" name="city" value="{{ old('city', $event?->city) }}" placeholder="e.g. Dhaka" class="{{ $inputClass }}">
            @error('city')
            <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="country" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Country</label>
            <input type="text" id="country" name="country" value="{{ old('country', $event?->country) }}" placeholder="e.g. Bangladesh" class="{{ $inputClass }}">
            @error('country')
            <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>

{{-- Organizer --}}
<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Organizer</h2>
    <p class="mt-1 text-sm text-ink-soft">Who is hosting the event.</p>

    <div class="mt-6">
        <label for="organizer" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Organizer</label>
        <input type="text" id="organizer" name="organizer" value="{{ old('organizer', $event?->organizer) }}" placeholder="e.g. EDAA Events Committee" class="{{ $inputClass }}">
        @error('organizer')
        <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
        @enderror
    </div>
</section>

{{-- Media --}}
<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Media</h2>
    <p class="mt-1 text-sm text-ink-soft">Cover image for the event listing.</p>

    <div class="mt-6">
        <label for="cover_image" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Cover image</label>
            <div class="flex items-center gap-4">
                <img id="preview-img" src="{{ $event?->cover_image_url ?? '' }}" alt="" class="h-24 w-40 rounded-lg object-cover ring-4 ring-gold-500/30 {{ $event?->cover_image_url ? '' : 'hidden' }}">
                <span id="preview-fallback" class="flex h-24 w-40 items-center justify-center rounded-lg border-2 border-dashed border-navy-200 bg-cream text-xs text-ink-soft {{ $event?->cover_image_url ? 'hidden' : '' }}" aria-hidden="true">
                    No image
                </span>
                <input
                    type="file"
                    id="cover_image"
                    name="cover_image"
                    accept="image/*"
                    class="block w-full text-sm text-ink-soft file:mr-4 file:rounded-md file:border-0 file:bg-navy-900 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-navy-800">
            </div>
            <p class="mt-2 text-xs text-ink-soft">JPEG, PNG or WebP, up to 8MB.</p>
            @error('cover_image')
            <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
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