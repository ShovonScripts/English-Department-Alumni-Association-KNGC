@php
    $plan = $plan ?? null;
    $inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
@endphp

<section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Fee Plan Details</h2>
    <p class="mt-1 text-sm text-ink-soft">
        Amounts are in Bangladeshi Taka. When a fee changes, prefer creating a new plan with new effective dates so historical records stay stable.
    </p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="name" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Fee Plan Name *</label>
            <input type="text" id="name" name="name" value="{{ old('name', $plan?->name) }}" required placeholder="e.g. General Membership Registration 2027" class="{{ $inputClass }} {{ $errors->has('name') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('name')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="membership_type_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Type *</label>
            <select id="membership_type_id" name="membership_type_id" required class="{{ $inputClass }} {{ $errors->has('membership_type_id') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
                <option value="">Select type…</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}" @selected(old('membership_type_id', $plan?->membership_type_id) == $type->id)>{{ $type->name }}</option>
                @endforeach
            </select>
            @error('membership_type_id')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="amount" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Amount (৳) *</label>
            <input type="number" id="amount" name="amount" value="{{ old('amount', $plan?->amount) }}" required min="0" step="0.01" placeholder="e.g. 50" class="{{ $inputClass }} {{ $errors->has('amount') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('amount')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="currency" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Currency *</label>
            <select id="currency" name="currency" class="{{ $inputClass }}">
                <option value="BDT" @selected(old('currency', $plan?->currency ?? 'BDT') === 'BDT')>BDT — Bangladeshi Taka</option>
            </select>
            @error('currency')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="frequency" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Frequency *</label>
            <select id="frequency" name="frequency" required class="{{ $inputClass }} {{ $errors->has('frequency') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
                <option value="">Select frequency…</option>
                @foreach ($frequencies as $frequency)
                    <option value="{{ $frequency->value }}" @selected(old('frequency', $plan?->frequency?->value) === $frequency->value)>{{ $frequency->label() }}</option>
                @endforeach
            </select>
            @error('frequency')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="effective_from" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Effective From</label>
            <input type="date" id="effective_from" name="effective_from" value="{{ old('effective_from', $plan?->effective_from?->format('Y-m-d')) }}" class="{{ $inputClass }} {{ $errors->has('effective_from') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('effective_from')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="effective_until" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Effective Until</label>
            <input type="date" id="effective_until" name="effective_until" value="{{ old('effective_until', $plan?->effective_until?->format('Y-m-d')) }}" class="{{ $inputClass }} {{ $errors->has('effective_until') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            <p class="mt-1.5 text-xs text-ink-soft">Leave empty for an open-ended plan.</p>
            @error('effective_until')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="description" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Description</label>
            <textarea id="description" name="description" rows="3" class="{{ $inputClass }}">{{ old('description', $plan?->description) }}</textarea>
            @error('description')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="sort_order" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Sort Order</label>
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $plan?->sort_order ?? 0) }}" min="0" class="{{ $inputClass }}">
            @error('sort_order')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-end">
            <label class="inline-flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-3">
                <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500" @checked(old('is_active', $plan?->is_active ?? true))>
                <span class="text-sm font-medium text-navy-950">Active — can be assigned as the applicable fee</span>
            </label>
        </div>
    </div>
</section>
