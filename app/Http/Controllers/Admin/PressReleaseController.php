<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PressRelease;
use App\Services\SharedFileGuard;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PressReleaseController extends Controller
{
    public function index(Request $request)
    {
        $query = PressRelease::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%" . $this->escapeLike($search) . "%")
                    ->orWhere('excerpt', 'like', "%" . $this->escapeLike($search) . "%")
                    ->orWhere('content', 'like', "%" . $this->escapeLike($search) . "%")
                    ->orWhere('document_original_name', 'like', "%" . $this->escapeLike($search) . "%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($request->has('is_featured')) {
            $query->where('is_featured', true);
        }

        $pressReleases = $query->orderByDesc('published_at')->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $filters = $request->only(['search', 'status', 'is_featured']);

        return view('admin.press-releases.index', compact('pressReleases', 'filters'));
    }

    public function create()
    {
        return view('admin.press-releases.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $validated['slug'] = PressRelease::uniqueSlug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');

        if (empty($validated['published_at']) && $validated['status'] === PressRelease::STATUS_PUBLISHED) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('press-releases/covers', 'public');
        }

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $filename = uniqid('pr_').'.'.$file->getClientOriginalExtension();
            $validated['document_path'] = $file->storeAs('press-releases/documents', $filename, 'public');
            $validated['document_original_name'] = $file->getClientOriginalName();
            $validated['document_size'] = $file->getSize();
            $validated['document_mime_type'] = $file->getMimeType();
        }

        PressRelease::create($validated);

        return redirect()->route('admin.press-releases.index')
            ->with('status', 'Press release created.');
    }

    public function show(PressRelease $pressRelease)
    {
        return view('admin.press-releases.show', ['pressRelease' => $pressRelease]);
    }

    public function edit(PressRelease $pressRelease)
    {
        return view('admin.press-releases.edit', ['pressRelease' => $pressRelease]);
    }

    public function update(Request $request, PressRelease $pressRelease)
    {
        $validated = $request->validate($this->rules($pressRelease));

        $validated['slug'] = PressRelease::uniqueSlug($validated['title'], $pressRelease->id);
        $validated['is_featured'] = $request->boolean('is_featured');

        if (empty($validated['published_at']) && $validated['status'] === PressRelease::STATUS_PUBLISHED) {
            $validated['published_at'] = $pressRelease->published_at ?? now();
        }

        if ($request->hasFile('cover_image')) {
            if ($pressRelease->cover_image) {
                SharedFileGuard::deleteIfUnreferenced($pressRelease->cover_image, $pressRelease->id, 'press_releases');
            }
            $validated['cover_image'] = $request->file('cover_image')->store('press-releases/covers', 'public');
        } elseif ($request->boolean('clear_image')) {
            if ($pressRelease->cover_image) {
                SharedFileGuard::deleteIfUnreferenced($pressRelease->cover_image, $pressRelease->id, 'press_releases');
            }
            $validated['cover_image'] = null;
        }

        if ($request->hasFile('document')) {
            if ($pressRelease->document_path) {
                SharedFileGuard::deleteIfUnreferenced($pressRelease->document_path, $pressRelease->id, 'press_releases');
            }
            $file = $request->file('document');
            $filename = uniqid('pr_').'.'.$file->getClientOriginalExtension();
            $validated['document_path'] = $file->storeAs('press-releases/documents', $filename, 'public');
            $validated['document_original_name'] = $file->getClientOriginalName();
            $validated['document_size'] = $file->getSize();
            $validated['document_mime_type'] = $file->getMimeType();
        } elseif ($request->boolean('clear_document')) {
            if ($pressRelease->document_path) {
                SharedFileGuard::deleteIfUnreferenced($pressRelease->document_path, $pressRelease->id, 'press_releases');
            }
            $validated['document_path'] = null;
            $validated['document_original_name'] = null;
            $validated['document_size'] = null;
            $validated['document_mime_type'] = null;
        }

        $pressRelease->update($validated);

        return redirect()->route('admin.press-releases.show', $pressRelease)
            ->with('status', 'Press release updated.');
    }

    public function destroy(PressRelease $pressRelease)
    {
        if ($pressRelease->cover_image) {
            SharedFileGuard::deleteIfUnreferenced($pressRelease->cover_image, $pressRelease->id, 'press_releases');
        }
        if ($pressRelease->document_path) {
            SharedFileGuard::deleteIfUnreferenced($pressRelease->document_path, $pressRelease->id, 'press_releases');
        }
        $pressRelease->delete();

        return redirect()->route('admin.press-releases.index')
            ->with('status', 'Press release deleted.');
    }

    protected function rules(?PressRelease $pressRelease = null): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'content' => ['nullable', 'string'],
            'status' => ['required', Rule::in([PressRelease::STATUS_DRAFT, PressRelease::STATUS_PUBLISHED])],
            'published_at' => ['nullable', 'date'],
            'is_featured' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'external_url' => ['nullable', 'url', 'max:255'],
            'cover_image' => ['nullable', 'sometimes', 'image', 'mimes:jpeg,png,webp', 'max:8192', Rule::dimensions()->maxWidth(5000)->maxHeight(5000)],
            'document' => ['nullable', 'file', 'mimes:pdf', 'mimetypes:application/pdf', 'max:10240'],
        ];
    }
}
