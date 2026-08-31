<x-layouts.admin :title="$member->name">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">{{ $member->name }}</h1>
            <p class="mt-1 text-sm text-ink-soft">{{ $member->position }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <x-button href="{{ route('admin.committee.edit', $member) }}" variant="navy">Edit Record</x-button>
            <form method="POST" action="{{ route('admin.committee.destroy', $member) }}" onsubmit="return confirm('Delete {{ addslashes($member->name) }}? This cannot be undone.');">
                @csrf
                @method('DELETE')
                <x-button type="submit" variant="outline">Delete</x-button>
            </form>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('status') }}
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Summary --}}
        <div class="lg:col-span-1">
            <div class="rounded-lg border border-navy-100 bg-white p-8 text-center shadow-sm">
                @if ($member->profile_photo_url)
                    <img src="{{ $member->profile_photo_url }}" alt="" class="mx-auto h-32 w-32 rounded-full object-cover ring-4 ring-gold-500/30">
                @else
                    <span class="mx-auto flex h-32 w-32 items-center justify-center rounded-full bg-navy-900 font-serif text-3xl font-semibold text-gold-300 ring-4 ring-gold-500/30" aria-hidden="true">
                        {{ \Illuminate\Support\Str::initials($member->name) }}
                    </span>
                @endif

                <h2 class="mt-5 font-serif text-xl font-semibold text-navy-950">{{ $member->name }}</h2>
                <p class="mt-1 text-sm font-medium text-maroon-700">{{ $member->position }}</p>

                <div class="mt-4 flex flex-wrap items-center justify-center gap-2">
                    @if ($member->is_active)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-xs font-semibold text-navy-800">
                            <span class="h-1.5 w-1.5 rounded-full bg-navy-600" aria-hidden="true"></span>
                            Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-maroon-100 px-2.5 py-1 text-xs font-semibold text-maroon-800">
                            <span class="h-1.5 w-1.5 rounded-full bg-maroon-600" aria-hidden="true"></span>
                            Inactive
                        </span>
                    @endif
                </div>

                @if ($member->is_active)
                    <div class="mt-6">
                        <x-button href="{{ route('committee.show', $member) }}" variant="outline" :icon="true" target="_blank" rel="noopener noreferrer">View Public Profile</x-button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Details --}}
        <div class="grid gap-6 lg:col-span-2">
            <div class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Record Details</h2>
                <dl class="mt-6 grid gap-x-8 gap-y-6 sm:grid-cols-2">
                    @foreach ([
                        'Position' => $member->position,
                        'Email' => $member->email,
                        'LinkedIn' => $member->linkedin_url,
                        'Website' => $member->website_url,
                        'Sort Order' => $member->sort_order,
                        'Created' => $member->created_at?->format('M j, Y g:i A'),
                        'Updated' => $member->updated_at?->format('M j, Y g:i A'),
                    ] as $label => $value)
                        @if ($value)
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">{{ $label }}</dt>
                                @if (in_array($label, ['LinkedIn', 'Website']))
                                    <dd class="mt-1 text-sm text-navy-950">
                                        <a href="{{ \App\Support\UrlHelper::safeHref($value) }}" target="_blank" rel="noopener noreferrer" class="focus-ring rounded text-maroon-700 hover:text-maroon-600">{{ $value }}</a>
                                    </dd>
                                @else
                                    <dd class="mt-1 break-words text-sm text-navy-950">{{ $value }}</dd>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </dl>
            </div>

            @if ($member->short_bio)
                <div class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                    <h2 class="font-serif text-xl font-semibold text-navy-950">Short Biography</h2>
                    <p class="mt-4 text-sm leading-relaxed text-ink-soft">{{ $member->short_bio }}</p>
                </div>
            @endif

            @if ($member->biography)
                <div class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                    <h2 class="font-serif text-xl font-semibold text-navy-950">Full Biography</h2>
                    <p class="mt-4 text-sm leading-relaxed text-ink-soft">{{ $member->biography }}</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
