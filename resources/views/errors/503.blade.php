<x-layouts.app title="Under Maintenance" description="The site is briefly unavailable for scheduled maintenance.">
    <section class="section-pad bg-white">
        <div class="container-page flex flex-col items-center py-16 text-center">
            <p class="font-serif text-7xl font-semibold text-navy-100 sm:text-9xl">503</p>
            <h1 class="mt-4 font-serif text-3xl font-semibold text-navy-950 sm:text-4xl">Under maintenance</h1>
            <p class="mt-4 max-w-md leading-relaxed text-ink-soft">
                We're performing scheduled maintenance to improve the site. We'll be back online shortly — thank you for your patience.
            </p>
            <div class="mt-9">
                <x-button href="{{ route('home') }}" variant="navy">Try Again Soon</x-button>
            </div>
        </div>
    </section>
</x-layouts.app>