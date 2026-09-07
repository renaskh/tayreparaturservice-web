@use('App\Support\Localization')

<x-layouts.site :title="$metaTitle" :description="$metaDescription" :canonical="$canonical">
    <x-page-header :eyebrow="__('pages.business.eyebrow')" :title="__('pages.business.title')" :lead="__('pages.business.lead')" image="engineering-lab" />

    <article class="bg-paper">
        <div class="tay-shell py-16 lg:py-24">
            <p class="max-w-3xl text-lg leading-relaxed text-ink-soft" data-reveal>{{ __('pages.business.intro') }}</p>
            <div class="relative mt-12 aspect-[21/9] min-h-[12rem] overflow-hidden bg-ink" data-reveal>
                <x-site-photo name="industrial-testing" class="absolute inset-0" />
            </div>

            <h2 class="tay-title mt-16">{{ __('pages.business.models_title') }}</h2>
            <div class="mt-10 divide-y divide-line border-y border-line">
                @foreach (__('pages.business.models') as $model)
                    <article class="grid gap-4 py-8 lg:grid-cols-[minmax(14rem,0.45fr)_minmax(0,1fr)] lg:py-10" data-reveal>
                        <h3 class="text-xl font-semibold tracking-[-0.02em]">{{ $model['title'] }}</h3>
                        <p class="text-sm leading-relaxed text-ink-soft sm:text-base">{{ $model['text'] }}</p>
                    </article>
                @endforeach
            </div>

            <p class="mt-12 max-w-3xl text-sm leading-relaxed text-ink-soft">{{ __('pages.business.note') }}</p>
            <x-button href="{{ Localization::route('contact.create') }}" class="mt-8">{{ __('common.contact_business') }}</x-button>
        </div>
    </article>
</x-layouts.site>
