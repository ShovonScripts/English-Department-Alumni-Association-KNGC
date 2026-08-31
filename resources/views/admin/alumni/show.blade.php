<x-layouts.admin :title="$alumni->full_name">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">{{ $alumni->full_name }}</h1>
            <p class="mt-1 text-sm text-ink-soft">
                {{ collect([$alumni->designation, $alumni->organization])->filter()->implode(' · ') }}
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <x-button href="{{ route('admin.alumni.edit', $alumni) }}" variant="navy">Edit Record</x-button>
            <form method="POST" action="{{ route('admin.alumni.destroy', $alumni) }}" onsubmit="return confirm('Delete {{ addslashes($alumni->full_name) }}? This cannot be undone.');">
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
                @if ($alumni->profile_photo_url)
                    <img src="{{ $alumni->profile_photo_url }}" alt="" class="mx-auto h-32 w-32 rounded-full object-cover ring-4 ring-gold-500/30">
                @else
                    <span class="mx-auto flex h-32 w-32 items-center justify-center rounded-full bg-navy-900 font-serif text-3xl font-semibold text-gold-300 ring-4 ring-gold-500/30" aria-hidden="true">
                        {{ \Illuminate\Support\Str::initials($alumni->full_name) }}
                    </span>
                @endif

                <div class="mt-5 flex flex-wrap items-center justify-center gap-2">
                    @if ($alumni->status === 'active')
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

                    @if ($alumni->is_featured)
                        <span class="inline-flex rounded-full bg-gold-500/20 px-2.5 py-1 text-xs font-semibold text-gold-700">Featured</span>
                    @endif
                </div>

                @if ($alumni->status === 'active')
                    <div class="mt-6">
                        <x-button href="{{ route('alumni.show', $alumni) }}" variant="outline" :icon="true" target="_blank" rel="noopener noreferrer">View Public Profile</x-button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Details --}}
        <div class="grid gap-6 lg:col-span-2">
            <div class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Record details</h2>
                <dl class="mt-6 grid gap-x-8 gap-y-6 sm:grid-cols-2">
                    @foreach ([
                        'Student ID' => $alumni->student_id,
                        'Batch' => $alumni->batch,
                        'Session' => $alumni->session,
                        'Graduation Year' => $alumni->graduation_year,
                        'Degree' => $alumni->degree,
                        'Profession' => $alumni->profession,
                        'Designation' => $alumni->designation,
                        'Organization' => $alumni->organization,
                        'City' => $alumni->city,
                        'Country' => $alumni->country,
                        'Email' => $alumni->email,
                        'Phone' => $alumni->phone,
                        'LinkedIn' => $alumni->linkedin_url,
                        'Website' => $alumni->website_url,
                        'Sort Order' => $alumni->sort_order,
                        'Created' => $alumni->created_at?->format('M j, Y g:i A'),
                        'Updated' => $alumni->updated_at?->format('M j, Y g:i A'),
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

            @if ($alumni->bio)
                <div class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                    <h2 class="font-serif text-xl font-semibold text-navy-950">Biography</h2>
                    <p class="mt-4 text-sm leading-relaxed text-ink-soft">{{ $alumni->bio }}</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>