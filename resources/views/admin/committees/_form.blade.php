@php
    $committee = $committee ?? null;
    $inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
@endphp

<section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Committee Details</h2>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div>
            <label for="committee_type_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Committee Type *</label>
            <select id="committee_type_id" name="committee_type_id" required class="{{ $inputClass }} {{ $errors->has('committee_type_id') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
                <option value="">Select type...</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}" @selected(old('committee_type_id', $committee?->committee_type_id) == $type->id)>{{ $type->name }}</option>
                @endforeach
            </select>
            @error('committee_type_id') <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="name" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Name *</label>
            <input type="text" id="name" name="name" value="{{ old('name', $committee?->name) }}" required placeholder="e.g. Executive Committee 2025-2026" class="{{ $inputClass }} {{ $errors->has('name') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('name') <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="start_year" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Start Year *</label>
            <input type="number" id="start_year" name="start_year" value="{{ old('start_year', $committee?->start_year ?? date('Y')) }}" required min="1960" max="{{ (int) date('Y') + 2 }}" class="{{ $inputClass }} {{ $errors->has('start_year') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('start_year') <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="end_year" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">End Year *</label>
            <input type="number" id="end_year" name="end_year" value="{{ old('end_year', $committee?->end_year ?? ((int) date('Y') + 1)) }}" required min="1960" max="{{ (int) date('Y') + 2 }}" class="{{ $inputClass }} {{ $errors->has('end_year') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('end_year') <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p> @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="description" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Description</label>
            <textarea id="description" name="description" rows="3" class="{{ $inputClass }}">{{ old('description', $committee?->description) }}</textarea>
        </div>

        <div>
            <label for="sort_order" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Sort Order</label>
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $committee?->sort_order ?? 0) }}" min="0" class="{{ $inputClass }}">
        </div>

        <div class="flex items-end">
            <label class="inline-flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-3">
                <input type="checkbox" name="is_current" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500" @checked(old('is_current', $committee?->is_current ?? false))>
                <span class="text-sm font-medium text-navy-950">Mark as current (publicly visible)</span>
            </label>
        </div>
    </div>
</section>
