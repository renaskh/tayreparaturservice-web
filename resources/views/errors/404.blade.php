@use('App\Support\Localization')

<x-layouts.site :title="$metaTitle ?? __('seo.not_found.title')" :description="$metaDescription ?? __('seo.not_found.description')" :canonical="$canonical ?? url()->current()" robots="noindex, follow">
    <section class="bg-ink text-paper">
        <div class="tay-shell py-28">
            <p class="tay-kicker text-signal">404</p>
            <h1 class="tay-display mt-5 max-w-2xl">{{ __('common.not_found.title') }}</h1>
            <p class="mt-5 max-w-xl text-lg text-paper/65">{{ __('common.not_found.lead') }}</p>
            <div class="mt-10 flex flex-col gap-3 sm:flex-row">
                <x-button href="{{ Localization::route('home') }}" variant="invert">{{ __('common.not_found.home') }}</x-button>
                <x-button href="{{ Localization::route('contact.create') }}" variant="outline-invert">{{ __('common.not_found.contact') }}</x-button>
            </div>
        </div>
    </section>
</x-layouts.site>
