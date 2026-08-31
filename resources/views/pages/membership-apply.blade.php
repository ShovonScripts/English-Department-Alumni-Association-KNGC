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

    <section class="section-pad bg-cream">
        <div class="container-page">
            <div class="mx-auto max-w-3xl">

                {{-- Intro --}}
                <div class="mb-8 rounded-xl border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex items-start gap-4">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-maroon-100">
                            <svg class="h-5 w-5 text-maroon-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-serif text-lg font-semibold text-navy-950">Before you begin</h3>
                            <ul class="mt-2 space-y-1.5 text-sm text-ink-soft">
                                <li class="flex items-start gap-2">
                                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-maroon-400"></span>
                                    Please have your <strong class="font-medium text-navy-950">student ID</strong>, <strong class="font-medium text-navy-950">batch</strong>, and <strong class="font-medium text-navy-950">graduation year</strong> ready.
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-maroon-400"></span>
                                    You may upload an optional <strong class="font-medium text-navy-950">alumni proof document</strong> (marksheet, certificate, or degree) to speed up verification.
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-maroon-400"></span>
                                    Fields marked with <span class="text-maroon-600 font-semibold">*</span> are required.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Success --}}
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)" x-transition class="mb-6 flex items-start gap-3 rounded-lg border border-green-200 bg-green-50 p-5 text-green-800" role="alert">
                        <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-semibold">Success</p>
                            <p class="mt-1 text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-maroon-200 bg-maroon-50 p-5 text-maroon-800" role="alert">
                        <div class="flex items-start gap-3">
                            <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <div>
                                <p class="font-semibold">Please fix the following errors:</p>
                                <ul class="mt-2 list-inside list-disc text-sm space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('membership.apply.store') }}" enctype="multipart/form-data" novalidate x-data="{ submitting: false }" @submit="submitting = true">

                    {{-- Honeypot --}}
                    <div class="absolute -left-[9999px]" aria-hidden="true">
                        <input type="text" name="website" tabindex="-1" autocomplete="off" value="">
                    </div>

                    {{-- Section 1: Personal Information --}}
                    <div class="rounded-xl border border-navy-100 bg-white shadow-sm">
                        <div class="border-b border-navy-100 px-6 py-4 sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-navy-950 text-sm font-bold text-white">1</span>
                                <div>
                                    <h2 class="font-serif text-lg font-semibold text-navy-950">Personal Information</h2>
                                    <p class="text-xs text-ink-soft">Your contact and identity details.</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-6 sm:px-8">
                            <div class="grid gap-5 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label for="full_name" class="mb-1.5 block text-sm font-semibold text-navy-950">
                                        Full Name <span class="text-maroon-600">*</span>
                                    </label>
                                    <input
                                        id="full_name"
                                        type="text"
                                        name="full_name"
                                        value="{{ old('full_name') }}"
                                        required
                                        class="input-field"
                                        aria-required="true"
                                        placeholder="As it appears on your certificate"
                                    >
                                </div>

                                <div>
                                    <label for="email" class="mb-1.5 block text-sm font-semibold text-navy-950">
                                        Email Address <span class="text-maroon-600">*</span>
                                    </label>
                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        required
                                        class="input-field"
                                        aria-required="true"
                                        placeholder="you@example.com"
                                    >
                                    <p class="mt-1 text-xs text-ink-soft">We'll use this to communicate about your application.</p>
                                </div>

                                <div>
                                    <label for="phone" class="mb-1.5 block text-sm font-semibold text-navy-950">
                                        Phone Number <span class="text-maroon-600">*</span>
                                    </label>
                                    <input
                                        id="phone"
                                        type="tel"
                                        name="phone"
                                        value="{{ old('phone') }}"
                                        required
                                        class="input-field"
                                        aria-required="true"
                                        placeholder="+880 1XXXXXXXXX"
                                    >
                                </div>

                                <div>
                                    <label for="date_of_birth" class="mb-1.5 block text-sm font-semibold text-navy-950">Date of Birth</label>
                                    <input
                                        id="date_of_birth"
                                        type="date"
                                        name="date_of_birth"
                                        value="{{ old('date_of_birth') }}"
                                        class="input-field"
                                    >
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="address" class="mb-1.5 block text-sm font-semibold text-navy-950">Street Address</label>
                                    <input
                                        id="address"
                                        type="text"
                                        name="address"
                                        value="{{ old('address') }}"
                                        class="input-field"
                                        placeholder="House #, Road #, Area"
                                    >
                                </div>

                                <div>
                                    <label for="city" class="mb-1.5 block text-sm font-semibold text-navy-950">City</label>
                                    <input
                                        id="city"
                                        type="text"
                                        name="city"
                                        value="{{ old('city') }}"
                                        class="input-field"
                                        placeholder="e.g. Dhaka"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Academic Information --}}
                    <div class="mt-6 rounded-xl border border-navy-100 bg-white shadow-sm">
                        <div class="border-b border-navy-100 px-6 py-4 sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-navy-950 text-sm font-bold text-white">2</span>
                                <div>
                                    <h2 class="font-serif text-lg font-semibold text-navy-950">Academic Information</h2>
                                    <p class="text-xs text-ink-soft">Details from your time at KNGC.</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-6 sm:px-8">
                            <div class="grid gap-5 sm:grid-cols-3">
                                <div>
                                    <label for="student_id" class="mb-1.5 block text-sm font-semibold text-navy-950">Student ID</label>
                                    <input
                                        id="student_id"
                                        type="text"
                                        name="student_id"
                                        value="{{ old('student_id') }}"
                                        class="input-field"
                                        placeholder="e.g. KNGC-18-1234"
                                    >
                                </div>

                                <div>
                                    <label for="batch" class="mb-1.5 block text-sm font-semibold text-navy-950">Batch</label>
                                    <input
                                        id="batch"
                                        type="text"
                                        name="batch"
                                        value="{{ old('batch') }}"
                                        class="input-field"
                                        placeholder="e.g. 2018-19"
                                    >
                                </div>

                                <div>
                                    <label for="graduation_year" class="mb-1.5 block text-sm font-semibold text-navy-950">Graduation Year</label>
                                    <input
                                        id="graduation_year"
                                        type="number"
                                        name="graduation_year"
                                        value="{{ old('graduation_year') }}"
                                        min="1960"
                                        max="{{ (int) date('Y') + 1 }}"
                                        class="input-field"
                                        placeholder="e.g. 2022"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 3: Alumni Proof Document --}}
                    <div class="mt-6 rounded-xl border border-navy-100 bg-white shadow-sm">
                        <div class="border-b border-navy-100 px-6 py-4 sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-navy-950 text-sm font-bold text-white">3</span>
                                <div>
                                    <h2 class="font-serif text-lg font-semibold text-navy-950">Alumni Proof Document</h2>
                                    <p class="text-xs text-ink-soft">Optional — upload to speed up verification.</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-6 sm:px-8">
                            <div
                                x-data="{ fileName: '', dragging: false }"
                                class="relative rounded-xl border-2 border-dashed transition-colors duration-200"
                                :class="dragging ? 'border-gold-500 bg-gold-500/5' : 'border-navy-200 bg-navy-50/30 hover:border-navy-300'"
                                @dragover.prevent="dragging = true"
                                @dragleave="dragging = false"
                                @drop.prevent="dragging = false; $refs.alumniDocInput.files = $event.dataTransfer.files; fileName = $event.dataTransfer.files[0].name"
                            >
                                <input
                                    type="file"
                                    id="alumni_document"
                                    name="alumni_document"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    x-ref="alumniDocInput"
                                    @change="fileName = $event.target.files[0]?.name || ''"
                                    class="absolute inset-0 z-10 w-full cursor-pointer opacity-0"
                                >
                                <div class="flex flex-col items-center justify-center px-6 py-10 text-center">
                                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-maroon-100">
                                        <svg class="h-7 w-7 text-maroon-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12l-3-3m0 0l-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                    </div>
                                    <p class="mt-3 text-sm font-medium text-navy-950">
                                        <span x-show="!fileName" class="text-maroon-600">Click to upload</span> or drag and drop
                                    </p>
                                    <p class="mt-1 text-xs text-ink-soft">PDF, JPG, or PNG — max 5 MB</p>
                                    <p x-show="fileName" x-cloak class="mt-3 inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-800">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <span x-text="fileName"></span>
                                    </p>
                                </div>
                            </div>
                            <p class="mt-3 text-xs text-ink-soft">Accepted documents: marksheet, transcript, degree certificate, or any official document proving your enrollment or graduation from KNGC.</p>
                        </div>
                    </div>

                    {{-- Section 4: Professional Information --}}
                    <div class="mt-6 rounded-xl border border-navy-100 bg-white shadow-sm">
                        <div class="border-b border-navy-100 px-6 py-4 sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-navy-950 text-sm font-bold text-white">4</span>
                                <div>
                                    <h2 class="font-serif text-lg font-semibold text-navy-950">Professional Information</h2>
                                    <p class="text-xs text-ink-soft">Your current career details (optional).</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-6 sm:px-8">
                            <div class="grid gap-5 sm:grid-cols-3">
                                <div>
                                    <label for="profession" class="mb-1.5 block text-sm font-semibold text-navy-950">Profession</label>
                                    <input
                                        id="profession"
                                        type="text"
                                        name="profession"
                                        value="{{ old('profession') }}"
                                        class="input-field"
                                        placeholder="e.g. Teacher, Engineer"
                                    >
                                </div>

                                <div>
                                    <label for="current_organization" class="mb-1.5 block text-sm font-semibold text-navy-950">Organization</label>
                                    <input
                                        id="current_organization"
                                        type="text"
                                        name="current_organization"
                                        value="{{ old('current_organization') }}"
                                        class="input-field"
                                        placeholder="Company or institution"
                                    >
                                </div>

                                <div>
                                    <label for="current_designation" class="mb-1.5 block text-sm font-semibold text-navy-950">Designation</label>
                                    <input
                                        id="current_designation"
                                        type="text"
                                        name="current_designation"
                                        value="{{ old('current_designation') }}"
                                        class="input-field"
                                        placeholder="Job title"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 5: Additional Information --}}
                    <div class="mt-6 rounded-xl border border-navy-100 bg-white shadow-sm">
                        <div class="border-b border-navy-100 px-6 py-4 sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-navy-950 text-sm font-bold text-white">5</span>
                                <div>
                                    <h2 class="font-serif text-lg font-semibold text-navy-950">Additional Information</h2>
                                    <p class="text-xs text-ink-soft">Anything else you'd like us to know.</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-6 sm:px-8">
                            <label for="application_message" class="mb-1.5 block text-sm font-semibold text-navy-950">Application Message</label>
                            <textarea
                                id="application_message"
                                name="application_message"
                                rows="4"
                                maxlength="5000"
                                class="input-field"
                                placeholder="Tell us why you'd like to join, or share any relevant information (optional)"
                            >{{ old('application_message') }}</textarea>
                            <div class="mt-1.5 flex items-center justify-between">
                                <p class="text-xs text-ink-soft">Max 5,000 characters</p>
                                <p x-data="{ count: {{ strlen(old('application_message', '')) }} }" class="text-xs text-ink-soft">
                                    <span x-text="count"></span>/5000
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="mt-8 rounded-xl border border-navy-100 bg-white px-6 py-5 shadow-sm sm:px-8">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <p class="max-w-md text-xs leading-relaxed text-ink-soft">
                                By submitting this application, you confirm that the information provided is accurate. Your data is kept confidential and used solely for membership evaluation purposes.
                            </p>
                            <button
                                type="submit"
                                :disabled="submitting"
                                class="focus-ring inline-flex shrink-0 items-center justify-center gap-2 rounded-md bg-gold-500 px-8 py-3 text-sm font-semibold text-navy-950 transition-colors hover:bg-gold-400 focus-visible:ring-gold-400 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <svg x-show="submitting" x-cloak class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span x-text="submitting ? 'Submitting...' : 'Submit Application'"></span>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
</x-layouts.app>
