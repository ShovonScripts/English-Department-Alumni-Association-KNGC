<x-layouts.admin title="Record Payment">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Record Payment</h1>
            <p class="mt-1 text-sm text-ink-soft">Manually record a fee collected from a member.</p>
        </div>
        <a href="{{ route('admin.payments.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
            &larr; Back to Payments
        </a>
    </div>

    <form method="POST" action="{{ route('admin.payments.store') }}">
        @csrf

        @include('admin.payments._form')

        <div class="mt-8 flex flex-wrap items-center gap-3">
            <x-button type="submit" variant="gold">Record Payment</x-button>
            <a href="{{ route('admin.payments.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                Cancel
            </a>
        </div>
    </form>
</x-layouts.admin>
