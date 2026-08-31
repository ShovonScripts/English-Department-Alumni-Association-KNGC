@php
    $membership = $membership ?? null;
    $inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
@endphp

<section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Membership Details</h2>
    <p class="mt-1 text-sm text-ink-soft">
        @if ($membership)
            Membership number <span class="font-mono font-semibold text-navy-900">{{ $membership->membership_number }}</span> cannot be changed.
        @else
            The membership number is generated automatically on creation.
        @endif
    </p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="alumni_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Alumni *</label>
            @if ($membership)
                <div class="flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-navy-900 font-serif text-xs font-semibold text-gold-300" aria-hidden="true">
                        {{ \Illuminate\Support\Str::initials($membership->alumni?->full_name ?? '') }}
                    </span>
                    <div>
                        <p class="text-sm font-semibold text-navy-950">{{ $membership->alumni?->full_name }}</p>
                        <p class="text-xs text-ink-soft">{{ $membership->alumni?->student_id ? 'Student ID '.$membership->alumni->student_id.' · ' : '' }}Batch {{ $membership->alumni?->batch ?? '—' }}</p>
                    </div>
                </div>
            @else
                <select id="alumni_id" name="alumni_id" required class="{{ $inputClass }} {{ $errors->has('alumni_id') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
                    <option value="">Select an alumni record…</option>
                    @foreach ($availableAlumni as $option)
                        <option value="{{ $option->id }}" @selected(old('alumni_id') == $option->id)>
                            {{ $option->full_name }}{{ $option->student_id ? ' ('.$option->student_id.')' : '' }}{{ $option->batch ? ' — Batch '.$option->batch : '' }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1.5 text-xs text-ink-soft">Only alumni without an existing membership are listed.</p>
            @endif
            @error('alumni_id')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="membership_type_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Type *</label>
            <select id="membership_type_id" name="membership_type_id" required class="{{ $inputClass }} {{ $errors->has('membership_type_id') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
                <option value="">Select type…</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}" @selected(old('membership_type_id', $membership?->membership_type_id) == $type->id)>{{ $type->name }}</option>
                @endforeach
            </select>
            @error('membership_type_id')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="membership_tier_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Tier</label>
            <select id="membership_tier_id" name="membership_tier_id" class="{{ $inputClass }} {{ $errors->has('membership_tier_id') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
                <option value="">No tier assigned</option>
                @foreach ($tiers as $tier)
                    <option value="{{ $tier->id }}" @selected(old('membership_tier_id', $membership?->membership_tier_id) == $tier->id)>{{ $tier->name }}</option>
                @endforeach
            </select>
            @error('membership_tier_id')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status *</label>
            <select id="status" name="status" required class="{{ $inputClass }} {{ $errors->has('status') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
                @foreach (\App\Models\Membership::STATUSES as $value)
                    <option value="{{ $value }}" @selected(old('status', $membership?->status ?? \App\Models\Membership::STATUS_PENDING) === $value)>{{ ucfirst($value) }}</option>
                @endforeach
            </select>
            @error('status')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="joined_at" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Joined Date</label>
            <input type="date" id="joined_at" name="joined_at" value="{{ old('joined_at', $membership?->joined_at?->format('Y-m-d')) }}" max="{{ now()->toDateString() }}" class="{{ $inputClass }} {{ $errors->has('joined_at') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('joined_at')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        @if ($membership && $membership->approved_at)
            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Approved Date</label>
                <p class="rounded-md border border-navy-200 bg-cream px-4 py-2.5 text-sm text-navy-950">{{ $membership->approved_at->format('M j, Y') }}</p>
            </div>
        @endif

        <div class="sm:col-span-2">
            <label for="notes" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Admin Notes</label>
            <textarea id="notes" name="notes" rows="3" placeholder="Internal notes — never shown publicly." class="{{ $inputClass }}">{{ old('notes', $membership?->notes) }}</textarea>
            @error('notes')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2 flex items-start">
            <label class="inline-flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-3">
                <input type="checkbox" name="is_public" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500" @checked(old('is_public', $membership?->is_public ?? false))>
                <span class="text-sm font-medium text-navy-950">Show membership publicly on the alumni profile</span>
            </label>
        </div>

        <div class="sm:col-span-2 flex items-start">
            <div class="inline-flex flex-col gap-1 rounded-md border border-navy-200 bg-cream px-4 py-3">
                <label class="inline-flex items-center gap-3">
                    <input type="checkbox" name="show_on_leaderboard" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500" @checked(old('show_on_leaderboard', $membership?->show_on_leaderboard ?? true))>
                    <span class="text-sm font-medium text-navy-950">Show on Public Leaderboard</span>
                </label>
                <span class="text-xs text-ink-soft">When disabled, this member will not appear on the public contribution leaderboard. This does not affect payment records, contribution totals, or the public alumni profile.</span>
            </div>
        </div>
    </div>
</section>
