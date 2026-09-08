<x-layouts.admin :title="'Edit ' . $pressRelease->title">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Edit Press Release</h1>
            <p class="mt-1 text-sm text-ink-soft">Update press release details.</p>
        </div>
        <a href="{{ route('admin.press-releases.show', $pressRelease) }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">Back to Press Release</a>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-md border border-maroon-200 bg-maroon-50 px-4 py-3 text-sm text-maroon-800">
            <p class="font-semibold">Please fix the following errors:</p>
            <ul class="mt-1 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.press-releases.update', $pressRelease) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.press-releases._form')
        <div class="mt-8 flex flex-wrap items-center gap-3">
            <x-button type="submit" variant="gold">Save Changes</x-button>
            <a href="{{ route('admin.press-releases.show', $pressRelease) }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">Cancel</a>
        </div>
    </form>
</x-layouts.admin>
