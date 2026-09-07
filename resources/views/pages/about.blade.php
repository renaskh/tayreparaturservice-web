@use('App\Support\Localization')

<x-layouts.site :title="$metaTitle" :description="$metaDescription" :canonical="$canonical">
    <x-page-header :eyebrow="__('pages.about.eyebrow')" :title="__('pages.about.title')" :lead="__('pages.about.lead')" image="circuit-glow" />

    <article class="bg-paper">
        <div class="tay-shell grid gap-16 py-16 lg:grid-cols-[minmax(0,1.25fr)_minmax(18rem,0.75fr)] lg:py-24">
            <div data-reveal>
                <div class="relative mb-10 aspect-[16/10] overflow-hidden bg-ink">
                    <x-site-photo name="technical-office" class="absolute inset-0" />
                </div>
                <div class="max-w-3xl space-y-6 text-lg leading-relaxed text-ink-soft">
                    @foreach (__('pages.about.body') as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>
            </div>
            <aside class="h-fit bg-ink px-6 py-8 text-paper" data-reveal>
                <h2 class="text-lg font-semibold tracking-[-0.02em]">{{ __('pages.about.focus_title') }}</h2>
                <ul class="mt-6 divide-y divide-white/10 border-y border-white/10 text-sm text-paper/70">
                    @foreach (__('pages.about.focus') as $item)
                        <li class="py-4">{{ $item }}</li>
                    @endforeach
                </ul>
                <x-button href="{{ Localization::route('contact.create') }}" variant="invert" class="mt-8 w-full">{{ __('common.request_service') }}</x-button>
            </aside>
        </div>
    </article>
</x-layouts.site>
