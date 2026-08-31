<x-layouts.admin title="Add Album">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Add Album</h1>
            <p class="mt-1 text-sm text-ink-soft">Create a new photo album.</p>
        </div>
        <a href="{{ route('admin.gallery.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
            &larr; Back to Gallery
        </a>
    </div>

    <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
        @csrf

        @include('admin.gallery._form')

        <div class="mt-8 flex flex-wrap items-center gap-3">
            <x-button type="submit" variant="gold">Create Album</x-button>
            <a href="{{ route('admin.gallery.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                Cancel
            </a>
        </div>
    </form>
</x-layouts.admin>
