<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsCategoryController extends Controller
{
    public function index()
    {
        $categories = NewsCategory::orderBy('sort_order')->orderBy('name')->paginate(15);

        return view('admin.news-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.news-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = NewsCategory::uniqueSlug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        NewsCategory::create($validated);

        return redirect()->route('admin.news-categories.index')
            ->with('status', 'Category created.');
    }

    public function edit(NewsCategory $newsCategory)
    {
        return view('admin.news-categories.edit', ['category' => $newsCategory]);
    }

    public function update(Request $request, NewsCategory $newsCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = NewsCategory::uniqueSlug($validated['name'], $newsCategory->id);
        $validated['is_active'] = $request->boolean('is_active');

        $newsCategory->update($validated);

        return redirect()->route('admin.news-categories.index')
            ->with('status', 'Category updated.');
    }

    public function destroy(NewsCategory $newsCategory)
    {
        $newsCategory->delete();

        return redirect()->route('admin.news-categories.index')
            ->with('status', 'Category deleted.');
    }
}
