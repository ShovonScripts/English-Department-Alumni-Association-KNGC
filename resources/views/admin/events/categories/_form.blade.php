@php
    $category = $category ?? null;
    $inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
@endphp

<section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Category Details</h2>
    <p class="mt-1 text-sm text-ink-soft">Name and describe this category.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="name" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Name *</label>
            <input type="text" id="name" name="name" value="{{ old('name', $category?->name) }}" required placeholder="e.g. Lecture" class="{{ $inputClass }} {{ $errors->has('name') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('name')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="description" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Description</label>
            <textarea id="description" name="description" rows="3" class="{{ $inputClass }}">{{ old('description', $category?->description) }}</textarea>
            @error('description')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>
