<x-layouts.app title="Apply for Membership" description="Submit your membership application to the English Department Alumni Association KNGC.">

    @push('head')
        <meta name="robots" content="noindex, nofollow">
    @endpush

    <x-page-header
        title="Apply for Membership"
        description="Complete the form below to submit your membership application."
        eyebrow="Application"
        :breadcrumbs="[
            ['label' => 'Membership', 'href' => route('membership')],
            ['label' => 'Apply'],
        ]"
    />

    <section class="section-pad bg-cream relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-navy-900/5 to-transparent pointer-events-none"></div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-gold-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 -left-24 w-72 h-72 bg-maroon-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="container-page relative z-10">
            <div class="mx-auto max-w-4xl">

                {{-- Intro --}}
                <div class="mb-10 rounded-2xl border border-navy-100 bg-white/80 backdrop-blur-xl p-6 shadow-sm sm:p-8 card-lift relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-gold-500"></div>
                    <div class="flex flex-col sm:flex-row sm:items-start gap-5">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-maroon-50 border border-maroon-100">
                            <svg class="h-6 w-6 text-maroon-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-serif text-xl font-semibold text-navy-950">Before you begin</h3>
                            <ul class="mt-3 space-y-2 text-sm text-ink-soft">
                                <li class="flex items-start gap-2.5">
                                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-maroon-400"></span>
                                    <span>Please have your <strong class="font-medium text-navy-950">student ID</strong>, <strong class="font-medium text-navy-950">batch</strong>, and <strong class="font-medium text-navy-950">graduation year</strong> ready.</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-maroon-400"></span>
                                    <span>You may upload an optional <strong class="font-medium text-navy-950">alumni proof document</strong> (marksheet, certificate, or degree) to speed up verification.</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-maroon-400"></span>
                                    <span>Fields marked with <span class="text-maroon-600 font-bold">*</span> are required.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Success --}}
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)" x-transition.opacity.duration.500ms class="mb-8 flex items-start gap-4 rounded-xl border border-green-200 bg-green-50/80 backdrop-blur-sm p-6 text-green-900 shadow-sm" role="alert">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-green-200/50">
                            <svg class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-green-800">Application Submitted Successfully</p>
                            <p class="mt-1 text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="ml-auto p-1 text-green-600 hover:text-green-800 transition-colors">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </button>
                    </div>
                @endif

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="mb-8 rounded-xl border border-maroon-200 bg-maroon-50/80 backdrop-blur-sm p-6 text-maroon-900 shadow-sm" role="alert">
                        <div class="flex items-start gap-4">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-maroon-200/50">
                                <svg class="h-5 w-5 text-maroon-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-maroon-800">Please fix the following errors:</p>
                                <ul class="mt-2 list-inside list-disc text-sm text-maroon-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('membership.apply.store') }}" enctype="multipart/form-data" novalidate x-data="{ submitting: false }" @submit="submitting = true" class="space-y-8">
                    @csrf

                    {{-- Honeypot --}}
                    <div class="absolute -left-[9999px]" aria-hidden="true">
                        <input type="text" name="website" tabindex="-1" autocomplete="off" value="">
                    </div>

                    <div class="premium-card bg-white shadow-lg shadow-navy-900/5 relative">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-navy-900 via-navy-600 to-gold-500"></div>
                        
                        <div class="p-8 sm:p-10 divide-y divide-navy-100">
                            
                            {{-- Section 1: Personal Information --}}
                            <div class="pb-10">
                                <div class="flex items-center gap-4 mb-8">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-navy-900 text-white font-serif text-lg font-bold shadow-md">1</div>
                                    <div>
                                        <h2 class="font-serif text-2xl font-bold text-navy-950">Personal Information</h2>
                                        <p class="text-sm text-ink-soft mt-1">Your contact and identity details.</p>
                                    </div>
                                </div>
                                <div class="grid gap-6 sm:grid-cols-2 ml-0 sm:ml-14">
                                    <div class="sm:col-span-2 group">
                                        <label for="full_name" class="form-label group-focus-within:text-gold-600 transition-colors">
                                            Full Name <span class="text-maroon-600">*</span>
                                        </label>
                                        <input id="full_name" type="text" name="full_name" value="{{ old('full_name') }}" required class="input-field" aria-required="true" placeholder="As it appears on your certificate">
                                    </div>

                                    <div class="group">
                                        <label for="email" class="form-label group-focus-within:text-gold-600 transition-colors">
                                            Email Address <span class="text-maroon-600">*</span>
                                        </label>
                                        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="input-field" aria-required="true" placeholder="you@example.com">
                                        <p class="mt-1.5 text-xs text-ink-soft">We'll use this to communicate about your application.</p>
                                    </div>

                                    <div class="group">
                                        <label for="phone" class="form-label group-focus-within:text-gold-600 transition-colors">
                                            Phone Number <span class="text-maroon-600">*</span>
                                        </label>
                                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required class="input-field" aria-required="true" placeholder="+880 1XXXXXXXXX">
                                    </div>

                                    <div class="group">
                                        <label for="city" class="form-label group-focus-within:text-gold-600 transition-colors">City</label>
                                        <input id="city" type="text" name="city" value="{{ old('city') }}" class="input-field" placeholder="e.g. Dhaka">
                                    </div>
                                </div>
                            </div>

                            {{-- Section 2: Academic Information --}}
                            <div class="py-10">
                                <div class="flex items-center gap-4 mb-8">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-navy-900 text-white font-serif text-lg font-bold shadow-md">2</div>
                                    <div>
                                        <h2 class="font-serif text-2xl font-bold text-navy-950">Academic Information</h2>
                                        <p class="text-sm text-ink-soft mt-1">Details from your time at KNGC.</p>
                                    </div>
                                </div>
                                <div class="grid gap-6 sm:grid-cols-3 ml-0 sm:ml-14">
                                    <div class="group">
                                        <label for="student_id" class="form-label group-focus-within:text-gold-600 transition-colors">Student ID</label>
                                        <input id="student_id" type="text" name="student_id" value="{{ old('student_id') }}" class="input-field" placeholder="e.g. KNGC-18-1234">
                                    </div>

                                    <div class="group">
                                        <label for="batch" class="form-label group-focus-within:text-gold-600 transition-colors">Batch</label>
                                        <input id="batch" type="text" name="batch" value="{{ old('batch') }}" class="input-field" placeholder="e.g. 2018-19">
                                    </div>

                                    <div class="group">
                                        <label for="graduation_year" class="form-label group-focus-within:text-gold-600 transition-colors">Graduation Year</label>
                                        <input id="graduation_year" type="number" name="graduation_year" value="{{ old('graduation_year') }}" min="1960" max="{{ (int) date('Y') + 1 }}" class="input-field" placeholder="e.g. 2022">
                                    </div>
                                </div>
                            </div>

                            {{-- Section 3: Alumni Proof Document --}}
                            <div class="py-10">
                                <div class="flex items-center gap-4 mb-8">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-navy-900 text-white font-serif text-lg font-bold shadow-md">3</div>
                                    <div>
                                        <h2 class="font-serif text-2xl font-bold text-navy-950">Alumni Proof Document</h2>
                                        <p class="text-sm text-ink-soft mt-1">Optional — upload to speed up verification.</p>
                                    </div>
                                </div>
                                <div class="ml-0 sm:ml-14">
                                    <div
                                        x-data="{ fileName: '', dragging: false }"
                                        class="relative rounded-2xl border-2 border-dashed transition-all duration-300"
                                        :class="dragging ? 'border-gold-500 bg-gold-500/10 scale-[1.02]' : 'border-navy-200 bg-navy-50/50 hover:border-navy-400 hover:bg-navy-50'"
                                        @dragover.prevent="dragging = true"
                                        @dragleave="dragging = false"
                                        @drop.prevent="dragging = false; $refs.alumniDocInput.files = $event.dataTransfer.files; fileName = $event.dataTransfer.files[0].name"
                                    >
                                        <input type="file" id="alumni_document" name="alumni_document" accept=".pdf,.jpg,.jpeg,.png" x-ref="alumniDocInput" @change="fileName = $event.target.files[0]?.name || ''" class="absolute inset-0 z-10 w-full h-full cursor-pointer opacity-0">
                                        <div class="flex flex-col items-center justify-center px-6 py-12 text-center pointer-events-none">
                                            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-white shadow-sm border border-navy-100 transition-transform duration-300" :class="dragging ? 'scale-110 text-gold-600' : 'text-navy-500'">
                                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                                                </svg>
                                            </div>
                                            <p class="mt-4 text-base font-semibold text-navy-950">
                                                <span x-show="!fileName" class="text-navy-600 underline decoration-navy-300 underline-offset-4">Click to upload</span>
                                                <span x-show="!fileName"> or drag and drop</span>
                                                <span x-show="fileName" class="text-green-600">File selected!</span>
                                            </p>
                                            <p class="mt-1.5 text-sm text-ink-soft">PDF, JPG, or PNG — max 5 MB</p>
                                            <div x-show="fileName" x-cloak class="mt-4 inline-flex items-center gap-2 rounded-full bg-white border border-green-200 px-4 py-2 text-sm font-medium text-green-800 shadow-sm transition-all">
                                                <svg class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                <span x-text="fileName" class="truncate max-w-[200px] sm:max-w-xs"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 text-sm text-ink-soft flex items-start gap-2">
                                        <svg class="h-5 w-5 text-navy-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>
                                        <span>Accepted documents: marksheet, transcript, degree certificate, or any official document proving your enrollment or graduation from KNGC.</span>
                                    </p>
                                </div>
                            </div>

                            {{-- Section 4: Profile Photo --}}
                            <div class="py-10">
                                <div class="flex items-center gap-4 mb-8">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-navy-900 text-white font-serif text-lg font-bold shadow-md">4</div>
                                    <div>
                                        <h2 class="font-serif text-2xl font-bold text-navy-950">Profile Photo</h2>
                                        <p class="text-sm text-ink-soft mt-1">Optional — a clear headshot for your alumni profile.</p>
                                    </div>
                                </div>
                                <div class="ml-0 sm:ml-14">
                                    <div
                                        x-data="{ preview: '', dragging: false }"
                                        class="relative rounded-2xl border-2 border-dashed transition-all duration-300"
                                        :class="dragging ? 'border-gold-500 bg-gold-500/10 scale-[1.02]' : 'border-navy-200 bg-navy-50/50 hover:border-navy-400 hover:bg-navy-50'"
                                        @dragover.prevent="dragging = true"
                                        @dragleave="dragging = false"
                                        @drop.prevent="dragging = false; $refs.profilePhotoInput.files = $event.dataTransfer.files; const file = $event.dataTransfer.files[0]; if (file && file.type.startsWith('image/')) { preview = URL.createObjectURL(file); }"
                                    >
                                        <input type="file" id="profile_photo" name="profile_photo" accept="image/jpeg,image/png,image/webp" x-ref="profilePhotoInput" @change="const file = $event.target.files[0]; if (file && file.type.startsWith('image/')) { preview = URL.createObjectURL(file); } else { preview = ''; }" class="absolute inset-0 z-10 w-full h-full cursor-pointer opacity-0">

                                        {{-- Preview when photo selected --}}
                                        <div x-show="preview" x-cloak class="flex flex-col items-center px-6 py-8 text-center pointer-events-none">
                                            <div class="relative">
                                                <img :src="preview" alt="Preview" class="h-32 w-32 rounded-full object-cover ring-4 ring-gold-500/30 shadow-lg">
                                                <div class="absolute inset-0 flex items-center justify-center rounded-full bg-navy-900/40 opacity-0 hover:opacity-100 transition-opacity">
                                                    <span class="text-xs font-semibold text-white">Change</span>
                                                </div>
                                            </div>
                                            <p class="mt-4 text-sm font-medium text-green-600">Photo selected — click to change</p>
                                        </div>

                                        {{-- Dropzone when no photo --}}
                                        <div x-show="!preview" class="flex flex-col items-center justify-center px-6 py-12 text-center pointer-events-none">
                                            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-white shadow-sm border border-navy-100 transition-transform duration-300" :class="dragging ? 'scale-110 text-gold-600' : 'text-navy-500'">
                                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                                                </svg>
                                            </div>
                                            <p class="mt-4 text-base font-semibold text-navy-950">
                                                <span class="text-navy-600 underline decoration-navy-300 underline-offset-4">Click to upload</span>
                                                <span> or drag and drop</span>
                                            </p>
                                            <p class="mt-1.5 text-sm text-ink-soft">JPG, PNG, or WebP — max 2 MB</p>
                                        </div>
                                    </div>
                                    <p class="mt-3 text-sm text-ink-soft flex items-start gap-2">
                                        <svg class="h-5 w-5 text-navy-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>
                                        <span>Use a clear, well-lit headshot. This will appear on your alumni profile and leaderboard. You can change it later.</span>
                                    </p>
                                </div>
                            </div>

                            {{-- Section 5: Professional Information --}}
                            <div class="py-10">
                                <div class="flex items-center gap-4 mb-8">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-navy-900 text-white font-serif text-lg font-bold shadow-md">5</div>
                                    <div>
                                        <h2 class="font-serif text-2xl font-bold text-navy-950">Professional Information</h2>
                                        <p class="text-sm text-ink-soft mt-1">Your current career details (optional).</p>
                                    </div>
                                </div>
                                <div class="grid gap-6 sm:grid-cols-3 ml-0 sm:ml-14">
                                    <div class="group">
                                        <label for="profession" class="form-label group-focus-within:text-gold-600 transition-colors">Profession</label>
                                        <input id="profession" type="text" name="profession" value="{{ old('profession') }}" class="input-field" placeholder="e.g. Teacher, Engineer">
                                    </div>

                                    <div class="group">
                                        <label for="current_organization" class="form-label group-focus-within:text-gold-600 transition-colors">Organization</label>
                                        <input id="current_organization" type="text" name="current_organization" value="{{ old('current_organization') }}" class="input-field" placeholder="Company or institution">
                                    </div>

                                    <div class="group">
                                        <label for="current_designation" class="form-label group-focus-within:text-gold-600 transition-colors">Designation</label>
                                        <input id="current_designation" type="text" name="current_designation" value="{{ old('current_designation') }}" class="input-field" placeholder="Job title">
                                    </div>
                                </div>
                            </div>

                            {{-- Section 6: Additional Information --}}
                            <div class="pt-10">
                                <div class="flex items-center gap-4 mb-8">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-navy-900 text-white font-serif text-lg font-bold shadow-md">6</div>
                                    <div>
                                        <h2 class="font-serif text-2xl font-bold text-navy-950">Additional Information</h2>
                                        <p class="text-sm text-ink-soft mt-1">Anything else you'd like us to know.</p>
                                    </div>
                                </div>
                                <div class="ml-0 sm:ml-14 group">
                                    <label for="application_message" class="form-label group-focus-within:text-gold-600 transition-colors">Application Message</label>
                                    <textarea id="application_message" name="application_message" rows="5" maxlength="5000" class="input-field resize-y" placeholder="Tell us why you'd like to join, or share any relevant information (optional)">{{ old('application_message') }}</textarea>
                                    <div class="mt-2 flex items-center justify-between">
                                        <p class="text-xs text-ink-soft">Max 5,000 characters</p>
                                        <p x-data="{ count: {{ strlen(old('application_message', '')) }} }" class="text-xs font-medium text-navy-400">
                                            <span x-text="count"></span>/5000
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    {{-- Submit Area --}}
                    <div class="rounded-2xl border border-navy-100 bg-white/80 backdrop-blur-xl p-8 shadow-sm relative overflow-hidden card-lift">
                        <div class="absolute bottom-0 right-0 w-64 h-64 bg-gold-500/10 rounded-full blur-3xl pointer-events-none"></div>
                        <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between relative z-10">
                            <div class="flex items-start gap-3 max-w-lg">
                                <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-navy-50 text-navy-600">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="text-sm leading-relaxed text-ink-soft">
                                    By submitting this application, you confirm that the information provided is accurate. Your data is kept confidential and used solely for membership evaluation purposes.
                                </p>
                            </div>
                            <button type="submit" :disabled="submitting" class="group relative inline-flex shrink-0 items-center justify-center gap-2 overflow-hidden rounded-xl bg-navy-900 px-8 py-4 text-base font-semibold text-white shadow-lg shadow-navy-900/20 transition-all hover:-translate-y-0.5 hover:bg-navy-800 hover:shadow-xl hover:shadow-navy-900/30 focus:outline-none focus:ring-4 focus:ring-navy-900/20 disabled:cursor-not-allowed disabled:opacity-70 disabled:hover:translate-y-0 disabled:hover:shadow-lg">
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] pointer-events-none"></div>
                                <svg x-show="submitting" x-cloak class="h-5 w-5 animate-spin text-gold-400" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span x-text="submitting ? 'Submitting Application...' : 'Submit Application'"></span>
                                <svg x-show="!submitting" class="h-5 w-5 transition-transform group-hover:translate-x-1 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                                </svg>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
</x-layouts.app>
