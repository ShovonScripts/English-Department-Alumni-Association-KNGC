<x-layouts.admin title="Edit Batch {{ $batch->label }}">
    <div class="mb-8">
        <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Edit Batch {{ $batch->label }}</h1>
        <p class="mt-1 text-sm text-ink-soft">Update settings for this academic batch.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-md border border-maroon-200 bg-maroon-50 px-4 py-3 text-sm font-medium text-maroon-800">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
        <form method="POST" action="{{ route('admin.batches.update', $batch) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-navy-950">Batch Label</label>
                    <p class="rounded-md border border-navy-200 bg-navy-50 px-4 py-2.5 text-sm font-medium text-navy-950">{{ $batch->label }}</p>
                    <p class="mt-1 text-xs text-ink-soft">Batch labels cannot be changed after creation.</p>
                </div>

                <div>
                    <label for="sort_order" class="mb-1.5 block text-sm font-semibold text-navy-950">Sort Order</label>
                    <input
                        type="number"
                        id="sort_order"
                        name="sort_order"
                        value="{{ old('sort_order', $batch->sort_order) }}"
                        min="0"
                        class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm"
                    >
                </div>
            </div>

            <div class="flex items-center gap-3">
                <input
                    type="checkbox"
                    id="is_active"
                    name="is_active"
                    value="1"
                    {{ old('is_active', $batch->is_active) ? 'checked' : '' }}
                    class="focus-ring h-4 w-4 rounded border-navy-300 text-maroon-600"
                >
                <label for="is_active" class="text-sm font-semibold text-navy-950">Active</label>
            </div>

            <div class="flex items-center gap-3">
                <x-button type="submit" variant="gold">Save Changes</x-button>
                <a href="{{ route('admin.batches.index') }}" class="focus-ring inline-flex h-10 items-center justify-center rounded-md px-4 text-sm font-semibold text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.admin>
