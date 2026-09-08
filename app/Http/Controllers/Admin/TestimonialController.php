<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Services\SharedFileGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display the testimonials management page.
     */
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->get();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the create form.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a new testimonial.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'quote' => 'required|string|max:1000',
            'author_name' => 'required|string|max:255',
            'author_title' => 'nullable|string|max:255',
            'author_batch' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:8192',
            'is_active' => 'nullable',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = [
            'quote' => $validated['quote'],
            'author_name' => $validated['author_name'],
            'author_title' => $validated['author_title'] ?? null,
            'author_batch' => $validated['author_batch'] ?? null,
            'is_active' => isset($validated['is_active']),
            'sort_order' => $validated['sort_order'] ?? 0,
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('testimonials', 'public');
        }

        Testimonial::create($data);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('status', 'Testimonial created successfully.');
    }

    /**
     * Show the edit form.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update a testimonial.
     */
    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $request->validate([
            'quote' => 'required|string|max:1000',
            'author_name' => 'required|string|max:255',
            'author_title' => 'nullable|string|max:255',
            'author_batch' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:8192',
            'is_active' => 'nullable',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = [
            'quote' => $validated['quote'],
            'author_name' => $validated['author_name'],
            'author_title' => $validated['author_title'] ?? null,
            'author_batch' => $validated['author_batch'] ?? null,
            'is_active' => isset($validated['is_active']),
            'sort_order' => $validated['sort_order'] ?? 0,
        ];

        if ($request->hasFile('image')) {
            if ($testimonial->image_path) {
                SharedFileGuard::deleteIfUnreferenced($testimonial->image_path, $testimonial->id, 'testimonials');
            }
            $data['image_path'] = $request->file('image')->store('testimonials', 'public');
        }

        $testimonial->update($data);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('status', 'Testimonial updated successfully.');
    }

    /**
     * Delete a testimonial.
     */
    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        if ($testimonial->image_path) {
            SharedFileGuard::deleteIfUnreferenced($testimonial->image_path, $testimonial->id, 'testimonials');
        }

        $testimonial->delete();

        return redirect()
            ->route('admin.testimonials.index')
            ->with('status', 'Testimonial deleted successfully.');
    }
}
