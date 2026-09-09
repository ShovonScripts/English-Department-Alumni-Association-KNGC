<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search'));
        $categoryId = $request->query('category_id');
        $timing = $request->query('timing');

        $upcomingEvents = Event::query()
            ->published()
            ->upcoming()
            ->with('category')
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%" . $this->escapeLike($search) . "%")
                    ->orWhere('venue', 'like', "%" . $this->escapeLike($search) . "%");
            }))
            ->when($categoryId, fn ($query, $categoryId) => $query->where('category_id', $categoryId))
            ->when($timing === 'past', fn ($query) => $query->whereRaw('1 = 0'))
            ->orderBy('event_date')
            ->get();

        $pastEvents = Event::query()
            ->published()
            ->past()
            ->with('category')
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%" . $this->escapeLike($search) . "%")
                    ->orWhere('venue', 'like', "%" . $this->escapeLike($search) . "%");
            }))
            ->when($categoryId, fn ($query, $categoryId) => $query->where('category_id', $categoryId))
            ->when($timing === 'upcoming', fn ($query) => $query->whereRaw('1 = 0'))
            ->orderByDesc('event_date')
            ->get();

        return view('pages.events', [
            'upcomingEvents' => $upcomingEvents,
            'pastEvents' => $pastEvents,
            'categories' => EventCategory::orderBy('name')->get(),
            'filters' => [
                'search' => $search,
                'category_id' => $categoryId,
                'timing' => $timing,
            ],
        ]);
    }

    public function show(Event $event)
    {
        abort_unless($event->status === Event::STATUS_PUBLISHED, 404);

        $event->load('category');

        return view('pages.event-show', [
            'event' => $event,
        ]);
    }
}
