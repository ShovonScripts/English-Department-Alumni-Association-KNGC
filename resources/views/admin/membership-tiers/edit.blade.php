<x-layouts.admin title="Edit Membership Tier">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Edit Membership Tier</h1>
            <p class="mt-1 text-sm text-ink-soft">{{ $tier->memberships_count }} {{ \Illuminate\Support\Str::plural('member', $tier->memberships_count) }} currently hold this tier.</p>
        </div>
        <a href="{{ route('admin.membership-tiers.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
            &larr; Back to Tiers
        </a>
    </div>

    <form method="POST" action="{{ route('admin.membership-tiers.update', $tier) }}">
        @csrf
        @method('PUT')

        @include('admin.membership-tiers._form', ['tier' => $tier])

        <div class="mt-8 flex flex-wrap items-center gap-3">
            <x-button type="submit" variant="gold">Save Changes</x-button>
            <a href="{{ route('admin.membership-tiers.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                Cancel
            </a>
        </div>
    </form>
</x-layouts.admin>
