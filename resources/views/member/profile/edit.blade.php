<x-layouts.app :title="'Edit Profile'">
    <section class="bg-navy-950 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-3xl font-bold text-white">Edit Profile</h1>
            <p class="mt-2 text-sm text-white/60">Update your personal and professional information</p>
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
                    @if ($errors->any())
                        <div class="rounded-md border border-red-200 bg-red-50 p-4">
                            <ul class="list-inside list-disc space-y-1 text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="rounded-md border border-emerald-200 bg-emerald-50 p-4">
                            <p class="text-sm text-emerald-800">{{ session('success') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('member.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Profile Photo --}}
                        <div class="premium-card p-6" x-data="photoPreview()">
                            <h2 class="font-serif text-lg font-semibold text-navy-950 mb-4">Profile Photo</h2>
                            <div class="flex items-start gap-6">
                                <div class="h-24 w-24 shrink-0 overflow-hidden rounded-full bg-navy-100 ring-2 ring-navy-200">
                                    <img x-show="previewUrl" :src="previewUrl" alt="Preview" class="h-full w-full object-cover">
                                    <div x-show="!previewUrl" class="h-full w-full">
                                        @if ($alumni->profile_photo)
                                            <img src="{{ $alumni->profile_photo_url }}" alt="{{ $alumni->full_name }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-2xl font-bold text-navy-400">
                                                {{ strtoupper(substr($alumni->full_name, 0, 2)) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <label for="profile_photo" class="block text-sm font-medium text-navy-900">Upload new photo</label>
                                    <input type="file" id="profile_photo" name="profile_photo" accept="image/*" @change="updatePreview"
                                           class="mt-1.5 block w-full text-sm text-ink-soft file:mr-4 file:rounded-md file:border-0 file:bg-maroon-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-maroon-700 hover:file:bg-maroon-100" />
                                    <p class="mt-1 text-xs text-ink-soft">JPG, PNG, or WebP. Max 2MB.</p>
                                    @if ($alumni->profile_photo)
                                        <label class="mt-2 flex items-center gap-2 text-sm text-navy-700">
                                            <input type="checkbox" name="remove_photo" value="1" class="h-4 w-4 rounded border-navy-300 text-gold-500 focus:ring-gold-500" />
                                            Remove current photo
                                        </label>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Personal Information --}}
                        <div class="premium-card p-6">
                            <h2 class="font-serif text-lg font-semibold text-navy-950 mb-4">Personal Information</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-navy-900">Phone</label>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone', $alumni->phone) }}"
                                           class="mt-1.5 block w-full rounded-lg border border-navy-200 bg-white px-3.5 py-2.5 text-sm text-ink shadow-sm placeholder:text-ink-soft focus-ring" />
                                </div>
                                <div class="sm:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-navy-900">City</label>
                                        <input type="text" id="city" name="city" value="{{ old('city', $alumni->city) }}"
                                               class="mt-1.5 block w-full rounded-lg border border-navy-200 bg-white px-3.5 py-2.5 text-sm text-ink shadow-sm placeholder:text-ink-soft focus-ring" />
                                    </div>
                                    <div>
                                        <label for="country" class="block text-sm font-medium text-navy-900">Country</label>
                                        <input type="text" id="country" name="country" value="{{ old('country', $alumni->country) }}"
                                               class="mt-1.5 block w-full rounded-lg border border-navy-200 bg-white px-3.5 py-2.5 text-sm text-ink shadow-sm placeholder:text-ink-soft focus-ring" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Professional Information --}}
                        <div class="premium-card p-6">
                            <h2 class="font-serif text-lg font-semibold text-navy-950 mb-4">Professional Information</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="profession" class="block text-sm font-medium text-navy-900">Profession / Title</label>
                                    <input type="text" id="profession" name="profession" value="{{ old('profession', $alumni->profession) }}"
                                           class="mt-1.5 block w-full rounded-lg border border-navy-200 bg-white px-3.5 py-2.5 text-sm text-ink shadow-sm placeholder:text-ink-soft focus-ring" />
                                </div>
                                <div>
                                    <label for="organization" class="block text-sm font-medium text-navy-900">Organization</label>
                                    <input type="text" id="organization" name="organization" value="{{ old('organization', $alumni->organization) }}"
                                           class="mt-1.5 block w-full rounded-lg border border-navy-200 bg-white px-3.5 py-2.5 text-sm text-ink shadow-sm placeholder:text-ink-soft focus-ring" />
                                </div>
                                <div>
                                    <label for="website_url" class="block text-sm font-medium text-navy-900">Website URL</label>
                                    <input type="url" id="website_url" name="website_url" value="{{ old('website_url', $alumni->website_url) }}" placeholder="https://"
                                           class="mt-1.5 block w-full rounded-lg border border-navy-200 bg-white px-3.5 py-2.5 text-sm text-ink shadow-sm placeholder:text-ink-soft focus-ring" />
                                </div>
                                <div>
                                    <label for="linkedin_url" class="block text-sm font-medium text-navy-900">LinkedIn URL</label>
                                    <input type="url" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $alumni->linkedin_url) }}" placeholder="https://linkedin.com/in/..."
                                           class="mt-1.5 block w-full rounded-lg border border-navy-200 bg-white px-3.5 py-2.5 text-sm text-ink shadow-sm placeholder:text-ink-soft focus-ring" />
                                </div>
                            </div>
                        </div>

                        {{-- About You --}}
                        <div class="premium-card p-6">
                            <h2 class="font-serif text-lg font-semibold text-navy-950 mb-4">About You</h2>
                            <div>
                                <label for="bio" class="block text-sm font-medium text-navy-900">Bio</label>
                                <textarea id="bio" name="bio" rows="4"
                                          class="mt-1.5 block w-full rounded-lg border border-navy-200 bg-white px-3.5 py-2.5 text-sm text-ink shadow-sm placeholder:text-ink-soft focus-ring"
                                          placeholder="Tell us a bit about yourself...">{{ old('bio', $alumni->bio) }}</textarea>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 justify-end">
                            <a href="{{ route('member.profile') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>

                    {{-- Protected Fields --}}
                    <div class="premium-card p-6" x-data="{ openCorrection: false, correctionField: '', fieldLabel: '' }">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="font-serif text-lg font-semibold text-navy-950">Authoritative Records</h2>
                        </div>
                        <p class="text-sm text-ink-soft mb-6">These fields are tied to official alumni records and cannot be directly modified. If there is an error, you may request a correction.</p>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                            <div>
                                <p class="text-xs font-medium uppercase tracking-wider text-ink-soft">Full Name</p>
                                <div class="mt-1 flex items-center justify-between bg-navy-50 px-3 py-2 rounded border border-navy-100">
                                    <span class="text-sm text-navy-900">{{ $alumni->full_name }}</span>
                                    <button @click="openCorrection = true; correctionField = 'full_name'; fieldLabel = 'Full Name'" type="button" class="text-xs font-medium text-maroon-700 hover:underline">Request Correction</button>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-medium uppercase tracking-wider text-ink-soft">Student ID</p>
                                <div class="mt-1 flex items-center justify-between bg-navy-50 px-3 py-2 rounded border border-navy-100">
                                    <span class="text-sm text-navy-900">{{ $alumni->student_id ?: '-' }}</span>
                                    <button @click="openCorrection = true; correctionField = 'student_id'; fieldLabel = 'Student ID'" type="button" class="text-xs font-medium text-maroon-700 hover:underline">Request Correction</button>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-medium uppercase tracking-wider text-ink-soft">Batch</p>
                                <div class="mt-1 flex items-center justify-between bg-navy-50 px-3 py-2 rounded border border-navy-100">
                                    <span class="text-sm text-navy-900">{{ $alumni->batch ?: '-' }}</span>
                                    <button @click="openCorrection = true; correctionField = 'batch'; fieldLabel = 'Batch'" type="button" class="text-xs font-medium text-maroon-700 hover:underline">Request Correction</button>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-medium uppercase tracking-wider text-ink-soft">Graduation Year</p>
                                <div class="mt-1 flex items-center justify-between bg-navy-50 px-3 py-2 rounded border border-navy-100">
                                    <span class="text-sm text-navy-900">{{ $alumni->graduation_year ?: '-' }}</span>
                                    <button @click="openCorrection = true; correctionField = 'graduation_year'; fieldLabel = 'Graduation Year'" type="button" class="text-xs font-medium text-maroon-700 hover:underline">Request Correction</button>
                                </div>
                            </div>
                        </div>

                        {{-- Correction Modal --}}
                        <div x-show="openCorrection" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-navy-900/50 backdrop-blur-sm" style="display: none;">
                            <div @click.away="openCorrection = false" class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
                                <form method="POST" action="{{ route('member.correction-requests.store') }}">
                                    @csrf
                                    <input type="hidden" name="requested_field" x-bind:value="correctionField">
                                    
                                    <div class="px-6 py-4 border-b border-navy-100 flex items-center justify-between">
                                        <h3 class="font-serif text-lg font-semibold text-navy-900">Request Correction</h3>
                                        <button type="button" @click="openCorrection = false" class="text-navy-400 hover:text-navy-600">
                                            <span class="sr-only">Close</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                        </button>
                                    </div>
                                    <div class="p-6 space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-navy-900">Field</label>
                                            <p class="mt-1 text-sm text-ink-soft" x-text="fieldLabel"></p>
                                        </div>
                                        <div>
                                            <label for="requested_value" class="block text-sm font-medium text-navy-900">Correct Value</label>
                                            <input type="text" id="requested_value" name="requested_value" required
                                                   class="mt-1.5 block w-full rounded-lg border border-navy-200 px-3 py-2 text-sm focus-ring">
                                        </div>
                                        <div>
                                            <label for="reason" class="block text-sm font-medium text-navy-900">Reason / Proof</label>
                                            <textarea id="reason" name="reason" rows="3" required
                                                      class="mt-1.5 block w-full rounded-lg border border-navy-200 px-3 py-2 text-sm focus-ring" placeholder="Please provide context for this correction..."></textarea>
                                        </div>
                                    </div>
                                    <div class="px-6 py-4 bg-navy-50 flex justify-end gap-3 rounded-b-2xl">
                                        <button type="button" @click="openCorrection = false" class="btn btn-secondary text-sm">Cancel</button>
                                        <button type="submit" class="btn btn-primary text-sm">Submit Request</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            function photoPreview() {
                return {
                    previewUrl: null,
                    updatePreview(event) {
                        const file = event.target.files[0];
                        if (file) {
                            this.previewUrl = URL.createObjectURL(file);
                        } else {
                            this.previewUrl = null;
                        }
                    }
                }
            }
        </script>
    @endpush
</x-layouts.app>
