<x-layouts.admin title="Data Correction Requests">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-navy-500 uppercase tracking-wider mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-navy-900 transition">Dashboard</a>
                <span>/</span>
                <span class="text-navy-800">Community</span>
            </div>
            <h1 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-navy-950">
                Alumni Correction Requests
            </h1>
            <p class="text-xs sm:text-sm text-navy-500 mt-1">
                Review and approve profile data corrections submitted by verified alumni members.
            </p>
        </div>
    </div>

    {{-- Requests Table --}}
    <div class="rounded-3xl bg-white border border-navy-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-navy-50/70 border-b border-navy-100 text-navy-600 font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="px-5 py-3.5">Alumni Member</th>
                        <th class="px-5 py-3.5">Requested Field</th>
                        <th class="px-5 py-3.5">Current Value</th>
                        <th class="px-5 py-3.5">Proposed Value</th>
                        <th class="px-5 py-3.5">Reason</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Submitted</th>
                        <th class="px-5 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-50">
                    @forelse ($requests as $item)
                        @php
                            $currentValue = $item->alumni?->{$item->requested_field} ?? '—';
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-5 py-4">
                                <div class="font-bold text-navy-950">{{ $item->alumni?->full_name ?? 'Unknown Alumni' }}</div>
                                <div class="text-[11px] text-navy-500">{{ $item->alumni?->email ?? 'No email' }}</div>
                            </td>
                            <td class="px-5 py-4 font-mono font-medium text-navy-700">
                                <span class="rounded-md bg-navy-100/80 px-2 py-0.5 text-[11px]">
                                    {{ str_replace('_', ' ', $item->requested_field) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-navy-500 line-through">
                                {{ $currentValue }}
                            </td>
                            <td class="px-5 py-4 font-semibold text-emerald-700 bg-emerald-50/40">
                                {{ $item->requested_value }}
                            </td>
                            <td class="px-5 py-4 text-navy-600 max-w-xs truncate" title="{{ $item->reason }}">
                                {{ $item->reason ?: 'No explanation provided' }}
                            </td>
                            <td class="px-5 py-4">
                                @if ($item->status === 'pending')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-0.5 text-[10px] font-bold text-amber-800 ring-1 ring-amber-500/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-600"></span>
                                        Pending
                                    </span>
                                @elseif ($item->status === 'approved')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-[10px] font-bold text-emerald-800 ring-1 ring-emerald-500/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                                        Approved
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-rose-100 px-2.5 py-0.5 text-[10px] font-bold text-rose-800 ring-1 ring-rose-500/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-600"></span>
                                        Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-navy-500 whitespace-nowrap">
                                {{ $item->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a
                                        href="{{ route('admin.correction-requests.show', $item) }}"
                                        class="rounded-lg p-1.5 text-navy-600 hover:bg-navy-100 hover:text-navy-900 transition"
                                        title="View Details"
                                    >
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    @if ($item->status === 'pending')
                                        <form method="POST" action="{{ route('admin.correction-requests.approve', $item) }}" class="inline" onsubmit="return confirm('Approve this correction and immediately update the alumni profile?')">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="rounded-lg p-1.5 text-emerald-600 hover:bg-emerald-50 hover:text-emerald-800 transition"
                                                title="Approve and Apply"
                                            >
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.correction-requests.reject', $item) }}" class="inline" onsubmit="return confirm('Reject this correction request?')">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="rounded-lg p-1.5 text-rose-600 hover:bg-rose-50 hover:text-rose-800 transition"
                                                title="Reject Request"
                                            >
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-navy-400">
                                <div class="max-w-sm mx-auto">
                                    <svg class="h-10 w-10 mx-auto text-navy-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="font-bold text-navy-800 text-sm">No correction requests found</p>
                                    <p class="text-xs text-navy-500 mt-1">When alumni members request corrections to their student records, they will appear here for review.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($requests->hasPages())
            <div class="px-5 py-4 border-t border-navy-100 bg-navy-50/50">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
