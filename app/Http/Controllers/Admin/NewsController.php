<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('category');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('author_name', 'like', "%{$search}%");
            });
        }

        if ($categoryId = $request->input('category_id')) {
            $query->where('news_category_id', $categoryId);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($request->has('is_featured')) {
            $query->where('is_featured', true);
        }

        $news = $query->orderByDesc('published_at')->orderByDesc('created_at')->paginate(15)->withQueryString();
        $categories = NewsCategory::orderBy('name')->get();
        $filters = $request->only(['search', 'category_id', 'status', 'is_featured']);

        return view('admin.news.index', compact('news', 'categories', 'filters'));
    }

    public function create()
    {
        $categories = NewsCategory::where('is_active', true)->orderBy('name')->get();

        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $validated['slug'] = News::uniqueSlug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');

        if (empty($validated['published_at']) && $validated['status'] === News::STATUS_PUBLISHED) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        News::create($validated);

        return redirect()->route('admin.news.index')
            ->with('status', 'News article created.');
    }

    public function show(News $news)
    {
        $news->load('category');

        return view('admin.news.show', ['news' => $news]);
    }

    public function edit(News $news)
    {
        $categories = NewsCategory::where('is_active', true)->orderBy('name')->get();

        return view('admin.news.edit', ['news' => $news, 'categories' => $categories]);
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate($this->rules($news));

        $validated['slug'] = News::uniqueSlug($validated['title'], $news->id);
        $validated['is_featured'] = $request->boolean('is_featured');

        if (empty($validated['published_at']) && $validated['status'] === News::STATUS_PUBLISHED) {
            $validated['published_at'] = $news->published_at ?? now();
        }

        if ($request->hasFile('featured_image')) {
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('news', 'public');
        } elseif ($request->boolean('clear_image')) {
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $validated['featured_image'] = null;
        }

        $news->update($validated);

        return redirect()->route('admin.news.show', $news)
            ->with('status', 'News article updated.');
    }

    public function destroy(News $news)
    {
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('status', 'News article deleted.');
    }

    protected function rules(?News $news = null): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'news_category_id' => ['nullable', 'exists:news_categories,id'],
            'excerpt' => ['required', 'string', 'max:1000'],
            'content' => ['required', 'string'],
            'status' => ['required', Rule::in([News::STATUS_DRAFT, News::STATUS_PUBLISHED])],
            'published_at' => ['nullable', 'date'],
            'author_name' => ['nullable', 'string', 'max:255'],
            'is_featured' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'featured_image' => ['nullable', 'sometimes', 'image', 'mimes:jpeg,png,webp', 'max:2048', Rule::dimensions()->maxWidth(4000)->maxHeight(4000)],
        ];
    }
}
