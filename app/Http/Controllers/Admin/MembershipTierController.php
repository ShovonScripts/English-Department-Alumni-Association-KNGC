<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipTier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MembershipTierController extends Controller
{
    public function index()
    {
        return view('admin.membership-tiers.index', [
            'tiers' => MembershipTier::query()->withCount('memberships')->ordered()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.membership-tiers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        $base = $validated['slug'];
        $suffix = 2;
        while (MembershipTier::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $base.'-'.$suffix++;
        }

        MembershipTier::create($validated);

        return redirect()
            ->route('admin.membership-tiers.index')
            ->with('status', 'Membership tier created.');
    }

    public function edit(MembershipTier $membershipTier)
    {
        return view('admin.membership-tiers.edit', [
            'tier' => $membershipTier->loadCount('memberships'),
        ]);
    }

    public function update(Request $request, MembershipTier $membershipTier)
    {
        $validated = $request->validate($this->rules());
        $validated['is_active'] = $request->boolean('is_active');

        // The slug is the stable identifier and is intentionally not renamed.
        $membershipTier->update($validated);

        return redirect()
            ->route('admin.membership-tiers.index')
            ->with('status', 'Membership tier updated.');
    }

    public function destroy(MembershipTier $membershipTier)
    {
        if ($membershipTier->memberships()->exists()) {
            return redirect()
                ->route('admin.membership-tiers.index')
                ->with('error', "“{$membershipTier->name}” is held by existing memberships. Deactivate it instead of deleting.");
        }

        $membershipTier->delete();

        return redirect()
            ->route('admin.membership-tiers.index')
            ->with('status', 'Membership tier deleted.');
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
            'badge_label' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
