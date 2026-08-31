<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search'));
        $categoryId = $request->query('category_id');
        $status = $request->query('status');
        $featured = $request->query('featured');
        $timing = $request->query('timing');

        $events = Event::query()
            ->with('category')
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('venue', 'like', "%{$search}%")
                    ->orWhere('organizer', 'like', "%{$search}%");
            }))
            ->when($categoryId, fn ($query, $categoryId) => $query->where('category_id', $categoryId))
            ->when($status, fn ($query, $status) => $query->where('status', $status))
            ->when($featured !== null && $featured !== '', fn ($query) => $query->where('is_featured', filter_var($featured, FILTER_VALIDATE_BOOL)))
            ->when($timing === 'upcoming', fn ($query) => $query->upcoming())
            ->when($timing === 'past', fn ($query) => $query->past())
            ->orderByDesc('event_date')
            ->paginate(15)
            ->withQueryString();

        return view('admin.events.index', [
            'events' => $events,
            'filters' => [
                'search' => $search,
                'category_id' => $categoryId,
                'status' => $status,
                'featured' => $featured,
                'timing' => $timing,
            ],
            'categories' => EventCategory::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.events.create', [
            'categories' => EventCategory::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $data['slug'] = Event::uniqueSlug($data['title']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['category_id'] = $data['category_id'] ?? null;

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('events', 'public');
        }

        Event::create($data);

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Event created.');
    }

    public function show(Event $event)
    {
        $event->load('category');

        return view('admin.events.show', [
            'event' => $event,
        ]);
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', [
            'event' => $event,
            'categories' => EventCategory::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate($this->rules($event));

        $data['is_featured'] = $request->boolean('is_featured');
        $data['category_id'] = $data['category_id'] ?? null;

        if ($request->hasFile('cover_image')) {
            if ($event->cover_image) {
                Storage::disk('public')->delete($event->cover_image);
            }

            $data['cover_image'] = $request->file('cover_image')->store('events', 'public');
        }

        $event->update($data);

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Event updated.');
    }

    public function destroy(Event $event)
    {
        if ($event->cover_image) {
            Storage::disk('public')->delete($event->cover_image);
        }

        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Event deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(?Event $event = null): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:event_categories,id'],
            'short_description' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string', 'max:10000'],
            'event_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after_or_equal:start_time'],
            'venue' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'organizer' => ['nullable', 'string', 'max:255'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'registration_deadline' => ['nullable', 'date', 'before_or_equal:event_date'],
            'status' => ['required', Rule::in([Event::STATUS_DRAFT, Event::STATUS_PUBLISHED])],
            'is_featured' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'cover_image' => [
                'nullable',
                'sometimes',
                File::image()
                    ->max('2mb')
                    ->dimensions(Rule::dimensions()->maxWidth(4000)->maxHeight(4000)),
            ],
        ];
    }
}
