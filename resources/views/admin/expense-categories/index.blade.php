<x-layouts.admin title="Expense Categories">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Expense Categories</h1>
            <p class="mt-1 text-sm text-ink-soft">
                Classifications for association spending. Categories with recorded expenses cannot be deleted.
            </p>
        </div>
        <x-button href="{{ route('admin.expense-categories.create') }}" variant="gold">Add Category</x-button>
    </div>

    @if (session('status'))
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            {{ session('status') }}
        </div>
    @endif

    @if (session('warning'))
        <div class="mb-6 flex items-center gap-3 rounded-md border border-gold-500/50 bg-gold-500/10 px-4 py-3 text-sm text-gold-700" role="alert">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.9L1.8 18a2 2 0 001.7 3h17a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z" />
            </svg>
            {{ session('warning') }}
        </div>
    @endif

    @if ($categories->count())
        <div class="overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-navy-100 text-sm">
                    <thead class="bg-cream">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Description</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Expenses</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</th>
                            <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-ink-soft">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-navy-50">
                        @foreach ($categories as $category)
                            <tr class="transition-colors hover:bg-cream/60">
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-navy-950">{{ $category->name }}</span>
                                    <span class="block text-xs text-ink-soft">Sort order: {{ $category->sort_order }}</span>
                                </td>
                                <td class="max-w-xs px-6 py-4 text-ink-soft">{{ Str::limit($category->description, 80) ?: '—' }}</td>
                                <td class="px-6 py-4 text-ink-soft">{{ number_format($category->expenses_count) }}</td>
                                <td class="px-6 py-4">
                                    @if ($category->is_active)
                                        <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-bold uppercase tracking-wide text-emerald-800">Active</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-maroon-100 px-2.5 py-1 text-xs font-bold uppercase tracking-wide text-maroon-800">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.expense-categories.edit', $category) }}" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900" aria-label="Edit {{ $category->name }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2 2 0 112.8 2.8L11 15l-4 1 1-4 9.6-9.4z" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.expense-categories.destroy', $category) }}" onsubmit="return confirm('Delete category {{ $category->name }}? Only categories without expenses can be deleted.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-maroon-700 transition-colors hover:bg-maroon-50" aria-label="Delete {{ $category->name }}">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.9 12.1A2 2 0 0116.1 21H7.9a2 2 0 01-2-1.9L5 7m5 4v6m4-6v6M4 7h16M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-navy-100 px-6 py-4">
                {{ $categories->links() }}
            </div>
        </div>
    @else
        <div class="mt-8">
            <x-empty-state
                title="No expense categories"
                description="Create the first category so association expenses can be classified."
                action_label="Add Category"
                action_href="{{ route('admin.expense-categories.create') }}"
            />
        </div>
    @endif
</x-layouts.admin>
