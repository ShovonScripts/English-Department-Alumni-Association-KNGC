<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\FeePlan;
use App\Models\Membership;
use App\Models\MembershipType;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search'));
        $status = $request->query('status');
        $typeId = $request->query('membership_type_id');
        $membershipId = $request->query('membership_id');
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');

        $query = Payment::query()
            ->with(['membership.alumni', 'membership.type', 'recordedBy'])
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('payment_number', 'like', "%" . $this->escapeLike($search) . "%")
                    ->orWhere('reference', 'like', "%" . $this->escapeLike($search) . "%")
                    ->orWhereHas('membership.alumni', fn ($q) => $q->where('full_name', 'like', "%" . $this->escapeLike($search) . "%"))
                    ->orWhereHas('membership', fn ($q) => $q->where('membership_number', 'like', "%" . $this->escapeLike($search) . "%"));
            }))
            ->when($status, fn ($query, $value) => $query->where('status', $value))
            ->when($typeId, fn ($query, $value) => $query->whereHas(
                'membership',
                fn ($q) => $q->where('membership_type_id', (int) $value)
            ))
            ->when($membershipId, fn ($query, $value) => $query->forMembership((int) $value))
            ->when($dateFrom, fn ($query, $value) => $query->whereDate('paid_at', '>=', $value))
            ->when($dateTo, fn ($query, $value) => $query->whereDate('paid_at', '<=', $value));

        $totals = (clone $query)->valid()->toBase()
            ->selectRaw('COUNT(*) as count, COALESCE(SUM(amount), 0) as total')
            ->first();

        $payments = $query->orderByDesc('paid_at')->orderByDesc('id')->paginate(15)->withQueryString();

        return view('admin.payments.index', [
            'payments' => $payments,
            'filters' => [
                'search' => $search,
                'status' => $status,
                'membership_type_id' => $typeId,
                'membership_id' => $membershipId,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
            ],
            'totalCollected' => (float) ($totals->total ?? 0),
            'validCount' => (int) ($totals->count ?? 0),
            'statuses' => PaymentStatus::cases(),
            'types' => MembershipType::query()->ordered()->get(),
            'filterMembership' => $membershipId ? Membership::query()->with('alumni')->find($membershipId) : null,
        ]);
    }

    public function create(Request $request)
    {
        $memberships = Membership::query()
            ->where('status', Membership::STATUS_ACTIVE)
            ->with(['alumni', 'type'])
            ->orderBy('membership_number')
            ->get();

        return view('admin.payments.create', [
            'memberships' => $memberships,
            'feePlans' => FeePlan::query()->get(),
            'statuses' => [PaymentStatus::Paid, PaymentStatus::Partial, PaymentStatus::Waived],
            'preselectedMembershipId' => $request->query('membership_id'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $membership = Membership::query()->findOrFail($validated['membership_id']);
        $feePlan = FeePlan::query()->findOrFail($validated['fee_plan_id']);

        if ($feePlan->membership_type_id !== $membership->membership_type_id) {
            return back()->withErrors([
                'fee_plan_id' => 'The selected fee plan does not match the membership type.',
            ])->withInput();
        }

        $payment = Payment::create([
            ...$validated,
            'currency' => 'BDT',
            'payment_number' => Payment::generatePaymentNumber(),
            'recorded_by' => $request->user()->id,
        ]);

        $membership->recalculateTier();

        return redirect()->route('admin.payments.show', $payment)
            ->with('status', "Payment {$payment->payment_number} recorded.");
    }

    public function show(Payment $payment)
    {
        $payment->load(['membership.alumni', 'membership.type', 'membership.tier', 'recordedBy']);

        $feePlan = $payment->feePlan;
        $collected = $payment->membership->payments()
            ->whereIn('status', [PaymentStatus::Paid, PaymentStatus::Partial])
            ->sum('amount');

        $obligation = [
            'expected' => $feePlan ? (float) $feePlan->amount : 0.0,
            'collected' => (float) $collected,
            'outstanding' => $feePlan ? max(0, (float) $feePlan->amount - (float) $collected) : 0.0,
        ];

        return view('admin.payments.show', [
            'payment' => $payment,
            'obligation' => $obligation,
        ]);
    }

    public function edit(Payment $payment)
    {
        abort_if($payment->status === PaymentStatus::Void, 403, 'Voided payments cannot be edited.');

        return view('admin.payments.edit', [
            'payment' => $payment->load(['membership.alumni', 'membership.type']),
            'memberships' => Membership::query()
                ->where(fn ($q) => $q
                    ->where('status', Membership::STATUS_ACTIVE)
                    ->orWhere('id', $payment->membership_id))
                ->with(['alumni', 'type'])
                ->orderBy('membership_number')
                ->get(),
            'statuses' => [PaymentStatus::Paid, PaymentStatus::Partial, PaymentStatus::Waived],
        ]);
    }

    public function update(Request $request, Payment $payment)
    {
        abort_if($payment->status === PaymentStatus::Void, 403, 'Voided payments cannot be edited.');

        $validated = $request->validate($this->rules());

        unset($validated['membership_id']);
        unset($validated['fee_plan_id']);

        $payment->update($validated);

        return redirect()
            ->route('admin.payments.show', $payment)
            ->with('status', "Payment {$payment->payment_number} updated.");
    }

    public function void(Request $request, Payment $payment)
    {
        if ($payment->status === PaymentStatus::Void) {
            return redirect()
                ->route('admin.payments.show', $payment)
                ->with('warning', "Payment {$payment->payment_number} is already void.");
        }

        $validated = $request->validate([
            'void_reason' => ['required', 'string', 'min:5', 'max:1000'],
        ]);

        $payment->forceFill([
            'status' => PaymentStatus::Void->value,
            'voided_at' => now(),
            'voided_by' => $request->user()->id,
            'void_reason' => $validated['void_reason'],
        ])->save();

        $payment->membership->recalculateTier();

        return redirect()
            ->route('admin.payments.show', $payment)
            ->with('status', "Payment {$payment->payment_number} voided. The record is retained for audit purposes.");
    }

    public function destroy(Payment $payment)
    {
        $paymentNumber = $payment->payment_number;
        $membership = $payment->membership;

        $payment->delete();

        $membership->recalculateTier();

        return redirect()
            ->route('admin.payments.index')
            ->with('status', "Payment {$paymentNumber} has been permanently deleted.");
    }

    protected function rules(): array
    {
        return [
            'membership_id' => ['required', 'integer', Rule::exists('memberships', 'id')],
            'fee_plan_id' => ['required', 'integer', Rule::exists('fee_plans', 'id')],
            'amount' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'status' => ['required', Rule::in([PaymentStatus::Paid->value, PaymentStatus::Partial->value, PaymentStatus::Waived->value])],
            'paid_at' => ['required', 'date', 'before_or_equal:today'],
            'reference' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
