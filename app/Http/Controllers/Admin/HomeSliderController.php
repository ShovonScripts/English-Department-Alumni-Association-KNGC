<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSliderImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class HomeSliderController extends Controller
{
    /**
     * Display the slider management page.
     */
    public function index()
    {
        $slides = HomeSliderImage::orderBy('sort_order')->get();

        return view('admin.home-slider.index', compact('slides'));
    }

    /**
     * Store a new slider image.
     */
    public function store(Request $request): RedirectResponse
    {
        $count = HomeSliderImage::count();
        if ($count >= 5) {
            throw ValidationException::withMessages([
                'image' => 'You can upload a maximum of 5 slider images.',
            ]);
        }

        $validated = $request->validate([
                        'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:8192',
            'alt_text' => 'nullable|string|max:255',
        ]);

        $path = $request->file('image')->store('slider', 'public');

        HomeSliderImage::create([
            'image_path' => $path,
            'alt_text' => $validated['alt_text'] ?? null,
            'sort_order' => $count,
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.home-slider.index')
            ->with('status', 'Slider image uploaded successfully.');
    }

    /**
     * Update slider image details.
     */
    public function update(Request $request, HomeSliderImage $slide): RedirectResponse
    {
        $validated = $request->validate([
            'alt_text' => 'nullable|string|max:255',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable',
        ]);

        $slide->update([
            'alt_text' => $validated['alt_text'] ?? null,
            'sort_order' => $validated['sort_order'],
            'is_active' => isset($validated['is_active']),
        ]);

        return redirect()
            ->route('admin.home-slider.index')
            ->with('status', 'Slide updated successfully.');
    }

    /**
     * Delete a slider image.
     */
    public function destroy(HomeSliderImage $slide): RedirectResponse
    {
        if ($slide->image_path && Storage::disk('public')->exists($slide->image_path)) {
            Storage::disk('public')->delete($slide->image_path);
        }

        $slide->delete();

        return redirect()
            ->route('admin.home-slider.index')
            ->with('status', 'Slider image deleted successfully.');
    }

    /**
     * Reorder slider images.
     */
    public function reorder(Request $request): RedirectResponse
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:home_slider_images,id',
        ]);

        foreach ($request->order as $index => $id) {
            HomeSliderImage::where('id', $id)->update(['sort_order' => $index]);
        }

        return redirect()
            ->route('admin.home-slider.index')
            ->with('status', 'Slide order updated successfully.');
    }
}
