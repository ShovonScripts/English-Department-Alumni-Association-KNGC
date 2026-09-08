<x-layouts.admin title="Create Admin">
    <div class="mb-8">
        <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Create Admin User</h1>
        <p class="mt-1 text-sm text-ink-soft">Add a new administrator to the system.</p>
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

    <form method="POST" action="{{ route('admin.admins.store') }}" class="max-w-2xl">
        @csrf

        <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm space-y-5">
            <div>
                <label for="name" class="mb-1.5 block text-sm font-semibold text-navy-950">Full Name <span class="text-maroon-600">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400"
                    placeholder="Enter full name">
            </div>

            <div>
                <label for="email" class="mb-1.5 block text-sm font-semibold text-navy-950">Email Address <span class="text-maroon-600">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400"
                    placeholder="admin@example.com">
            </div>

            <div>
                <label for="password" class="mb-1.5 block text-sm font-semibold text-navy-950">Password <span class="text-maroon-600">*</span></label>
                <input type="password" id="password" name="password" required
                    class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400"
                    placeholder="Minimum 8 characters">
            </div>

            <div>
                <label for="password_confirmation" class="mb-1.5 block text-sm font-semibold text-navy-950">Confirm Password <span class="text-maroon-600">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400"
                    placeholder="Repeat password">
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-3">
            <a href="{{ route('admin.admins.index') }}" class="focus-ring inline-flex items-center justify-center rounded-md px-4 py-2.5 text-sm font-semibold text-navy-600 transition-colors hover:bg-navy-50">
                Cancel
            </a>
            <button type="submit" class="focus-ring inline-flex items-center justify-center rounded-lg bg-gold-500 px-6 py-2.5 text-sm font-semibold text-navy-950 shadow-sm transition-colors hover:bg-gold-400">
                Create Admin
            </button>
        </div>
    </form>
</x-layouts.admin>
