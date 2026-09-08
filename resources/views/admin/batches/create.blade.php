<x-layouts.admin title="Add Batch">
    <div class="mb-8">
        <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Add Batch</h1>
        <p class="mt-1 text-sm text-ink-soft">Create a new academic batch for the English Department, KNGC.</p>
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
        <form method="POST" action="{{ route('admin.batches.store') }}" class="space-y-6">
            @csrf

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="start_year" class="mb-1.5 block text-sm font-semibold text-navy-950">
                        Start Year <span class="text-maroon-600">*</span>
                    </label>
                    <input
                        type="number"
                        id="start_year"
                        name="start_year"
                        value="{{ old('start_year') }}"
                        min="1900"
                        max="2100"
                        required
                        class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm {{ $errors->has('start_year') ? 'border-red-400 bg-red-50' : '' }}"
                        placeholder="e.g. 2002"
                    >
                </div>

                <div>
                    <label for="end_year" class="mb-1.5 block text-sm font-semibold text-navy-950">
                        End Year <span class="text-maroon-600">*</span>
                    </label>
                    <input
                        type="number"
                        id="end_year"
                        name="end_year"
                        value="{{ old('end_year') }}"
                        min="1900"
                        max="2100"
                        required
                        class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm {{ $errors->has('end_year') ? 'border-red-400 bg-red-50' : '' }}"
                        placeholder="e.g. 2003"
                    >
                    <p class="mt-1 text-xs text-ink-soft">Label will be auto-generated (e.g. "2002-03").</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <input
                    type="checkbox"
                    id="is_active"
                    name="is_active"
                    value="1"
                    {{ old('is_active', '1') === '1' ? 'checked' : '' }}
                    class="focus-ring h-4 w-4 rounded border-navy-300 text-maroon-600"
                >
                <label for="is_active" class="text-sm font-semibold text-navy-950">Active</label>
            </div>

            <div class="flex items-center gap-3">
                <x-button type="submit" variant="gold">Create Batch</x-button>
                <a href="{{ route('admin.batches.index') }}" class="focus-ring inline-flex h-10 items-center justify-center rounded-md px-4 text-sm font-semibold text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.admin>
