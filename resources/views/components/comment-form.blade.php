@props(['commentableType', 'commentableId'])

<section id="comments" class="mt-12 rounded-xl border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h3 class="font-serif text-xl font-semibold text-navy-950">
        Discussion
        <span class="text-sm font-normal text-ink-soft">({{ $commentableType::find($commentableId)->comments()->approved()->count() }} comments)</span>
    </h3>

    {{-- Comment Form --}}
    @auth
        <form method="POST" action="{{ route('comments.store') }}" class="mt-6">
            @csrf
            <input type="hidden" name="commentable_type" value="{{ $commentableType }}">
            <input type="hidden" name="commentable_id" value="{{ $commentableId }}">

            <div class="flex gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-navy-900 font-serif text-xs font-bold text-gold-300">
                    {{ \Illuminate\Support\Str::initials(auth()->user()->name ?? '') }}
                </div>
                <div class="flex-1">
                    <textarea
                        name="body"
                        rows="3"
                        required
                        maxlength="2000"
                        placeholder="Share your thoughts..."
                        class="focus-ring w-full rounded-lg border border-navy-200 bg-navy-50/50 px-4 py-3 text-sm text-navy-950 placeholder-navy-400 resize-none transition-colors focus:bg-white focus:border-gold-500"
                    ></textarea>
                    <div class="mt-2 flex items-center justify-between">
                        <p class="text-xs text-ink-soft">Be respectful. No spam.</p>
                        <button type="submit" class="focus-ring inline-flex items-center gap-2 rounded-lg bg-gold-500 px-4 py-2 text-sm font-semibold text-navy-950 shadow-sm transition-colors hover:bg-gold-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                            Post Comment
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @else
        <div class="mt-6 rounded-lg border border-dashed border-navy-200 bg-navy-50/50 p-6 text-center">
            <p class="text-sm text-ink-soft">
                <a href="{{ route('member.login') }}" class="font-semibold text-maroon-600 hover:text-maroon-700">Login</a>
                or
                <a href="{{ route('membership.apply') }}" class="font-semibold text-maroon-600 hover:text-maroon-700">become a member</a>
                to join the discussion.
            </p>
        </div>
    @endauth
</section>
