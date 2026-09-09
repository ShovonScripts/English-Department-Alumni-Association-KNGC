<x-layouts.admin title="SEO Manager">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">SEO Manager</h1>
                <p class="mt-1 text-sm text-ink-soft">
                    Monitor and optimize your site's search engine visibility.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.seo.sitemap') }}" class="focus-ring inline-flex items-center gap-2 rounded-lg border border-navy-200 bg-white px-4 py-2.5 text-sm font-semibold text-navy-950 transition-colors hover:bg-navy-50">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                    </svg>
                    Sitemap
                </a>
                <a href="{{ route('admin.seo.settings') }}" class="focus-ring inline-flex items-center gap-2 rounded-lg border border-navy-200 bg-white px-4 py-2.5 text-sm font-semibold text-navy-950 transition-colors hover:bg-navy-50">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Global Settings
                </a>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg border border-navy-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Total Pages</p>
                    <p class="mt-1 text-2xl font-bold text-navy-950">{{ $totalPages }}</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy-100">
                    <svg class="h-5 w-5 text-navy-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-lg border border-navy-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Configured</p>
                    <p class="mt-1 text-2xl font-bold text-emerald-600">{{ $configuredCount }}</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100">
                    <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-lg border border-navy-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">With Description</p>
                    <p class="mt-1 text-2xl font-bold text-blue-600">{{ $withDescriptionCount }}</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100">
                    <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-lg border border-navy-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">With OG Image</p>
                    <p class="mt-1 text-2xl font-bold text-gold-600">{{ $withOgImageCount }}</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gold-100">
                    <svg class="h-5 w-5 text-gold-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Page List --}}
    <div class="rounded-lg border border-navy-100 bg-white shadow-sm">
        <div class="border-b border-navy-100 px-6 py-4">
            <h2 class="text-lg font-semibold text-navy-950">Page SEO Overview</h2>
            <p class="mt-0.5 text-sm text-ink-soft">Manage meta tags, Open Graph, and social cards for each page.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-navy-100 text-left">
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-ink-soft">Page</th>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-ink-soft">URI</th>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-ink-soft">Meta Title</th>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-ink-soft">Description</th>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-ink-soft">OG Image</th>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-ink-soft">Indexing</th>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-ink-soft text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-50">
                    @forelse ($publicPages as $uri => $pageName)
                        @php $meta = $metas->get($uri); @endphp
                        <tr class="hover:bg-navy-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-navy-950">{{ $pageName }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <code class="rounded bg-navy-100 px-2 py-0.5 text-xs text-navy-700">{{ $uri }}</code>
                            </td>
                            <td class="px-6 py-4">
                                @if ($meta && $meta->title)
                                    <span class="text-sm text-navy-950">{{ Str::limit($meta->title, 40) }}</span>
                                @else
                                    <span class="text-xs text-ink-soft italic">Using global default</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($meta && $meta->description)
                                    <span class="text-sm text-navy-950">{{ Str::limit($meta->description, 50) }}</span>
                                @else
                                    <span class="text-xs text-ink-soft italic">Using global default</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($meta && $meta->og_image)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-700">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                        Set
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-0.5 text-xs font-medium text-navy-500">
                                        None
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($meta && $meta->noindex)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-700">
                                        Noindex
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-700">
                                        Index
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.seo.pages.edit', urlencode($uri)) }}" class="focus-ring inline-flex items-center gap-1.5 rounded-lg bg-navy-900 px-3 py-1.5 text-xs font-semibold text-white transition-colors hover:bg-navy-800">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-3 text-sm text-ink-soft">No pages found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
