@php
    $member = $member ?? null;
    $inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
@endphp

{{-- Basic Information --}}
<section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Basic Information</h2>
    <p class="mt-1 text-sm text-ink-soft">The committee member's name and position.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div>
            <label for="name" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Full name *</label>
            <input type="text" id="name" name="name" value="{{ old('name', $member?->name) }}" required placeholder="e.g. Dr. Grace Adeyemi" class="{{ $inputClass }} {{ $errors->has('name') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('name')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="position" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Position *</label>
            <input type="text" id="position" name="position" value="{{ old('position', $member?->position) }}" required placeholder="e.g. President" class="{{ $inputClass }} {{ $errors->has('position') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : '' }}">
            @error('position')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>

{{-- Profile --}}
<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Profile</h2>
    <p class="mt-1 text-sm text-ink-soft">Photo and biographical information.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="profile_photo" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Profile photo</label>
            <div x-data="{ preview: @js($member?->profile_photo_url), updatePreview(event) { const file = event.target.files[0]; if (!file) return; const reader = new FileReader(); reader.onload = (e) => this.preview = e.target.result; reader.readAsDataURL(file); } }">
                <div class="flex items-center gap-4">
                    <template x-if="preview">
                        <img :src="preview" alt="" class="h-20 w-20 rounded-full object-cover ring-4 ring-gold-500/30">
                    </template>
                    <template x-if="!preview">
                        <span class="flex h-20 w-20 items-center justify-center rounded-full bg-navy-900 font-serif text-lg font-semibold text-gold-300 ring-4 ring-gold-500/30" aria-hidden="true">
                            {{ \Illuminate\Support\Str::initials(old('name', $member?->name ?? '')) }}
                        </span>
                    </template>
                    <input
                        type="file"
                        id="profile_photo"
                        name="profile_photo"
                        accept="image/*"
                        @change="updatePreview"
                        class="block w-full text-sm text-ink-soft file:mr-4 file:rounded-md file:border-0 file:bg-navy-900 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-navy-800"
                    >
                </div>
                <p class="mt-2 text-xs text-ink-soft">JPEG, PNG or WebP, up to 2MB.</p>
                @error('profile_photo')
                    <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="sm:col-span-2">
            <label for="short_bio" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Short biography</label>
            <input type="text" id="short_bio" name="short_bio" value="{{ old('short_bio', $member?->short_bio) }}" maxlength="500" placeholder="A brief one-line summary" class="{{ $inputClass }}">
            @error('short_bio')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="biography" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Full biography</label>
            <textarea id="biography" name="biography" rows="6" maxlength="5000" placeholder="Detailed background and achievements" class="{{ $inputClass }}">{{ old('biography', $member?->biography) }}</textarea>
            @error('biography')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>

{{-- Contact --}}
<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Contact</h2>
    <p class="mt-1 text-sm text-ink-soft">Email is kept private. Links are shown publicly.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div>
            <label for="email" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $member?->email) }}" placeholder="member@example.org" class="{{ $inputClass }}">
            @error('email')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="linkedin_url" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">LinkedIn URL</label>
            <input type="url" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $member?->linkedin_url) }}" placeholder="https://linkedin.com/in/…" class="{{ $inputClass }}">
            @error('linkedin_url')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="website_url" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Website URL</label>
            <input type="url" id="website_url" name="website_url" value="{{ old('website_url', $member?->website_url) }}" placeholder="https://example.com" class="{{ $inputClass }}">
            @error('website_url')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>

{{-- Display --}}
<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Display Settings</h2>
    <p class="mt-1 text-sm text-ink-soft">Visibility and ordering on the public page.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div>
            <label for="sort_order" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Sort order</label>
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $member?->sort_order ?? 0) }}" min="0" class="{{ $inputClass }}">
            @error('sort_order')
                <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-end">
            <label class="inline-flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-3">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500" @checked(old('is_active', $member?->is_active ?? true))>
                <span class="text-sm font-medium text-navy-950">Active — visible on public site</span>
            </label>
        </div>
    </div>
</section>
