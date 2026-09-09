<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublicationCategory;
use Illuminate\Http\Request;

class PublicationCategoryController extends Controller
{
    public function index()
    {
        $categories = PublicationCategory::withCount('publications')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.publication-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.publication-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = PublicationCategory::uniqueSlug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        PublicationCategory::create($validated);

        return redirect()->route('admin.publication-categories.index')
            ->with('status', 'Category created.');
    }

    public function edit(PublicationCategory $publicationCategory)
    {
        return view('admin.publication-categories.edit', compact('publicationCategory'));
    }

    public function update(Request $request, PublicationCategory $publicationCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = PublicationCategory::uniqueSlug($validated['name'], $publicationCategory->id);
        $validated['is_active'] = $request->boolean('is_active');

        $publicationCategory->update($validated);

        return redirect()->route('admin.publication-categories.index')
            ->with('status', 'Category updated.');
    }

    public function destroy(PublicationCategory $publicationCategory)
    {
        if ($publicationCategory->publications()->exists()) {
            return back()->withErrors(['error' => 'Cannot delete category that has publications.']);
        }

        $publicationCategory->delete();

        return redirect()->route('admin.publication-categories.index')
            ->with('status', 'Category deleted.');
    }
}
