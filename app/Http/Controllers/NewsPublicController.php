<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsPublicController extends Controller
{
    public function index(Request $request)
    {
        $query = News::published()->with('category');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        if ($categorySlug = $request->input('category')) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $featuredNews = (clone $query)->featured()->latest()->first();
        $allNews = $query->orderByDesc('published_at')->paginate(12)->withQueryString();
        $categories = NewsCategory::where('is_active', true)->orderBy('name')->get();
        $filters = $request->only(['search', 'category']);

        return view('pages.news', compact('allNews', 'featuredNews', 'categories', 'filters'));
    }

    public function show(News $news)
    {
        abort_unless(
            $news->status === News::STATUS_PUBLISHED && $news->published_at && $news->published_at->lte(now()),
            404
        );

        $news->load('category');

        $relatedNews = News::published()
            ->with('category')
            ->where('id', '!=', $news->id)
            ->where('news_category_id', $news->news_category_id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        if ($relatedNews->count() < 3) {
            $existingIds = $relatedNews->pluck('id')->push($news->id);
            $additional = News::published()
                ->with('category')
                ->whereNotIn('id', $existingIds)
                ->latest('published_at')
                ->limit(3 - $relatedNews->count())
                ->get();
            $relatedNews = $relatedNews->concat($additional);
        }

        return view('pages.news-show', ['news' => $news, 'relatedNews' => $relatedNews]);
    }
}
