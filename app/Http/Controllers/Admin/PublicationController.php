<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\PublicationCategory;
use App\Services\SharedFileGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PublicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Publication::with('category');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%" . $this->escapeLike($search) . "%")
                    ->orWhere('subtitle', 'like', "%" . $this->escapeLike($search) . "%")
                    ->orWhere('author', 'like', "%" . $this->escapeLike($search) . "%")
                    ->orWhere('publisher', 'like', "%" . $this->escapeLike($search) . "%");
            });
        }

        if ($categoryId = $request->input('publication_category_id')) {
            $query->where('publication_category_id', $categoryId);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($request->has('is_featured')) {
            $query->where('is_featured', true);
        }

        $publications = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $categories = PublicationCategory::orderBy('name')->get();
        $filters = $request->only(['search', 'publication_category_id', 'status', 'is_featured']);

        return view('admin.publications.index', compact('publications', 'categories', 'filters'));
    }

    public function create()
    {
        $categories = PublicationCategory::where('is_active', true)->orderBy('name')->get();

        return view('admin.publications.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $validated['slug'] = Publication::uniqueSlug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('publications/covers', 'public');
        }

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $filename = uniqid('doc_').'.'.$file->getClientOriginalExtension();

            $validated['document_path'] = $file->storeAs('publications/documents', $filename, 'public');
            $validated['document_original_name'] = $file->getClientOriginalName();
            $validated['document_size'] = $file->getSize();
            $validated['document_mime_type'] = $file->getMimeType();
        }

        Publication::create($validated);

        return redirect()->route('admin.publications.index')
            ->with('status', 'Publication created.');
    }

    public function show(Publication $publication)
    {
        $publication->load('category');

        return view('admin.publications.show', ['publication' => $publication]);
    }

    public function edit(Publication $publication)
    {
        $categories = PublicationCategory::where('is_active', true)->orderBy('name')->get();

        return view('admin.publications.edit', ['publication' => $publication, 'categories' => $categories]);
    }

    public function update(Request $request, Publication $publication)
    {
        $validated = $request->validate($this->rules($publication));

        $validated['slug'] = Publication::uniqueSlug($validated['title'], $publication->id);
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('cover_image')) {
            if ($publication->cover_image) {
                SharedFileGuard::deleteIfUnreferenced($publication->cover_image, $publication->id, 'publications');
            }
            $validated['cover_image'] = $request->file('cover_image')->store('publications/covers', 'public');
        } elseif ($request->boolean('clear_image')) {
            if ($publication->cover_image) {
                SharedFileGuard::deleteIfUnreferenced($publication->cover_image, $publication->id, 'publications');
            }
            $validated['cover_image'] = null;
        }

        if ($request->hasFile('document')) {
            if ($publication->document_path) {
                SharedFileGuard::deleteIfUnreferenced($publication->document_path, $publication->id, 'publications');
            }

            $file = $request->file('document');
            $filename = uniqid('doc_').'.'.$file->getClientOriginalExtension();

            $validated['document_path'] = $file->storeAs('publications/documents', $filename, 'public');
            $validated['document_original_name'] = $file->getClientOriginalName();
            $validated['document_size'] = $file->getSize();
            $validated['document_mime_type'] = $file->getMimeType();
        } elseif ($request->boolean('clear_document')) {
            if ($publication->document_path) {
                SharedFileGuard::deleteIfUnreferenced($publication->document_path, $publication->id, 'publications');
            }
            $validated['document_path'] = null;
            $validated['document_original_name'] = null;
            $validated['document_size'] = null;
            $validated['document_mime_type'] = null;
        }

        $publication->update($validated);

        return redirect()->route('admin.publications.show', $publication)
            ->with('status', 'Publication updated.');
    }

    public function destroy(Publication $publication)
    {
        if ($publication->cover_image) {
            SharedFileGuard::deleteIfUnreferenced($publication->cover_image, $publication->id, 'publications');
        }

        if ($publication->document_path) {
            SharedFileGuard::deleteIfUnreferenced($publication->document_path, $publication->id, 'publications');
        }

        $publication->delete();

        return redirect()->route('admin.publications.index')
            ->with('status', 'Publication deleted.');
    }

    public function documentView(Publication $publication)
    {
        abort_unless($publication->document_path, 404);

        return response()->file(
            Storage::disk('public')->path($publication->document_path),
            ['Content-Type' => $publication->document_mime_type ?? 'application/pdf']
        );
    }

    public function documentDownload(Publication $publication)
    {
        abort_unless($publication->document_path, 404);

        return Storage::disk('public')->download(
            $publication->document_path,
            $publication->document_original_name ?? basename($publication->document_path)
        );
    }

    protected function rules(?Publication $publication = null): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'publication_category_id' => ['nullable', 'exists:publication_categories,id'],
            'author' => ['nullable', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'publication_date' => ['nullable', 'date'],
            'status' => ['required', Rule::in([Publication::STATUS_DRAFT, Publication::STATUS_PUBLISHED])],
            'is_featured' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:8192', Rule::dimensions()->maxWidth(5000)->maxHeight(5000)],
            'document' => ['nullable', 'file', 'mimes:pdf', 'mimetypes:application/pdf', 'max:10240'],
        ];
    }
}
