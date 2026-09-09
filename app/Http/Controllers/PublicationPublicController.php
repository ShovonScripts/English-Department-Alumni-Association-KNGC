<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\PublicationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PublicationPublicController extends Controller
{
    public function index(Request $request)
    {
        $query = Publication::published()->with('category');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%" . $this->escapeLike($search) . "%")
                    ->orWhere('author', 'like', "%" . $this->escapeLike($search) . "%")
                    ->orWhere('publisher', 'like', "%" . $this->escapeLike($search) . "%");
            });
        }

        if ($categorySlug = $request->input('category')) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        if ($year = $request->input('year')) {
            $query->whereYear('publication_date', $year);
        }

        $featuredPublications = (clone $query)->featured()->latest()->get();
        $publications = $query->orderByDesc('publication_date')->paginate(12)->withQueryString();
        $categories = PublicationCategory::where('is_active', true)->orderBy('name')->get();
        $years = Publication::published()
            ->whereNotNull('publication_date')
            ->get()
            ->map(fn ($p) => $p->publication_date->format('Y'))
            ->unique()
            ->values();
        $filters = $request->only(['search', 'category', 'year']);

        return view('pages.publications', compact('publications', 'featuredPublications', 'categories', 'years', 'filters'));
    }

    public function show(Publication $publication)
    {
        abort_unless(
            $publication->status === Publication::STATUS_PUBLISHED,
            404
        );

        $publication->load('category');

        $relatedPublications = Publication::published()
            ->with('category')
            ->where('id', '!=', $publication->id)
            ->when($publication->publication_category_id, function ($q) use ($publication) {
                $q->where('publication_category_id', $publication->publication_category_id);
            })
            ->latest('publication_date')
            ->limit(4)
            ->get();

        return view('pages.publication-show', compact('publication', 'relatedPublications'));
    }

    public function download(Publication $publication): StreamedResponse
    {
        abort_unless(
            $publication->status === Publication::STATUS_PUBLISHED,
            404
        );

        abort_unless($publication->document_path, 404);

        return Storage::disk('public')->download(
            $publication->document_path,
            $publication->document_original_name ?? basename($publication->document_path)
        );
    }
}
