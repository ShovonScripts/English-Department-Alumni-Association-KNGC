@php
    $payment = $payment ?? null;
    $inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
@endphp

<section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Collection Details</h2>
    <p class="mt-1 text-sm text-ink-soft">
        @if ($payment)
            Payment number and member/plan relationships are permanent financial identifiers.
        @else
            Record money collected manually by an authorized administrator. This is an association due, not a website purchase.
        @endif
    </p>

    {{-- Alpine state: filters fee plans by the member's membership type and
         surfaces the applicable amount for the selected plan. --}}
    <div
        x-data="{
            membershipOptions: @js($memberships->map(fn ($m) => ['id' => $m->id, 'type' => $m->membership_type_id, 'label' => trim(($m->alumni?->full_name ?? 'Unknown').' — '.$m->membership_number.' · '.($m->type?->name ?? ''))])->values()->all()),
            plans: @js($feePlans->map(fn ($p) => ['id' => $p->id, 'type' => $p->membership_type_id, 'name' => $p->name.' ('.$p->frequency->label().')', 'amount' => (float) $p->amount, 'active' => $p->is_active])->values()->all()),
            membershipId: @js(old('membership_id', $payment?->membership_id)),
            planId: @js(old('fee_plan_id', $payment?->fee_plan_id)),
            get selectedMembership() { return this.membershipOptions.find(m => m.id == this.membershipId) || null },
            get selectedPlan() { return this.plans.find(p => p.id == this.planId) || null },
            get allowedPlans() {
                if (!this.selectedMembership) return []
                return this.plans.filter(p => p.type === this.selectedMembership.type)
            },
        }"
    >
        <div class="mt-6 grid gap-6 sm:grid-cols-2">
            <div>
                <label for="membership_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Member *</label>
                @if ($payment)
                    <div class="rounded-md border border-navy-200 bg-cream px-4 py-2.5 text-sm font-medium text-navy-950">
                        {{ $payment->membership?->alumni?->full_name }} — {{ $payment->membership?->membership_number }}
                    </div>
                @else
                    <select id="membership_id" name="membership_id" required x-model.number="membershipId" class="{{ $inputClass }} {{ $errors->has('membership_id') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
                        <option value="">Select a member…</option>
                        <template x-for="option in membershipOptions" :key="option.id">
                            <option :value="option.id" x-text="option.label" :selected="option.id === membershipId"></option>
                        </template>
                    </select>
                    <p class="mt-1.5 text-xs text-ink-soft">Only registered memberships can receive collections.</p>
                @endif
                @error('membership_id')
                    <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="fee_plan_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Fee Plan *</label>
                @if ($payment)
                    <div class="rounded-md border border-navy-200 bg-cream px-4 py-2.5 text-sm font-medium text-navy-950">
                        {{ $payment->feePlan?->name }} <span class="text-ink-soft">(৳{{ number_format((float) $payment->feePlan?->amount) }})</span>
                    </div>
                @else
                    <select id="fee_plan_id" name="fee_plan_id" required x-model.number="planId" class="{{ $inputClass }} {{ $errors->has('fee_plan_id') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
                        <option value="">Select a fee plan…</option>
                        <template x-for="plan in allowedPlans" :key="plan.id">
                            <option :value="plan.id" x-text="(plan.active ? '' : '[Inactive] ') + plan.name + ' — ৳' + Number(plan.amount).toLocaleString()"></option>
                        </template>
                    </select>
                    <p class="mt-1.5 text-xs text-ink-soft">Historical (inactive/expired) plans of the same type remain selectable.</p>
                @endif
                @error('fee_plan_id')
                    <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
                @enderror
            </div>

            <div class="rounded-md border border-navy-200 bg-cream px-4 py-3 text-sm sm:col-span-2" x-show="selectedPlan" x-cloak>
                <span class="font-medium text-navy-950">Applicable Fee:</span>
                <span class="font-semibold text-maroon-700" x-text="selectedPlan ? '৳' + Number(selectedPlan.amount).toLocaleString() : '—'"></span>
            </div>

            <div>
                <label for="amount" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Amount Collected (৳) *</label>
                <input type="number" id="amount" name="amount" x-ref="amount" value="{{ old('amount', $payment?->amount) }}" required min="0" step="0.01" placeholder="e.g. 50" class="{{ $inputClass }} {{ $errors->has('amount') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
                @error('amount')
                    <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status *</label>
                <select id="status" name="status" required class="{{ $inputClass }} {{ $errors->has('status') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
                    @foreach ($statuses as $status)
                        <option value="{{ $status->value }}" @selected(old('status', $payment?->status?->value ?? \App\Enums\PaymentStatus::Paid->value) === $status->value)>{{ $status->label() }}</option>
                    @endforeach
                </select>
                <p class="mt-1.5 text-xs text-ink-soft">Waived records clear the obligation but never count as collected cash.</p>
                @error('status')
                    <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="paid_at" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Payment Date *</label>
                <input type="date" id="paid_at" name="paid_at" value="{{ old('paid_at', $payment?->paid_at?->format('Y-m-d') ?? now()->toDateString()) }}" max="{{ now()->toDateString() }}" required class="{{ $inputClass }} {{ $errors->has('paid_at') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
                @error('paid_at')
                    <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="reference" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Reference</label>
                <input type="text" id="reference" name="reference" value="{{ old('reference', $payment?->reference) }}" placeholder="e.g. Cash Receipt #1024" maxlength="255" class="{{ $inputClass }}">
                @error('reference')
                    <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="notes" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Admin Notes</label>
                <textarea id="notes" name="notes" rows="3" maxlength="2000" placeholder="Internal only — never shown publicly." class="{{ $inputClass }}">{{ old('notes', $payment?->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</section>
