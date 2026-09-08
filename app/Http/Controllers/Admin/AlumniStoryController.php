<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\AlumniStory;
use App\Services\SharedFileGuard;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AlumniStoryController extends Controller
{
    public function index(Request $request)
    {
        $query = AlumniStory::with('alumni');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author_name', 'like', "%{$search}%")
                    ->orWhereHas('alumni', function ($q2) use ($search) {
                        $q2->where('full_name', 'like', "%{$search}%");
                    });
            });
        }

        if ($alumniId = $request->input('alumni_id')) {
            $query->where('alumni_id', $alumniId);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($request->has('is_featured')) {
            $query->where('is_featured', true);
        }

        $stories = $query->orderByDesc('sort_order')->orderByDesc('published_at')->paginate(15)->withQueryString();
        $alumniList = Alumni::where('status', Alumni::STATUS_ACTIVE)->orderBy('full_name')->get();
        $filters = $request->only(['search', 'alumni_id', 'status', 'is_featured']);

        return view('admin.stories.index', compact('stories', 'alumniList', 'filters'));
    }

    public function create()
    {
        $alumniList = Alumni::where('status', Alumni::STATUS_ACTIVE)->orderBy('full_name')->get();

        return view('admin.stories.create', compact('alumniList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $validated['slug'] = AlumniStory::uniqueSlug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');

        if (empty($validated['published_at']) && $validated['status'] === AlumniStory::STATUS_PUBLISHED) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('alumni-stories', 'public');
        }

        AlumniStory::create($validated);

        return redirect()->route('admin.stories.index')
            ->with('status', 'Story created.');
    }

    public function show(AlumniStory $alumniStory)
    {
        $alumniStory->load('alumni');

        return view('admin.stories.show', ['alumniStory' => $alumniStory]);
    }

    public function edit(AlumniStory $alumniStory)
    {
        $alumniList = Alumni::where('status', Alumni::STATUS_ACTIVE)->orderBy('full_name')->get();

        return view('admin.stories.edit', ['alumniStory' => $alumniStory, 'alumniList' => $alumniList]);
    }

    public function update(Request $request, AlumniStory $alumniStory)
    {
        $validated = $request->validate($this->rules($alumniStory));

        $validated['slug'] = AlumniStory::uniqueSlug($validated['title'], $alumniStory->id);
        $validated['is_featured'] = $request->boolean('is_featured');

        if (empty($validated['published_at']) && $validated['status'] === AlumniStory::STATUS_PUBLISHED) {
            $validated['published_at'] = $alumniStory->published_at ?? now();
        }

        if ($request->hasFile('cover_image')) {
            if ($alumniStory->cover_image) {
                SharedFileGuard::deleteIfUnreferenced($alumniStory->cover_image, $alumniStory->id, 'alumni_stories');
            }
            $validated['cover_image'] = $request->file('cover_image')->store('alumni-stories', 'public');
        } elseif ($request->boolean('clear_image')) {
            if ($alumniStory->cover_image) {
                SharedFileGuard::deleteIfUnreferenced($alumniStory->cover_image, $alumniStory->id, 'alumni_stories');
            }
            $validated['cover_image'] = null;
        }

        $alumniStory->update($validated);

        return redirect()->route('admin.stories.show', $alumniStory)
            ->with('status', 'Story updated.');
    }

    public function destroy(AlumniStory $alumniStory)
    {
        if ($alumniStory->cover_image) {
            SharedFileGuard::deleteIfUnreferenced($alumniStory->cover_image, $alumniStory->id, 'alumni_stories');
        }

        $alumniStory->delete();

        return redirect()->route('admin.stories.index')
            ->with('status', 'Story deleted.');
    }

    protected function rules(?AlumniStory $story = null): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'alumni_id' => ['required', 'exists:alumni,id'],
            'excerpt' => ['required', 'string', 'max:1000'],
            'content' => ['required', 'string'],
            'status' => ['required', Rule::in([AlumniStory::STATUS_DRAFT, AlumniStory::STATUS_PUBLISHED])],
            'published_at' => ['nullable', 'date'],
            'author_name' => ['nullable', 'string', 'max:255'],
            'is_featured' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:8192', Rule::dimensions()->maxWidth(5000)->maxHeight(5000)],
        ];
    }
}
