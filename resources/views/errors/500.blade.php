<x-layouts.app title="Server Error" description="Something went wrong on our side. Please try again shortly.">
    <section class="section-pad bg-white">
        <div class="container-page flex flex-col items-center py-16 text-center">
            <p class="font-serif text-7xl font-semibold text-navy-100 sm:text-9xl">500</p>
            <h1 class="mt-4 font-serif text-3xl font-semibold text-navy-950 sm:text-4xl">Something went wrong</h1>
            <p class="mt-4 max-w-md leading-relaxed text-ink-soft">
                We hit an unexpected error while preparing this page. Our team has been notified — please try again in a moment.
            </p>
            <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                <x-button href="{{ route('home') }}" variant="navy" :icon="true">Back to Home</x-button>
                <x-button href="{{ route('contact') }}" variant="outline">Report the Issue</x-button>
            </div>
        </div>
    </section>
</x-layouts.app>