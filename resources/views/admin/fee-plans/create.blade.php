<x-layouts.admin title="Add Fee Plan">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Add Fee Plan</h1>
            <p class="mt-1 text-sm text-ink-soft">Define a fee that EDAA-KNGC charges its members.</p>
        </div>
        <a href="{{ route('admin.fee-plans.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
            &larr; Back to Fee Plans
        </a>
    </div>

    <form method="POST" action="{{ route('admin.fee-plans.store') }}">
        @csrf

        @include('admin.fee-plans._form')

        <div class="mt-8 flex flex-wrap items-center gap-3">
            <x-button type="submit" variant="gold">Create Fee Plan</x-button>
            <a href="{{ route('admin.fee-plans.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                Cancel
            </a>
        </div>
    </form>
</x-layouts.admin>
