<x-layouts.app :title="'My Profile'">
    <section class="bg-navy-950 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-3xl font-bold text-white">My Profile</h1>
            <p class="mt-2 text-sm text-white/60">Your alumni profile information</p>
        </div>
    </section>

    <section class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <aside class="lg:col-span-1">
                    <div class="rounded-lg border border-navy-100 bg-white p-4 shadow-sm">
                        <x-member.sidebar />
                    </div>
                </aside>

                <main class="lg:col-span-3 space-y-6">
                    @if (session('success'))
                        <div class="rounded-md border border-emerald-200 bg-emerald-50 p-4">
                            <p class="text-sm text-emerald-800">{{ session('success') }}</p>
                        </div>
                    @endif

                    <div class="premium-card">
                        <div class="border-b border-navy-100 px-6 py-4 flex items-center justify-between bg-white">
                            <h2 class="font-serif text-lg font-semibold text-navy-950">Profile Information</h2>
                            <a href="{{ route('member.profile.edit') }}" class="btn btn-primary gap-2">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                Edit Profile
                            </a>
                        </div>

                        <div class="p-6">
                            <div class="flex items-start gap-6">
                                <div class="h-24 w-24 shrink-0 overflow-hidden rounded-full bg-navy-100 ring-2 ring-navy-200">
                                    @if ($alumni->profile_photo)
                                        <img src="{{ $alumni->profile_photo_url }}" alt="{{ $alumni->full_name }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-2xl font-bold text-navy-400">
                                            {{ strtoupper(substr($alumni->full_name, 0, 2)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-navy-950">{{ $alumni->full_name }}</h3>
                                    <p class="text-sm text-ink-soft mt-1">{{ $alumni->email }}</p>
                                    @if ($alumni->phone)
                                        <p class="text-sm text-ink-soft mt-0.5">{{ $alumni->phone }}</p>
                                    @endif
                                    <div class="mt-4 inline-flex items-center gap-1.5 rounded-full bg-navy-50 px-3 py-1 border border-navy-100">
                                        <span class="h-1.5 w-1.5 rounded-full bg-navy-400"></span>
                                        <span class="text-xs font-medium text-navy-700">Profile Completion: {{ $alumni->profileCompletionPercentage() }}%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wider text-ink-soft">Student ID</p>
                                    <p class="mt-1 text-sm font-medium text-navy-900">{{ $alumni->student_id }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wider text-ink-soft">Batch & Graduation</p>
                                    <p class="mt-1 text-sm font-medium text-navy-900">{{ $alumni->batch ?? '-' }} &bull; {{ $alumni->graduation_year ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wider text-ink-soft">Profession & Organization</p>
                                    <p class="mt-1 text-sm font-medium text-navy-900">{{ $alumni->profession ?? '-' }} @if($alumni->organization) at {{ $alumni->organization }} @endif</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wider text-ink-soft">Location</p>
                                    <p class="mt-1 text-sm font-medium text-navy-900">{{ collect([$alumni->city, $alumni->country])->filter()->implode(', ') ?: '-' }}</p>
                                </div>
                                @if($alumni->website_url || $alumni->linkedin_url)
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wider text-ink-soft">Links</p>
                                    <div class="mt-1 flex gap-3">
                                        @if($alumni->website_url)
                                            <a href="{{ \App\Support\UrlHelper::safeHref($alumni->website_url) }}" target="_blank" rel="noopener noreferrer" class="text-sm font-medium text-maroon-700 hover:underline">Website</a>
                                        @endif
                                        @if($alumni->linkedin_url)
                                            <a href="{{ \App\Support\UrlHelper::safeHref($alumni->linkedin_url) }}" target="_blank" rel="noopener noreferrer" class="text-sm font-medium text-maroon-700 hover:underline">LinkedIn</a>
                                        @endif
                                    </div>
                                </div>
                                @endif
                                <div class="sm:col-span-2 border-t border-navy-50 pt-6">
                                    <p class="text-xs font-medium uppercase tracking-wider text-ink-soft">Bio</p>
                                    <p class="mt-2 text-sm text-navy-900 leading-relaxed">{{ $alumni->bio ?? 'No biography provided yet.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
</x-layouts.app>
