<?php

namespace App\Http\Controllers;

use App\Models\AlumniStory;
use Illuminate\Http\Request;

class AlumniStoryPublicController extends Controller
{
    public function index(Request $request)
    {
        $query = AlumniStory::published()->with('alumni');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhereHas('alumni', function ($q2) use ($search) {
                        $q2->where('full_name', 'like', "%{$search}%");
                    });
            });
        }

        if ($alumniId = $request->input('alumni')) {
            $query->whereHas('alumni', function ($q) use ($alumniId) {
                $q->where('slug', $alumniId);
            });
        }

        $featuredStories = (clone $query)->featured()->latest()->limit(3)->get();
        $allStories = $query->latest()->paginate(12)->withQueryString();
        $filters = $request->only(['search', 'alumni']);

        return view('pages.stories', compact('allStories', 'featuredStories', 'filters'));
    }

    public function show(AlumniStory $story)
    {
        abort_unless(
            $story->status === AlumniStory::STATUS_PUBLISHED && $story->published_at && $story->published_at->lte(now()),
            404
        );

        $story->load('alumni');

        $relatedStories = AlumniStory::published()
            ->with('alumni')
            ->where('alumni_id', $story->alumni_id)
            ->where('id', '!=', $story->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        if ($relatedStories->count() < 3) {
            $existingIds = $relatedStories->pluck('id')->push($story->id);
            $additional = AlumniStory::published()
                ->with('alumni')
                ->whereNotIn('id', $existingIds)
                ->latest('published_at')
                ->limit(3 - $relatedStories->count())
                ->get();
            $relatedStories = $relatedStories->concat($additional);
        }

        return view('pages.story-show', ['story' => $story, 'relatedStories' => $relatedStories]);
    }
}
