<?php

namespace App\Http\Controllers\Admin;

use App\Enums\FeeFrequency;
use App\Http\Controllers\Controller;
use App\Models\FeePlan;
use App\Models\MembershipType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FeePlanController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search'));
        $typeId = $request->query('membership_type_id');
        $frequency = $request->query('frequency');
        $status = $request->query('status');
        $timing = $request->query('timing');

        $feePlans = FeePlan::query()
            ->with('membershipType')
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhereHas('membershipType', fn ($q) => $q->where('name', 'like', "%{$search}%"));
            }))
            ->when($typeId, fn ($query, $value) => $query->forType((int) $value))
            ->when($frequency, fn ($query, $value) => $query->where('frequency', $value))
            ->when($status === 'active', fn ($query) => $query->active())
            ->when($status === 'inactive', fn ($query) => $query->where('is_active', false))
            ->when($timing === 'current', fn ($query) => $query->current())
            ->when($timing === 'upcoming', fn ($query) => $query->upcoming())
            ->when($timing === 'expired', fn ($query) => $query->expired())
            ->ordered()
            ->paginate(15)
            ->withQueryString();

        return view('admin.fee-plans.index', [
            'feePlans' => $feePlans,
            'filters' => [
                'search' => $search,
                'membership_type_id' => $typeId,
                'frequency' => $frequency,
                'status' => $status,
                'timing' => $timing,
            ],
            'types' => MembershipType::query()->ordered()->get(),
            'frequencies' => FeeFrequency::cases(),
        ]);
    }

    public function create()
    {
        return view('admin.fee-plans.create', [
            'types' => MembershipType::query()->active()->ordered()->get(),
            'frequencies' => FeeFrequency::cases(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $validated['slug'] = Str::slug($validated['name']);
        $base = $validated['slug'];
        $suffix = 2;
        while (FeePlan::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $base.'-'.$suffix++;
        }

        $validated['currency'] = $validated['currency'] ?? 'BDT';
        $validated['is_active'] = $request->boolean('is_active');

        $plan = FeePlan::create($validated);

        if ($plan->overlapsWithActiveSibling()) {
            return redirect()
                ->route('admin.fee-plans.show', $plan)
                ->with('warning', "Fee plan created, but another active plan for “{$plan->membershipType->name}” overlaps this period. Review the effective dates to avoid ambiguity.");
        }

        return redirect()
            ->route('admin.fee-plans.show', $plan)
            ->with('status', "Fee plan “{$plan->name}” created.");
    }

    public function show(FeePlan $feePlan)
    {
        return view('admin.fee-plans.show', [
            'plan' => $feePlan->load('membershipType'),
        ]);
    }

    public function edit(FeePlan $feePlan)
    {
        return view('admin.fee-plans.edit', [
            'plan' => $feePlan->load('membershipType'),
            'types' => MembershipType::query()->ordered()->get(),
            'frequencies' => FeeFrequency::cases(),
        ]);
    }

    public function update(Request $request, FeePlan $feePlan)
    {
        $validated = $request->validate($this->rules());
        $validated['currency'] = $validated['currency'] ?? 'BDT';
        $validated['is_active'] = $request->boolean('is_active');

        // The slug is the stable identifier and is intentionally not renamed.
        $feePlan->update($validated);

        if ($feePlan->overlapsWithActiveSibling()) {
            return redirect()
                ->route('admin.fee-plans.show', $feePlan)
                ->with('warning', "Fee plan updated, but another active plan for “{$feePlan->membershipType->name}” overlaps this period. Review the effective dates to avoid ambiguity.");
        }

        return redirect()
            ->route('admin.fee-plans.show', $feePlan)
            ->with('status', "Fee plan “{$feePlan->name}” updated.");
    }

    public function destroy(FeePlan $feePlan)
    {
        // Feature 13 will reference fee plans from payment records; once a
        // plan is referenced it must be deactivated instead of deleted.
        // The payments table does not exist yet, so all current plans are
        // unreferenced and deletable — this guard is where that check goes.
        $referencedByPayments = false;

        if ($referencedByPayments) {
            return redirect()
                ->route('admin.fee-plans.index')
                ->with('error', "“{$feePlan->name}” is referenced by payment records. Deactivate it instead of deleting.");
        }

        $label = $feePlan->name;
        $feePlan->delete();

        return redirect()
            ->route('admin.fee-plans.index')
            ->with('status', "Fee plan “{$label}” deleted.");
    }

    public function activate(FeePlan $feePlan)
    {
        $feePlan->update(['is_active' => true]);

        return redirect()
            ->route('admin.fee-plans.show', $feePlan)
            ->with('status', "Fee plan “{$feePlan->name}” activated.");
    }

    public function deactivate(FeePlan $feePlan)
    {
        $feePlan->update(['is_active' => false]);

        return redirect()
            ->route('admin.fee-plans.show', $feePlan)
            ->with('status', "Fee plan “{$feePlan->name}” deactivated.");
    }

    /**
     * Validation rules shared by store and update.
     *
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'membership_type_id' => ['required', 'integer', 'exists:membership_types,id'],
            'amount' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'currency' => ['nullable', 'string', 'size:3', 'in:BDT'],
            'frequency' => ['required', Rule::in(FeeFrequency::values())],
            'description' => ['nullable', 'string', 'max:2000'],
            'effective_from' => ['nullable', 'date'],
            'effective_until' => ['nullable', 'date', 'after_or_equal:effective_from'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
