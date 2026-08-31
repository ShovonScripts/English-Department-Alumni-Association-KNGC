<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\FeePlan;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\MembershipType;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MembershipController extends Controller
{
    public function verify(Membership $membership)
    {
        $user = $membership->alumni->user;
        if ($user) {
            $user->forceFill([
                'verified_at' => now(),
                'verified_by' => auth()->id(),
            ])->save();
        }

        return back()->with('success', 'Member verified successfully.');
    }

    public function unverify(Membership $membership)
    {
        $user = $membership->alumni->user;
        if ($user) {
            $user->forceFill([
                'verified_at' => null,
                'verified_by' => null,
            ])->save();
        }

        return back()->with('success', 'Verification removed.');
    }

    public function disable(Membership $membership)
    {
        $user = $membership->alumni->user;
        if ($user) {
            $user->forceFill(['status' => 'disabled'])->save();
        }

        return back()->with('success', 'Account disabled.');
    }

    public function enable(Membership $membership)
    {
        $user = $membership->alumni->user;
        if ($user) {
            $user->forceFill(['status' => 'active'])->save();
        }

        return back()->with('success', 'Account enabled.');
    }

    public function index(Request $request)
    {
        $search = trim((string) $request->query('search'));
        $status = $request->query('status');
        $typeId = $request->query('membership_type_id');
        $tierId = $request->query('membership_tier_id');

        $memberships = Membership::query()
            ->with(['alumni', 'type', 'tier'])
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('membership_number', 'like', "%{$search}%")
                    ->orWhereHas('alumni', fn ($q) => $q->where(function ($q) use ($search) {
                        $q->where('full_name', 'like', "%{$search}%")
                            ->orWhere('student_id', 'like', "%{$search}%");
                    }));
            }))
            ->when($status, fn ($query, $value) => $query->where('status', $value))
            ->when($typeId, fn ($query, $value) => $query->where('membership_type_id', $value))
            ->when($tierId !== null && $tierId !== '', fn ($query) => $query->when(
                $tierId === 'none',
                fn ($q) => $q->whereNull('membership_tier_id'),
                fn ($q) => $q->where('membership_tier_id', $tierId)
            ))
            ->orderBy('membership_number')
            ->paginate(15)
            ->withQueryString();

        return view('admin.members.index', [
            'memberships' => $memberships,
            'filters' => [
                'search' => $search,
                'status' => $status,
                'membership_type_id' => $typeId,
                'membership_tier_id' => $tierId,
            ],
            'types' => MembershipType::query()->ordered()->get(),
            'tiers' => MembershipTier::query()->ordered()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.members.create', [
            'availableAlumni' => $this->eligibleAlumni(),
            'types' => MembershipType::query()->active()->ordered()->get(),
            'tiers' => MembershipTier::query()->active()->ordered()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $validated['is_public'] = $request->boolean('is_public');
        $validated['show_on_leaderboard'] = $request->boolean('show_on_leaderboard');
        $validated['membership_number'] = Membership::generateMembershipNumber();

        if ($validated['status'] === Membership::STATUS_ACTIVE && empty($validated['approved_at'])) {
            $validated['approved_at'] = now()->toDateString();
        }

        $membership = DB::transaction(function () use ($validated) {
            return Membership::create($validated);
        });

        $membership->syncApprovalStamp();

        return redirect()
            ->route('admin.members.show', $membership)
            ->with('status', "Membership {$membership->membership_number} created.");
    }

    public function show(Membership $membership)
    {
        $membership->load(['alumni', 'type', 'tier']);

        // Informational only — nothing here marks a member as paid/unpaid.
        $currentFee = $membership->membership_type_id !== null
            ? FeePlan::currentForType($membership->membership_type_id)
            : null;

        // Fee & payment summary for this membership's applicable fee.
        $summary = null;
        if ($currentFee !== null) {
            $summary = Payment::obligationFor($membership->id, $currentFee);
        }

        $recentPayments = $membership->payments()
            ->with(['feePlan', 'recordedBy'])
            ->orderByDesc('paid_at')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        return view('admin.members.show', [
            'membership' => $membership,
            'currentFee' => $currentFee,
            'summary' => $summary,
            'recentPayments' => $recentPayments,
            'paymentCount' => $membership->payments()->valid()->count(),
        ]);
    }

    public function edit(Membership $membership)
    {
        return view('admin.members.edit', [
            'membership' => $membership->load(['alumni', 'type', 'tier']),
            'types' => MembershipType::query()->ordered()->get(),
            'tiers' => MembershipTier::query()->ordered()->get(),
        ]);
    }

    public function update(Request $request, Membership $membership)
    {
        $validated = $request->validate($this->rules($membership));

        $validated['is_public'] = $request->boolean('is_public');
        $validated['show_on_leaderboard'] = $request->boolean('show_on_leaderboard');

        if ($validated['status'] === Membership::STATUS_ACTIVE && $membership->approved_at === null && empty($validated['approved_at'])) {
            $validated['approved_at'] = now()->toDateString();
        }

        // The alumni relationship is intentionally immutable after creation.
        unset($validated['alumni_id']);

        $membership->update($validated);
        $membership->syncApprovalStamp();

        return redirect()
            ->route('admin.members.show', $membership)
            ->with('status', "Membership {$membership->membership_number} updated.");
    }

    public function destroy(Membership $membership)
    {
        // Financial records must remain traceable; block deletion when the
        // membership carries payment history.
        if ($membership->payments()->exists()) {
            return redirect()
                ->route('admin.members.index')
                ->with('error', "Membership {$membership->membership_number} has payment records and cannot be deleted. Void the payments or keep the record for financial integrity.");
        }

        $label = $membership->membership_number;

        $membership->delete();

        return redirect()
            ->route('admin.members.index')
            ->with('status', "Membership {$label} deleted.");
    }

    public function suspend(Membership $membership)
    {
        $membership->update(['status' => Membership::STATUS_SUSPENDED]);

        // Also disable the associated user account to block portal access.
        $user = $membership->alumni->user;
        if ($user) {
            $user->forceFill(['status' => 'disabled'])->save();
        }

        return redirect()
            ->route('admin.members.show', $membership)
            ->with('status', "Membership {$membership->membership_number} suspended.");
    }

    public function activate(Membership $membership)
    {
        $membership->update(['status' => Membership::STATUS_ACTIVE]);
        $membership->syncApprovalStamp();

        // Re-enable the associated user account to restore portal access.
        $user = $membership->alumni->user;
        if ($user) {
            $user->forceFill(['status' => 'active'])->save();
        }

        return redirect()
            ->route('admin.members.show', $membership)
            ->with('status', "Membership {$membership->membership_number} activated.");
    }

    /**
     * Toggle the public visibility of a membership without affecting
     * status, tier, type, or any financial data.
     */
    public function togglePublic(Membership $membership)
    {
        $membership->update(['is_public' => ! $membership->is_public]);

        $state = $membership->is_public ? 'public' : 'private';

        return redirect()
            ->route('admin.members.show', $membership)
            ->with('status', "Membership {$membership->membership_number} is now {$state}.");
    }

    /**
     * Alumni records that do not yet hold a membership.
     */
    protected function eligibleAlumni()
    {
        return Alumni::query()
            ->whereDoesntHave('membership')
            ->where('status', Alumni::STATUS_ACTIVE)
            ->orderBy('full_name')
            ->get(['id', 'full_name', 'student_id', 'batch']);
    }

    /**
     * Validation rules shared by store and update.
     *
     * @return array<string, mixed>
     */
    protected function rules(?Membership $membership = null): array
    {
        $alumniUnique = Rule::unique('memberships', 'alumni_id');

        if ($membership) {
            $alumniUnique->ignore($membership->id);
        }

        return [
            'alumni_id' => ['required', 'integer', 'exists:alumni,id', $alumniUnique],
            'membership_type_id' => ['required', 'integer', 'exists:membership_types,id'],
            'membership_tier_id' => ['nullable', 'integer', 'exists:membership_tiers,id'],
            'status' => ['required', Rule::in(Membership::STATUSES)],
            'joined_at' => ['nullable', 'date', 'before_or_equal:today'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'is_public' => ['sometimes', 'boolean'],
            'show_on_leaderboard' => ['sometimes', 'boolean'],
        ];
    }
}
