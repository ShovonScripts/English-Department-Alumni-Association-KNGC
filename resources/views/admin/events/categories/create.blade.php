<x-layouts.admin title="Add Event Category">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Add Event Category</h1>
            <p class="mt-1 text-sm text-ink-soft">Create a new category for events.</p>
        </div>
        <a href="{{ route('admin.events.categories.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
            &larr; Back to Categories
        </a>
    </div>

    <form method="POST" action="{{ route('admin.events.categories.store') }}">
        @csrf
        @include('admin.events.categories._form')
        <div class="mt-8 flex flex-wrap items-center gap-3">
            <x-button type="submit" variant="gold">Create Category</x-button>
            <a href="{{ route('admin.events.categories.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">Cancel</a>
        </div>
    </form>
</x-layouts.admin>
