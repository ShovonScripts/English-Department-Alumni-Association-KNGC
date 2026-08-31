<x-layouts.app title="Page Not Found" description="The page you were looking for could not be found.">
    <section class="section-pad bg-white">
        <div class="container-page flex flex-col items-center py-16 text-center">
            <p class="font-serif text-7xl font-semibold text-navy-100 sm:text-9xl">404</p>
            <h1 class="mt-4 font-serif text-3xl font-semibold text-navy-950 sm:text-4xl">Page not found</h1>
            <p class="mt-4 max-w-md leading-relaxed text-ink-soft">
                The page you were looking for doesn't exist, has moved, or never existed. Let's get you back on track.
            </p>
            <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                <x-button href="{{ route('home') }}" variant="navy" :icon="true">Back to Home</x-button>
                <x-button href="{{ route('contact') }}" variant="outline">Contact Us</x-button>
            </div>
        </div>
    </section>
</x-layouts.app>