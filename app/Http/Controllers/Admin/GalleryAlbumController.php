<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\GalleryAlbum;
use App\Services\SharedFileGuard;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GalleryAlbumController extends Controller
{
    public function index(Request $request)
    {
        $query = GalleryAlbum::withCount('photos');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%" . $this->escapeLike($search) . "%")
                    ->orWhere('description', 'like', "%" . $this->escapeLike($search) . "%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($eventId = $request->input('event_id')) {
            $query->where('event_id', $eventId);
        }

        $albums = $query->ordered()->paginate(15)->withQueryString();
        $events = Event::where('status', Event::STATUS_PUBLISHED)->orderBy('title')->get();
        $filters = $request->only(['search', 'status', 'event_id']);

        return view('admin.gallery.index', compact('albums', 'events', 'filters'));
    }

    public function create()
    {
        $events = Event::where('status', Event::STATUS_PUBLISHED)->orderBy('title')->get();

        return view('admin.gallery.create', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $validated['slug'] = GalleryAlbum::uniqueSlug($validated['title']);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('gallery', 'public');
        }

        GalleryAlbum::create($validated);

        return redirect()->route('admin.gallery.index')
            ->with('status', 'Album created.');
    }

    public function show(GalleryAlbum $galleryAlbum)
    {
        $galleryAlbum->load(['photos' => fn ($q) => $q->ordered(), 'event']);

        return view('admin.gallery.show', ['album' => $galleryAlbum]);
    }

    public function edit(GalleryAlbum $galleryAlbum)
    {
        $events = Event::where('status', Event::STATUS_PUBLISHED)->orderBy('title')->get();

        return view('admin.gallery.edit', ['album' => $galleryAlbum, 'events' => $events]);
    }

    public function update(Request $request, GalleryAlbum $galleryAlbum)
    {
        $validated = $request->validate($this->rules($galleryAlbum));
        $validated['slug'] = GalleryAlbum::uniqueSlug($validated['title'], $galleryAlbum->id);

        if ($request->hasFile('cover_image')) {
            if ($galleryAlbum->cover_image) {
                SharedFileGuard::deleteIfUnreferenced($galleryAlbum->cover_image, $galleryAlbum->id, 'gallery_albums');
            }
            $validated['cover_image'] = $request->file('cover_image')->store('gallery', 'public');
        } elseif ($request->boolean('clear_image')) {
            if ($galleryAlbum->cover_image) {
                SharedFileGuard::deleteIfUnreferenced($galleryAlbum->cover_image, $galleryAlbum->id, 'gallery_albums');
            }
            $validated['cover_image'] = null;
        }

        $galleryAlbum->update($validated);

        return redirect()->route('admin.gallery.show', $galleryAlbum)
            ->with('status', 'Album updated.');
    }

    public function destroy(GalleryAlbum $galleryAlbum)
    {
        foreach ($galleryAlbum->photos as $photo) {
            if ($photo->image) {
                SharedFileGuard::deleteIfUnreferenced($photo->image, $photo->id, 'gallery_photos');
            }
        }

        if ($galleryAlbum->cover_image) {
            SharedFileGuard::deleteIfUnreferenced($galleryAlbum->cover_image, $galleryAlbum->id, 'gallery_albums');
        }

        $galleryAlbum->delete();

        return redirect()->route('admin.gallery.index')
            ->with('status', 'Album deleted.');
    }

    protected function rules(?GalleryAlbum $album = null): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'event_id' => ['nullable', 'exists:events,id'],
            'status' => ['required', Rule::in([GalleryAlbum::STATUS_PUBLISHED, GalleryAlbum::STATUS_HIDDEN])],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:8192', Rule::dimensions()->maxWidth(5000)->maxHeight(5000)],
        ];
    }
}
