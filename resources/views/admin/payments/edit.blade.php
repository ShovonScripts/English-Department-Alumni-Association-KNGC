<x-layouts.admin title="Edit Payment">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Edit Payment</h1>
            <p class="mt-1 text-sm text-ink-soft">{{ $payment->payment_number }} — corrections to amount, status, date, reference, and notes only.</p>
        </div>
        <a href="{{ route('admin.payments.show', $payment) }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
            &larr; Back to Payment
        </a>
    </div>

    @if (session('status'))
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.payments.update', $payment) }}">
        @csrf
        @method('PUT')

        @include('admin.payments._form', ['payment' => $payment])

        <div class="mt-8 flex flex-wrap items-center gap-3">
            <x-button type="submit" variant="gold">Save Changes</x-button>
            <a href="{{ route('admin.payments.show', $payment) }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                Cancel
            </a>
        </div>
    </form>
</x-layouts.admin>
