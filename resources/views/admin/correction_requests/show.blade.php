<x-layouts.admin title="Correction Request Details">
    @php
        $alumni = $correctionRequest->alumni;
        $currentValue = $alumni?->{$correctionRequest->requested_field} ?? '—';
    @endphp

    <div class="mb-6">
        <div class="flex items-center gap-2 text-xs font-semibold text-navy-500 uppercase tracking-wider mb-1">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-navy-900 transition">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.correction-requests.index') }}" class="hover:text-navy-900 transition">Correction Requests</a>
            <span>/</span>
            <span class="text-navy-800">#{{ $correctionRequest->id }}</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-navy-950">
                    Correction Request #{{ $correctionRequest->id }}
                </h1>
                <p class="text-xs sm:text-sm text-navy-500 mt-1">
                    Submitted on {{ $correctionRequest->created_at->format('F j, Y \a\t g:i A') }}
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a
                    href="{{ route('admin.correction-requests.index') }}"
                    class="rounded-xl border border-navy-200 bg-white px-4 py-2 text-xs font-semibold text-navy-700 hover:bg-navy-50 transition"
                >
                    ← Back to List
                </a>

                @if ($correctionRequest->status === 'pending')
                    <form method="POST" action="{{ route('admin.correction-requests.reject', $correctionRequest) }}" onsubmit="return confirm('Are you sure you want to reject this correction request?')">
                        @csrf
                        <button
                            type="submit"
                            class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-100 transition"
                        >
                            Reject
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.correction-requests.approve', $correctionRequest) }}" onsubmit="return confirm('Approve this change? The alumni profile record will be updated immediately.')">
                        @csrf
                        <button
                            type="submit"
                            class="rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 px-4 py-2 text-xs font-bold text-white shadow-md hover:from-emerald-700 hover:to-emerald-800 transition"
                        >
                            Approve & Update Profile
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Left: Member Information --}}
        <div class="rounded-3xl bg-white border border-navy-100 p-6 shadow-sm">
            <h2 class="font-serif text-base font-bold text-navy-950 pb-3 border-b border-navy-100">
                Alumni Member
            </h2>

            <div class="mt-4 space-y-3 text-xs">
                <div>
                    <span class="text-navy-400 block text-[10px] uppercase font-bold tracking-wider">Full Name</span>
                    <span class="font-bold text-navy-950 text-sm">{{ $alumni?->full_name ?? '—' }}</span>
                </div>
                <div>
                    <span class="text-navy-400 block text-[10px] uppercase font-bold tracking-wider">Email Address</span>
                    <span class="text-navy-800">{{ $alumni?->email ?? '—' }}</span>
                </div>
                <div>
                    <span class="text-navy-400 block text-[10px] uppercase font-bold tracking-wider">Student ID</span>
                    <span class="text-navy-800 font-mono">{{ $alumni?->student_id ?? '—' }}</span>
                </div>
                <div>
                    <span class="text-navy-400 block text-[10px] uppercase font-bold tracking-wider">Batch</span>
                    <span class="text-navy-800">{{ $alumni?->batch ?? '—' }}</span>
                </div>
                <div>
                    <span class="text-navy-400 block text-[10px] uppercase font-bold tracking-wider">Graduation Year</span>
                    <span class="text-navy-800">{{ $alumni?->graduation_year ?? '—' }}</span>
                </div>
            </div>

            @if ($alumni)
                <div class="mt-6 pt-4 border-t border-navy-100">
                    <a
                        href="{{ route('admin.alumni.show', $alumni) }}"
                        class="inline-flex items-center gap-1 text-xs font-bold text-maroon-700 hover:text-maroon-900 transition"
                    >
                        <span>View Full Alumni Record</span>
                        <span>→</span>
                    </a>
                </div>
            @endif
        </div>

        {{-- Right: Field Difference & Reason --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Comparison Card --}}
            <div class="rounded-3xl bg-white border border-navy-100 p-6 shadow-sm">
                <div class="flex items-center justify-between pb-4 border-b border-navy-100">
                    <div>
                        <h2 class="font-serif text-base font-bold text-navy-950">Field Comparison</h2>
                        <p class="text-xs text-navy-500">Target Field: <strong class="font-mono text-navy-900">{{ $correctionRequest->requested_field }}</strong></p>
                    </div>

                    <div>
                        @if ($correctionRequest->status === 'pending')
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800">
                                <span class="h-2 w-2 rounded-full bg-amber-600 animate-pulse"></span>
                                Pending Review
                            </span>
                        @elseif ($correctionRequest->status === 'approved')
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">
                                <span class="h-2 w-2 rounded-full bg-emerald-600"></span>
                                Approved
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-100 px-3 py-1 text-xs font-bold text-rose-800">
                                <span class="h-2 w-2 rounded-full bg-rose-600"></span>
                                Rejected
                            </span>
                        @endif
                    </div>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl bg-rose-50/50 border border-rose-200/60 p-4">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-rose-600">Current Value in Database</span>
                        <p class="mt-2 font-mono text-base font-semibold text-navy-900 line-through">
                            {{ $currentValue }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-emerald-50/60 border border-emerald-200/80 p-4">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700">Requested New Value</span>
                        <p class="mt-2 font-mono text-base font-bold text-emerald-950">
                            {{ $correctionRequest->requested_value }}
                        </p>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-navy-400">Justification / Reason</h3>
                    <div class="mt-2 rounded-2xl bg-navy-50/50 border border-navy-100 p-4 text-xs leading-relaxed text-navy-800">
                        {{ $correctionRequest->reason ?: 'No explanation was submitted with this request.' }}
                    </div>
                </div>
            </div>

            {{-- Audit Trail Card --}}
            <div class="rounded-3xl bg-white border border-navy-100 p-6 shadow-sm">
                <h2 class="font-serif text-base font-bold text-navy-950 pb-3 border-b border-navy-100">
                    Audit Log
                </h2>

                <div class="mt-4 grid gap-4 sm:grid-cols-2 text-xs">
                    <div>
                        <span class="text-navy-400 block text-[10px] uppercase font-bold tracking-wider">Reviewer</span>
                        <span class="font-semibold text-navy-900">{{ $correctionRequest->reviewer?->name ?? 'Not reviewed yet' }}</span>
                    </div>
                    <div>
                        <span class="text-navy-400 block text-[10px] uppercase font-bold tracking-wider">Reviewed At</span>
                        <span class="text-navy-900">{{ $correctionRequest->reviewed_at ? $correctionRequest->reviewed_at->format('F j, Y \a\t g:i A') : 'Pending' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
