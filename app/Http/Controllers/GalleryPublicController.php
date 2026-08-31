<?php

namespace App\Http\Controllers;

use App\Models\GalleryAlbum;
use Illuminate\Http\Request;

class GalleryPublicController extends Controller
{
    public function index(Request $request)
    {
        $query = GalleryAlbum::published()->withCount('photos')->with('event');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $albums = $query->ordered()->paginate(12)->withQueryString();
        $filters = $request->only(['search']);

        return view('pages.gallery', compact('albums', 'filters'));
    }

    public function show(GalleryAlbum $album)
    {
        abort_unless(
            $album->status === GalleryAlbum::STATUS_PUBLISHED,
            404
        );

        $album->load(['photos' => fn ($q) => $q->published()->ordered(), 'event'])
            ->loadCount(['photos' => fn ($q) => $q->published()]);

        return view('pages.album-show', ['album' => $album]);
    }
}
