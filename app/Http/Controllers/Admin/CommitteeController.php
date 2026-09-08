<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use App\Models\CommitteeRole;
use App\Models\CommitteeType;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CommitteeController extends Controller
{
    // ──────────────────────────────────────────────────────────────
    // COMMITTEE TYPES
    // ──────────────────────────────────────────────────────────────

    public function typeIndex()
    {
        return view('admin.committees.types.index', [
            'types' => CommitteeType::query()->ordered()->get(),
        ]);
    }

    public function typeCreate()
    {
        return view('admin.committees.types.create');
    }

    public function typeStore(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['slug'] = CommitteeType::uniqueSlug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        $type = CommitteeType::create($validated);

        return redirect()
            ->route('admin.committee-types.show', $type)
            ->with('status', "Committee type \"{$type->name}\" created.");
    }

    public function typeShow(CommitteeType $committeeType)
    {
        return view('admin.committees.types.show', [
            'type' => $committeeType->load(['committees' => fn ($q) => $q->ordered()]),
        ]);
    }

    public function typeEdit(CommitteeType $committeeType)
    {
        return view('admin.committees.types.edit', [
            'type' => $committeeType,
        ]);
    }

    public function typeUpdate(Request $request, CommitteeType $committeeType)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $committeeType->update($validated);

        return redirect()
            ->route('admin.committee-types.show', $committeeType)
            ->with('status', "Committee type \"{$committeeType->name}\" updated.");
    }

    public function typeDestroy(CommitteeType $committeeType)
    {
        if ($committeeType->committees()->exists()) {
            return redirect()
                ->route('admin.committee-types.index')
                ->with('error', "\"{$committeeType->name}\" has committees and cannot be deleted. Deactivate it instead.");
        }

        $label = $committeeType->name;
        $committeeType->delete();

        return redirect()
            ->route('admin.committee-types.index')
            ->with('status', "Committee type \"{$label}\" deleted.");
    }

    // ──────────────────────────────────────────────────────────────
    // COMMITTEES
    // ──────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $search = trim((string) $request->query('search'));
        $typeId = $request->query('committee_type_id');

        $committees = Committee::query()
            ->with('type')
            ->when($search !== '', fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($typeId, fn ($q) => $q->where('committee_type_id', (int) $typeId))
            ->ordered()
            ->paginate(15)
            ->withQueryString();

        return view('admin.committees.index', [
            'committees' => $committees,
            'filters' => ['search' => $search, 'committee_type_id' => $typeId],
            'types' => CommitteeType::query()->active()->ordered()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.committees.create', [
            'types' => CommitteeType::query()->active()->ordered()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->committeeRules());

        $validated['slug'] = Committee::uniqueSlug($validated['name']);

        $committee = Committee::create($validated);

        return redirect()
            ->route('admin.committees.show', $committee)
            ->with('status', "Committee \"{$committee->name}\" created.");
    }

    public function show(Committee $committee)
    {
        $committee->load('type');
        $members = $committee->membersWithRoles();

        $roles = CommitteeRole::query()->orderBy('sort_order')->get();
        $groupedMembers = $roles->mapWithKeys(function ($role) use ($members) {
            $roleMembers = $members->filter(fn ($m) => $m->pivot_committee_role_id === $role->id);
            return [$role->id => [
                'role' => $role,
                'members' => $roleMembers,
            ]];
        })->filter(fn ($group) => $group['members']->isNotEmpty());

        $unassignedMembers = $members->filter(fn ($m) => !$roles->pluck('id')->contains($m->pivot_committee_role_id));

        return view('admin.committees.show', [
            'committee' => $committee,
            'members' => $members,
            'groupedMembers' => $groupedMembers,
            'unassignedMembers' => $unassignedMembers,
            'roles' => $roles,
        ]);
    }

    public function edit(Committee $committee)
    {
        return view('admin.committees.edit', [
            'committee' => $committee,
            'types' => CommitteeType::query()->active()->ordered()->get(),
        ]);
    }

    public function update(Request $request, Committee $committee)
    {
        $validated = $request->validate($this->committeeRules());

        $committee->update($validated);

        return redirect()
            ->route('admin.committees.show', $committee)
            ->with('status', "Committee \"{$committee->name}\" updated.");
    }

    public function destroy(Committee $committee)
    {
        $label = $committee->name;
        $committee->delete();

        return redirect()
            ->route('admin.committees.index')
            ->with('status', "Committee \"{$label}\" deleted.");
    }

    /**
     * Mark a committee as current for its type.
     */
    public function makeCurrent(Committee $committee)
    {
        $committee->markAsCurrent();

        return redirect()
            ->route('admin.committees.show', $committee)
            ->with('status', "\"{$committee->name}\" is now the current committee for \"{$committee->type->name}\".");
    }

    // ──────────────────────────────────────────────────────────────
    // COMMITTEE MEMBERS
    // ──────────────────────────────────────────────────────────────

    public function addMember(Request $request, Committee $committee)
    {
        $validated = $request->validate([
            'membership_id' => ['required', 'integer', Rule::exists('memberships', 'id')],
            'committee_role_id' => ['required', 'integer', Rule::exists('committee_roles', 'id')],
        ]);

        $committee->members()->attach($validated['membership_id'], [
            'committee_role_id' => $validated['committee_role_id'],
            'sort_order' => $committee->members()->count() + 1,
        ]);

        return redirect()
            ->route('admin.committees.show', $committee)
            ->with('status', 'Member added to committee.');
    }

    public function removeMember(Committee $committee, Membership $membership)
    {
        $committee->members()->detach($membership->id);

        return redirect()
            ->route('admin.committees.show', $committee)
            ->with('status', 'Member removed from committee.');
    }

    public function updateMemberRole(Request $request, Committee $committee, Membership $membership)
    {
        $validated = $request->validate([
            'committee_role_id' => ['required', 'integer', Rule::exists('committee_roles', 'id')],
        ]);

        $committee->members()->updateExistingPivot($membership->id, [
            'committee_role_id' => $validated['committee_role_id'],
        ]);

        return redirect()
            ->route('admin.committees.show', $committee)
            ->with('status', 'Member role updated.');
    }

    // ──────────────────────────────────────────────────────────────
    // COMMITTEE ROLES (manageable from types page)
    // ──────────────────────────────────────────────────────────────

    public function roleIndex()
    {
        return view('admin.committees.roles.index', [
            'roles' => CommitteeRole::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function roleStore(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['slug'] = CommitteeRole::uniqueSlug($validated['name']);

        CommitteeRole::create($validated);

        return redirect()
            ->route('admin.committee-roles.index')
            ->with('status', "Role \"{$validated['name']}\" created.");
    }

    public function roleDestroy(CommitteeRole $role)
    {
        if (DB::table('committee_pivot')->where('committee_role_id', $role->id)->exists()) {
            return redirect()
                ->route('admin.committee-roles.index')
                ->with('error', "\"{$role->name}\" is in use and cannot be deleted.");
        }

        $label = $role->name;
        $role->delete();

        return redirect()
            ->route('admin.committee-roles.index')
            ->with('status', "Role \"{$label}\" deleted.");
    }

    public function roleUp(CommitteeRole $role)
    {
        $previous = CommitteeRole::query()
            ->where('sort_order', '<', $role->sort_order)
            ->orderByDesc('sort_order')
            ->first();

        if ($previous) {
            $currentOrder = $role->sort_order;
            $role->update(['sort_order' => $previous->sort_order]);
            $previous->update(['sort_order' => $currentOrder]);
        }

        return redirect()
            ->route('admin.committee-roles.index')
            ->with('status', "Role \"{$role->name}\" moved up.");
    }

    public function roleDown(CommitteeRole $role)
    {
        $next = CommitteeRole::query()
            ->where('sort_order', '>', $role->sort_order)
            ->orderBy('sort_order')
            ->first();

        if ($next) {
            $currentOrder = $role->sort_order;
            $role->update(['sort_order' => $next->sort_order]);
            $next->update(['sort_order' => $currentOrder]);
        }

        return redirect()
            ->route('admin.committee-roles.index')
            ->with('status', "Role \"{$role->name}\" moved down.");
    }

    // ──────────────────────────────────────────────────────────────
    // HELPERS
    // ──────────────────────────────────────────────────────────────

    protected function committeeRules(): array
    {
        return [
            'committee_type_id' => ['required', 'integer', Rule::exists('committee_types', 'id')],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'start_year' => ['required', 'integer', 'min:1960', 'max:'.((int) date('Y') + 2)],
            'end_year' => ['required', 'integer', 'min:1960', 'max:'.((int) date('Y') + 2), 'gte:start_year'],
            'is_current' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
