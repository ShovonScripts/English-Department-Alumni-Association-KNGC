<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryPhoto;
use App\Services\SharedFileGuard;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GalleryPhotoController extends Controller
{
    public function store(Request $request, GalleryAlbum $galleryAlbum)
    {
        $request->validate([
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['required', 'image', 'mimes:jpeg,png,webp', 'max:8192', Rule::dimensions()->maxWidth(5000)->maxHeight(5000)],
            'titles' => ['nullable', 'array'],
            'titles.*' => ['nullable', 'string', 'max:255'],
            'captions' => ['nullable', 'array'],
            'captions.*' => ['nullable', 'string', 'max:1000'],
            'alt_texts' => ['nullable', 'array'],
            'alt_texts.*' => ['nullable', 'string', 'max:255'],
        ]);

        $files = $request->file('images');
        $titles = $request->input('titles', []);
        $captions = $request->input('captions', []);
        $altTexts = $request->input('alt_texts', []);
        $maxOrder = $galleryAlbum->photos()->max('sort_order') ?? 0;

        foreach ($files as $index => $file) {
            $path = $file->store('gallery', 'public');

            GalleryPhoto::create([
                'gallery_album_id' => $galleryAlbum->id,
                'image' => $path,
                'title' => $titles[$index] ?? null,
                'caption' => $captions[$index] ?? null,
                'alt_text' => $altTexts[$index] ?? null,
                'sort_order' => $maxOrder + $index + 1,
                'status' => GalleryPhoto::STATUS_PUBLISHED,
            ]);
        }

        return redirect()->route('admin.gallery.show', $galleryAlbum)
            ->with('status', count($files).' photo(s) uploaded.');
    }

    public function update(Request $request, GalleryAlbum $galleryAlbum, GalleryPhoto $galleryPhoto)
    {
        abort_unless($galleryPhoto->gallery_album_id === $galleryAlbum->id, 404);

        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'caption' => ['nullable', 'string', 'max:1000'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', Rule::in([GalleryPhoto::STATUS_PUBLISHED, GalleryPhoto::STATUS_HIDDEN])],
        ]);

        $galleryPhoto->update($validated);

        return redirect()->route('admin.gallery.show', $galleryAlbum)
            ->with('status', 'Photo updated.');
    }

    public function destroy(GalleryAlbum $galleryAlbum, GalleryPhoto $galleryPhoto)
    {
        abort_unless($galleryPhoto->gallery_album_id === $galleryAlbum->id, 404);

        if ($galleryPhoto->image) {
            SharedFileGuard::deleteIfUnreferenced($galleryPhoto->image, $galleryPhoto->id, 'gallery_photos');
        }

        $galleryPhoto->delete();

        return redirect()->route('admin.gallery.show', $galleryAlbum)
            ->with('status', 'Photo deleted.');
    }
}
