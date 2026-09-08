<x-layouts.app title="Contact" description="Get in touch with the English Department Alumni Association KNGC.">

    <x-page-header
        title="Contact Us"
        description="Questions, stories, or interest in joining the Association — we'd love to hear from you."
        eyebrow="Get in Touch"
        :breadcrumbs="[['label' => 'Contact']]"
    />

    <section class="section-pad bg-white">
        <div class="container-page grid gap-12 lg:grid-cols-5 lg:gap-16">
            {{-- Contact details --}}
            <div class="lg:col-span-2">
                <x-section-heading
                    eyebrow="Reach Us"
                    title="We respond within a few days"
                    description="Prefer email? Reach the executive committee directly at any time."
                />

                <ul class="mt-8 space-y-6">
                    <li class="flex items-start gap-4">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-navy-900 text-gold-300">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l9 6 9-6M4 5h16a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1z" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-semibold text-navy-950">Email</p>
                            <a href="mailto:{{ \App\Models\SiteSetting::get('contact_email') ?: config('site.email') }}" class="focus-ring rounded text-sm text-ink-soft transition-colors hover:text-maroon-700">
                                {{ \App\Models\SiteSetting::get('contact_email') ?: config('site.email') }}
                            </a>
                        </div>
                    </li>
                    <li class="flex items-start gap-4">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-navy-900 text-gold-300">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.3a1 1 0 011 .8l.8 3a1 1 0 01-.4 1l-1.6 1.2a12 12 0 005 5l1.2-1.6a1 1 0 011-.4l3 .8a1 1 0 01.8 1V19a2 2 0 01-2 2A16 16 0 013 5z" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-semibold text-navy-950">Phone</p>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', \App\Models\SiteSetting::get('contact_phone') ?: config('site.phone')) }}" class="focus-ring rounded text-sm text-ink-soft transition-colors hover:text-maroon-700">
                                {{ \App\Models\SiteSetting::get('contact_phone') ?: config('site.phone') }}
                            </a>
                        </div>
                    </li>
                    <li class="flex items-start gap-4">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-navy-900 text-gold-300">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.7 11.9l-6.8 6.9a2 2 0 01-2.8 0l-3-3a2 2 0 010-2.8l6.9-6.8M14.8 3.2L20.8 9.2m-2-2l-4.5 4.5a4 4 0 00-1 2.1l-.2 1.5a.5.5 0 00.6.6l1.5-.2a4 4 0 002.1-1l4.5-4.5a2 2 0 000-2.8l-2.5-2.5a2 2 0 00-2.8 0z" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-semibold text-navy-950">Address</p>
                            <p class="text-sm leading-relaxed text-ink-soft">{{ \App\Models\SiteSetting::get('contact_address') ?: config('site.address') }}</p>
                        </div>
                    </li>
                </ul>

                <div class="mt-8 rounded-lg bg-cream p-6">
                    <p class="text-sm font-semibold text-navy-950">Office Hours</p>
                    <p class="mt-1 text-sm text-ink-soft">Monday – Friday, 9:00 AM – 4:00 PM</p>
                </div>
            </div>

            {{-- Form --}}
            <div class="lg:col-span-3">
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)" x-transition class="mb-6 flex items-start gap-3 rounded-lg border border-green-200 bg-green-50 p-5 text-green-800" role="alert">
                        <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-semibold">Message sent</p>
                            <p class="mt-1 text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <div class="rounded-xl border border-navy-100 bg-white p-8 shadow-sm sm:p-10">
                    <h2 class="font-serif text-2xl font-semibold text-navy-950">Send us a message</h2>
                    <p class="mt-2 text-sm text-ink-soft">Fields marked with an asterisk (*) are required.</p>

                    <form method="POST" action="{{ route('contact.store') }}" class="mt-8 space-y-6" novalidate>
                        @csrf

                        <div class="absolute -left-[9999px]" aria-hidden="true">
                            <input type="text" name="website" tabindex="-1" autocomplete="off" value="">
                        </div>

                        <div class="grid gap-6 sm:grid-cols-2">
                            <div>
                                <label for="name" class="mb-1.5 block text-sm font-semibold text-navy-950">
                                    Full Name <span class="text-maroon-600" aria-hidden="true">*</span>
                                </label>
                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    autocomplete="name"
                                    placeholder="Jane Doe"
                                    class="focus-ring w-full rounded-md border px-4 py-2.5 text-sm {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-navy-200 bg-white' }}"
                                >
                                @error('name')
                                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="mb-1.5 block text-sm font-semibold text-navy-950">
                                    Email Address <span class="text-maroon-600" aria-hidden="true">*</span>
                                </label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    placeholder="jane@example.com"
                                    class="focus-ring w-full rounded-md border px-4 py-2.5 text-sm {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-navy-200 bg-white' }}"
                                >
                                @error('email')
                                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="mb-1.5 block text-sm font-semibold text-navy-950">
                                Subject <span class="text-maroon-600" aria-hidden="true">*</span>
                            </label>
                            <select
                                id="subject"
                                name="subject"
                                required
                                class="focus-ring w-full rounded-md border px-4 py-2.5 text-sm {{ $errors->has('subject') ? 'border-red-400 bg-red-50' : 'border-navy-200 bg-white' }}"
                            >
                                <option value="">Select a topic…</option>
                                @foreach ([
                                    'Membership enquiry',
                                    'Event question',
                                    'Share an alumni story',
                                    'Submit a publication',
                                    'Volunteering',
                                    'General question',
                                ] as $option)
                                    <option value="{{ $option }}" @selected(old('subject') === $option)>{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('subject')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="message" class="mb-1.5 block text-sm font-semibold text-navy-950">
                                Message <span class="text-maroon-600" aria-hidden="true">*</span>
                            </label>
                            <textarea
                                id="message"
                                name="message"
                                rows="6"
                                required
                                placeholder="Write your message here…"
                                class="focus-ring w-full rounded-md border px-4 py-2.5 text-sm {{ $errors->has('message') ? 'border-red-400 bg-red-50' : 'border-navy-200 bg-white' }}"
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                            <x-button type="submit" variant="maroon" size="lg" :icon="true">
                                Send Message
                            </x-button>
                            <p class="text-xs text-ink-soft">
                                We'll never share your details. Read our privacy policy for more.
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- Map --}}
    <section class="bg-cream py-14 sm:py-16">
        <div class="container-page">
            <div class="overflow-hidden rounded-xl border border-navy-100 shadow-sm">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d280.9356689526077!2d90.4130499278282!3d23.709710031672397!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b983c2cf0e3b%3A0xca6aab08df5b2a9f!2sDepartment%20of%20English%2C%20Kabi%20Nazrul%20Govt%20College.!5e1!3m2!1sen!2sbd!4v1788756987967!5m2!1sen!2sbd"
                    width="100%"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="strict-origin-when-cross-origin"
                    title="Department of English, Kabi Nazrul Govt. College"
                ></iframe>
            </div>
        </div>
    </section>

</x-layouts.app>