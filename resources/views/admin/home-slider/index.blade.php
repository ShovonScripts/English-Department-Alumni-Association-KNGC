<x-layouts.admin title="Home Slider">
    <div class="mb-8">
        <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Home Slider</h1>
        <p class="mt-1 text-sm text-ink-soft">
            Manage the Facebook Group section slider images (max 5).
        </p>
    </div>

    @if (session('status'))
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-md border border-maroon-200 bg-maroon-50 px-4 py-3 text-sm font-medium text-maroon-800">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Upload Form --}}
    <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
        <div class="flex items-center gap-3 mb-6">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gold-100">
                <svg class="h-5 w-5 text-gold-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-navy-950">Upload New Image</h2>
                <p class="text-sm text-ink-soft">Add images to the Facebook Group CTA slider. {{ 5 - $slides->count() }} slots remaining.</p>
            </div>
        </div>

        @if ($slides->count() < 5)
        <form method="POST" action="{{ route('admin.home-slider.store') }}" enctype="multipart/form-data" class="flex flex-col gap-4 sm:flex-row sm:items-end">
            @csrf
            <div class="flex-1">
                <label for="image" class="mb-1.5 block text-sm font-semibold text-navy-950">
                    Image <span class="text-maroon-600">*</span>
                </label>
                <input
                    type="file"
                    id="image"
                    name="image"
                    accept="image/jpeg,image/png,image/webp"
                    required
                    class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 file:mr-4 file:rounded file:border-0 file:bg-navy-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-navy-800"
                >
                <p class="mt-1 text-xs text-ink-soft">JPEG, PNG or WebP. Max 8MB. Recommended: 1200×600px.</p>
            </div>
            <div class="flex-1">
                <label for="alt_text" class="mb-1.5 block text-sm font-semibold text-navy-950">Alt Text</label>
                <input
                    type="text"
                    id="alt_text"
                    name="alt_text"
                    placeholder="Describe the image"
                    class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400"
                >
            </div>
            <x-button type="submit" variant="gold">Upload</x-button>
        </form>
        @else
        <div class="rounded-md bg-navy-50 px-4 py-3 text-sm text-navy-600">
            Maximum of 5 images reached. Delete an image to upload a new one.
        </div>
        @endif
    </div>

    {{-- Current Slides --}}
    <div class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
        <div class="flex items-center gap-3 mb-6">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy-100">
                <svg class="h-5 w-5 text-navy-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-navy-950">Current Slides</h2>
                <p class="text-sm text-ink-soft">Drag to reorder. Click save after changing order.</p>
            </div>
        </div>

        @if ($slides->isEmpty())
        <div class="rounded-md border-2 border-dashed border-navy-200 bg-navy-50/50 px-6 py-12 text-center">
            <svg class="mx-auto h-12 w-12 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V5.25a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v14.25a1.5 1.5 0 001.5 1.5z" />
            </svg>
            <p class="mt-3 text-sm font-medium text-navy-600">No slider images yet</p>
            <p class="mt-1 text-xs text-ink-soft">Upload your first image above to get started.</p>
        </div>
        @else
        <form method="POST" action="{{ route('admin.home-slider.reorder') }}" id="reorder-form">
            @csrf
            @method('PUT')
            <div class="space-y-4" id="sortable-slides">
                @foreach ($slides as $slide)
                <div class="flex flex-col gap-4 rounded-lg border border-navy-100 bg-navy-50/50 p-4 sm:flex-row sm:items-center" data-id="{{ $slide->id }}">
                    <input type="hidden" name="order[]" value="{{ $slide->id }}">

                    {{-- Drag Handle --}}
                    <div class="flex items-center gap-3 sm:order-1">
                        <button type="button" class="cursor-grab text-navy-400 hover:text-navy-600" title="Drag to reorder">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                                                    </svg>
                        </button>
                        <span class="text-xs font-semibold text-navy-400">#{{ $loop->iteration }}</span>
                    </div>

                    {{-- Image Preview --}}
                    <div class="shrink-0 sm:order-2">
                        <img src="{{ $slide->image_url }}" alt="{{ $slide->alt_text }}" class="h-20 w-32 rounded-md border border-navy-200 object-cover">
                    </div>

                    {{-- Details --}}
                    <div class="flex-1 sm:order-3">
                        <p class="text-xs text-ink-soft">{{ $slide->image_path }}</p>
                        <p class="mt-1 text-xs text-ink-soft">Alt: {{ $slide->alt_text ?: '(none)' }}</p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 sm:order-4">
                        {{-- Toggle Active --}}
                        <form method="POST" action="{{ route('admin.home-slider.update', $slide) }}" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="alt_text" value="{{ $slide->alt_text }}">
                            <input type="hidden" name="sort_order" value="{{ $slide->sort_order }}">
                            <input type="hidden" name="is_active" value="{{ $slide->is_active ? '' : '1' }}">
                            @if ($slide->is_active)
                                <input type="hidden" name="is_active" value="1">
                            @endif
                            <button type="submit" class="inline-flex items-center gap-1 rounded-md px-2.5 py-1.5 text-xs font-medium transition-colors {{ $slide->is_active ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' : 'bg-navy-100 text-navy-500 hover:bg-navy-200' }}">
                                {{ $slide->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>

                        {{-- Delete --}}
                        <form method="POST" action="{{ route('admin.home-slider.destroy', $slide) }}" onsubmit="return confirm('Delete this slider image?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1 rounded-md bg-maroon-50 px-2.5 py-1.5 text-xs font-medium text-maroon-700 transition-colors hover:bg-maroon-100">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            @if ($slides->count() > 1)
            <div class="mt-4 flex justify-end">
                <x-button type="submit" variant="navy">Save Order</x-button>
            </div>
            @endif
        </form>
        @endif
    </div>
</x-layouts.admin>
