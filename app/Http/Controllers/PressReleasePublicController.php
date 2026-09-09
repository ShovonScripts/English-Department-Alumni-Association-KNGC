<?php

namespace App\Http\Controllers;

use App\Models\PressRelease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PressReleasePublicController extends Controller
{
    public function index(Request $request)
    {
        $query = PressRelease::published();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%" . $this->escapeLike($search) . "%")
                    ->orWhere('excerpt', 'like', "%" . $this->escapeLike($search) . "%");
            });
        }

        $featuredRelease = (clone $query)->featured()->latest()->first();

        $pressReleases = $query->orderByDesc('published_at')
            ->paginate(12)
            ->withQueryString();

        $filters = $request->only(['search']);

        return view('pages.press-releases', compact('pressReleases', 'featuredRelease', 'filters'));
    }

    public function show(PressRelease $pressRelease)
    {
        abort_unless(
            $pressRelease->status === PressRelease::STATUS_PUBLISHED
            && $pressRelease->published_at
            && $pressRelease->published_at->lte(now()),
            404
        );

        $relatedReleases = PressRelease::published()
            ->where('id', '!=', $pressRelease->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('pages.press-release-show', ['pressRelease' => $pressRelease, 'relatedReleases' => $relatedReleases]);
    }

    public function download(PressRelease $pressRelease)
    {
        abort_unless(
            $pressRelease->status === PressRelease::STATUS_PUBLISHED
            && $pressRelease->published_at
            && $pressRelease->published_at->lte(now()),
            404
        );

        abort_unless($pressRelease->document_path, 404);

        return Storage::disk('public')->download(
            $pressRelease->document_path,
            $pressRelease->document_original_name ?? basename($pressRelease->document_path)
        );
    }
}
