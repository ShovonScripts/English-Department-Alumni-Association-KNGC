<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MembershipTypeController extends Controller
{
    public function index()
    {
        return view('admin.membership-types.index', [
            'types' => MembershipType::query()->withCount('memberships')->ordered()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.membership-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        // De-duplicate the slug if it already exists.
        $base = $validated['slug'];
        $suffix = 2;
        while (MembershipType::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $base.'-'.$suffix++;
        }

        MembershipType::create($validated);

        return redirect()
            ->route('admin.membership-types.index')
            ->with('status', 'Membership type created.');
    }

    public function edit(MembershipType $membershipType)
    {
        return view('admin.membership-types.edit', [
            'type' => $membershipType->loadCount('memberships'),
        ]);
    }

    public function update(Request $request, MembershipType $membershipType)
    {
        $validated = $request->validate($this->rules());
        $validated['is_active'] = $request->boolean('is_active');

        // The slug is the stable identifier and is intentionally not renamed.
        $membershipType->update($validated);

        return redirect()
            ->route('admin.membership-types.index')
            ->with('status', 'Membership type updated.');
    }

    public function destroy(MembershipType $membershipType)
    {
        if ($membershipType->memberships()->exists()) {
            return redirect()
                ->route('admin.membership-types.index')
                ->with('error', "“{$membershipType->name}” is used by existing memberships. Deactivate it instead of deleting.");
        }

        // Fee plans must keep their membership-type reference stable for
        // historical integrity, so referenced types cannot be deleted.
        if ($membershipType->feePlans()->exists()) {
            return redirect()
                ->route('admin.membership-types.index')
                ->with('error', "“{$membershipType->name}” is used by existing fee plans. Deactivate it instead of deleting.");
        }

        $membershipType->delete();

        return redirect()
            ->route('admin.membership-types.index')
            ->with('status', 'Membership type deleted.');
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
            'description' => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
