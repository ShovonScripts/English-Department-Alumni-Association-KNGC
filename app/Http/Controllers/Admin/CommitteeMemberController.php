<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommitteeMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class CommitteeMemberController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search'));
        $position = $request->query('position');
        $active = $request->query('active');

        $members = CommitteeMember::query()
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%");
            }))
            ->when($position, fn ($query, $position) => $query->where('position', $position))
            ->when($active !== null && $active !== '', fn ($query) => $query->where('is_active', filter_var($active, FILTER_VALIDATE_BOOL)))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.committee.index', [
            'members' => $members,
            'filters' => [
                'search' => $search,
                'position' => $position,
                'active' => $active,
            ],
            'positions' => CommitteeMember::query()->whereNotNull('position')->distinct()->orderBy('position')->pluck('position'),
        ]);
    }

    public function create()
    {
        return view('admin.committee.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $data['slug'] = CommitteeMember::uniqueSlug($data['name']);

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('committee', 'public');
        }

        CommitteeMember::create($data);

        return redirect()
            ->route('admin.committee.index')
            ->with('status', 'Committee member created.');
    }

    public function show(CommitteeMember $committeeMember)
    {
        return view('admin.committee.show', [
            'member' => $committeeMember,
        ]);
    }

    public function edit(CommitteeMember $committeeMember)
    {
        return view('admin.committee.edit', [
            'member' => $committeeMember,
        ]);
    }

    public function update(Request $request, CommitteeMember $committeeMember)
    {
        $data = $request->validate($this->rules($committeeMember));

        if ($request->hasFile('profile_photo')) {
            if ($committeeMember->profile_photo) {
                Storage::disk('public')->delete($committeeMember->profile_photo);
            }

            $data['profile_photo'] = $request->file('profile_photo')->store('committee', 'public');
        }

        $committeeMember->update($data);

        return redirect()
            ->route('admin.committee.index')
            ->with('status', 'Committee member updated.');
    }

    public function destroy(CommitteeMember $committeeMember)
    {
        if ($committeeMember->profile_photo) {
            Storage::disk('public')->delete($committeeMember->profile_photo);
        }

        $committeeMember->delete();

        return redirect()
            ->route('admin.committee.index')
            ->with('status', 'Committee member deleted.');
    }

    /**
     * Validation rules shared by store and update.
     *
     * @return array<string, mixed>
     */
    protected function rules(?CommitteeMember $member = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'short_bio' => ['nullable', 'string', 'max:500'],
            'biography' => ['nullable', 'string', 'max:5000'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
            'profile_photo' => [
                'nullable',
                'sometimes',
                File::image()
                    ->max('2mb')
                    ->dimensions(Rule::dimensions()->maxWidth(4000)->maxHeight(4000)),
            ],
        ];
    }
}
