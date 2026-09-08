<x-layouts.admin title="Add Press Release">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Add Press Release</h1>
            <p class="mt-1 text-sm text-ink-soft">Publish an official announcement or press release.</p>
        </div>
        <x-button href="{{ route('admin.press-releases.index') }}" variant="outline">
            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Press Releases
        </x-button>
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

    <form method="POST" action="{{ route('admin.press-releases.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.press-releases._form')
        <div class="mt-8 flex flex-wrap items-center gap-3">
            <x-button type="submit" variant="gold">Create Press Release</x-button>
            <x-button href="{{ route('admin.press-releases.index') }}" variant="ghost">Cancel</x-button>
        </div>
    </form>
</x-layouts.admin>
