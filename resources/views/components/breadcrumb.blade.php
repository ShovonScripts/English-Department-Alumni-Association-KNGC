@props([
    'items' => [],
])

<nav aria-label="Breadcrumb" class="text-sm">
    <ol class="flex flex-wrap items-center gap-1.5 text-navy-100">
        <li>
            <a href="{{ route('home') }}" class="focus-ring inline-flex items-center gap-1.5 rounded transition-colors hover:text-gold-300">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Home
            </a>
        </li>

        @foreach ($items as $item)
            <li class="flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5 text-navy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>

                @if (isset($item['url']) && $item['url'])
                    <a href="{{ $item['url'] }}" class="focus-ring rounded transition-colors hover:text-gold-300">
                        {{ $item['label'] }}
                    </a>
                @else
                    <span class="text-white" aria-current="page">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>