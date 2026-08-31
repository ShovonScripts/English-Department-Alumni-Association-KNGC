@php
    $expense = $expense ?? null;
    $inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
@endphp

<section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Expense Details</h2>
    <p class="mt-1 text-sm text-ink-soft">
        @if ($expense)
            The expense number, status, and recorder are permanent financial identifiers and cannot be changed.
        @else
            Record money spent by the association. This is an association expense, not a business purchase.
        @endif
    </p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div>
            <label for="expense_category_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Category *</label>
            @if ($expense && $expense->status->isVoid())
                <div class="rounded-md border border-navy-200 bg-cream px-4 py-2.5 text-sm font-medium text-navy-950">{{ $expense->category?->name }}</div>
            @else
                <select id="expense_category_id" name="expense_category_id" required class="{{ $inputClass }} {{ $errors->has('expense_category_id') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
                    <option value="">Select a category…</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('expense_category_id', $expense?->expense_category_id) == $category->id)>{{ $category->name }}{{ $category->is_active ? '' : ' (inactive)' }}</option>
                    @endforeach
                </select>
            @endif
            @error('expense_category_id')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="title" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Title *</label>
            <input type="text" id="title" name="title" value="{{ old('title', $expense?->title) }}" required maxlength="255" placeholder="e.g. Annual reunion venue booking" class="{{ $inputClass }} {{ $errors->has('title') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('title')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="amount" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Amount (৳) *</label>
            <input type="number" id="amount" name="amount" value="{{ old('amount', $expense?->amount) }}" required min="0" step="0.01" placeholder="e.g. 5000" class="{{ $inputClass }} {{ $errors->has('amount') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('amount')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="expense_date" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Expense Date *</label>
            <input type="date" id="expense_date" name="expense_date" value="{{ old('expense_date', $expense?->expense_date?->format('Y-m-d') ?? now()->toDateString()) }}" max="{{ now()->toDateString() }}" required class="{{ $inputClass }} {{ $errors->has('expense_date') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('expense_date')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="reference" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Reference</label>
            <input type="text" id="reference" name="reference" value="{{ old('reference', $expense?->reference) }}" placeholder="e.g. Voucher 2026-011" maxlength="255" class="{{ $inputClass }}">
            @error('reference')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="description" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Description</label>
            <textarea id="description" name="description" rows="3" maxlength="2000" placeholder="What was this association spending for?" class="{{ $inputClass }}">{{ old('description', $expense?->description) }}</textarea>
            @error('description')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>
