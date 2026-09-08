<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search'));
        $batch = $request->query('batch');
        $status = $request->query('status');

        $alumni = Alumni::query()
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('full_name', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%")
                    ->orWhere('organization', 'like', "%{$search}%")
                    ->orWhere('profession', 'like', "%{$search}%");
            }))
            ->when($batch, fn ($query, $batch) => $query->where('batch', $batch))
            ->when($status, fn ($query, $status) => $query->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.alumni.index', [
            'alumni' => $alumni,
            'filters' => [
                'search' => $search,
                'batch' => $batch,
                'status' => $status,
            ],
            'batches' => Alumni::query()->whereNotNull('batch')->distinct()->orderBy('batch')->pluck('batch'),
        ]);
    }

    public function create()
    {
        return view('admin.alumni.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $data['is_featured'] = $request->boolean('is_featured');
        $data['slug'] = Alumni::uniqueSlug($data['full_name']);

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('alumni', 'public');
        }

        Alumni::create($data);

        return redirect()
            ->route('admin.alumni.index')
            ->with('status', 'Alumni record created.');
    }

    public function show(Alumni $alumni)
    {
        return view('admin.alumni.show', [
            'alumni' => $alumni,
        ]);
    }

    public function edit(Alumni $alumni)
    {
        return view('admin.alumni.edit', [
            'alumni' => $alumni,
        ]);
    }

    public function update(Request $request, Alumni $alumni)
    {
        $data = $request->validate($this->rules($alumni));

        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('profile_photo')) {
            if ($alumni->profile_photo) {
                Storage::disk('public')->delete($alumni->profile_photo);
            }

            $data['profile_photo'] = $request->file('profile_photo')->store('alumni', 'public');
        }

        $alumni->update($data);

        return redirect()
            ->route('admin.alumni.index')
            ->with('status', 'Alumni record updated.');
    }

    public function destroy(Alumni $alumni)
    {
        if ($alumni->profile_photo) {
            Storage::disk('public')->delete($alumni->profile_photo);
        }

        $alumni->delete();

        return redirect()
            ->route('admin.alumni.index')
            ->with('status', 'Alumni record deleted.');
    }

    /**
     * Validation rules shared by store and update.
     *
     * @return array<string, mixed>
     */
    protected function rules(?Alumni $alumni = null): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'student_id' => ['nullable', 'string', 'max:50'],
            'batch' => ['nullable', 'string', 'max:20'],
            'session' => ['nullable', 'string', 'max:20'],
            'graduation_year' => ['nullable', 'integer', 'min:1950', 'max:2100'],
            'degree' => ['nullable', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'organization' => ['nullable', 'string', 'max:255'],
            'profession' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'is_featured' => ['sometimes', 'boolean'],
            'status' => ['required', Rule::in([Alumni::STATUS_ACTIVE, Alumni::STATUS_INACTIVE])],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'profile_photo' => [
                'nullable',
                'sometimes',
                File::image()
                                        ->max('8mb')
                    ->dimensions(Rule::dimensions()->maxWidth(5000)->maxHeight(5000)),
            ],
        ];
    }
}
