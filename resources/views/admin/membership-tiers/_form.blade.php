@php
    $tier = $tier ?? null;
    $inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
@endphp

<section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Tier Details</h2>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div>
            <label for="name" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Name *</label>
            <input type="text" id="name" name="name" value="{{ old('name', $tier?->name) }}" required placeholder="e.g. Gold" class="{{ $inputClass }} {{ $errors->has('name') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('name')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="badge_label" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Badge Label *</label>
            <input type="text" id="badge_label" name="badge_label" value="{{ old('badge_label', $tier?->badge_label) }}" required placeholder="Shown on the public badge, e.g. Gold" class="{{ $inputClass }} {{ $errors->has('badge_label') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('badge_label')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="description" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Description</label>
            <textarea id="description" name="description" rows="3" class="{{ $inputClass }}">{{ old('description', $tier?->description) }}</textarea>
            @error('description')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="min_contribution" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Minimum Contribution (৳)</label>
            <input type="number" id="min_contribution" name="min_contribution" value="{{ old('min_contribution', $tier?->min_contribution ?? 0) }}" min="0" step="0.01" class="{{ $inputClass }} {{ $errors->has('min_contribution') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            <p class="mt-1 text-xs text-ink-soft">Auto-assigned when total contributions reach this amount.</p>
            @error('min_contribution')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="max_contribution" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Maximum Contribution (৳)</label>
            <input type="number" id="max_contribution" name="max_contribution" value="{{ old('max_contribution', $tier?->max_contribution) }}" min="0" step="0.01" placeholder="Leave empty for unlimited" class="{{ $inputClass }} {{ $errors->has('max_contribution') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            <p class="mt-1 text-xs text-ink-soft">Leave empty if this is the highest tier (no upper limit).</p>
            @error('max_contribution')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="sort_order" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Sort Order</label>
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $tier?->sort_order ?? 0) }}" min="0" class="{{ $inputClass }}">
            @error('sort_order')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-end">
            <label class="inline-flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-3">
                <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500" @checked(old('is_active', $tier?->is_active ?? true))>
                <span class="text-sm font-medium text-navy-950">Active — selectable when registering members</span>
            </label>
        </div>
    </div>
</section>
