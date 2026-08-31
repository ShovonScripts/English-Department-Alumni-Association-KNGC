<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventCategoryController extends Controller
{
    public function index()
    {
        $categories = EventCategory::orderBy('name')->paginate(15);

        return view('admin.events.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.events.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $validated['slug'] = EventCategory::uniqueSlug($validated['name']);

        EventCategory::create($validated);

        return redirect()->route('admin.events.categories.index')
            ->with('status', 'Category created.');
    }

    public function edit(EventCategory $category)
    {
        return view('admin.events.categories.edit', ['category' => $category]);
    }

    public function update(Request $request, EventCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $validated['slug'] = EventCategory::uniqueSlug($validated['name'], $category->id);

        $category->update($validated);

        return redirect()->route('admin.events.categories.index')
            ->with('status', 'Category updated.');
    }

    public function destroy(EventCategory $category)
    {
        if ($category->events()->exists()) {
            return redirect()->route('admin.events.categories.index')
                ->with('error', 'This category cannot be deleted because events are assigned to it.');
        }

        $category->delete();

        return redirect()->route('admin.events.categories.index')
            ->with('status', 'Category deleted.');
    }
}
