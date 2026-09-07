@use('App\Support\Localization')
@use('App\Support\SiteMedia')

<x-layouts.site :title="$metaTitle" :description="$metaDescription" :canonical="$canonical">
    <x-page-header
        :eyebrow="__('pages.services.eyebrow')"
        :title="$category->translated('name')"
        :lead="$category->translated('excerpt')"
        :image="SiteMedia::forCategory((string) $category->key)"
    >
        <x-button href="{{ Localization::route('contact.create') }}" variant="invert" class="mt-8">{{ __('common.request_service') }}</x-button>
    </x-page-header>

    <article class="bg-paper">
        <div class="tay-shell grid gap-12 py-16 lg:grid-cols-[minmax(0,1.4fr)_minmax(18rem,0.7fr)] lg:py-24">
            <div class="max-w-3xl space-y-6 text-lg leading-relaxed text-ink-soft" data-reveal>
                @foreach (preg_split('/\n+/', (string) $category->translated('description')) as $paragraph)
                    @if (trim($paragraph) !== '')
                        <p>{{ $paragraph }}</p>
                    @endif
                @endforeach
            </div>
            <aside class="h-fit bg-ink px-6 py-8 text-paper" data-reveal>
                <p class="tay-kicker text-signal">{{ __('pages.services.how') }}</p>
                <p class="mt-4 text-sm leading-relaxed text-paper/70">{{ __('pages.services.how_text') }}</p>
                <x-button href="{{ Localization::route('contact.create') }}" variant="invert" class="mt-6 w-full">{{ __('pages.services.request') }}</x-button>
            </aside>
        </div>

        <div class="divide-y divide-line border-y border-line">
            @foreach ($services as $service)
                @php $translation = $service->translation(); @endphp
                @continue(! $translation)
                <a class="tay-shell group grid gap-4 py-8 transition duration-200 hover:bg-paper-2 lg:grid-cols-[minmax(12rem,0.4fr)_minmax(0,1fr)] lg:py-10" href="{{ Localization::route('services.show', ['serviceCategory' => $category->translated('slug'), 'service' => $translation->slug]) }}">
                    <h2 class="text-xl font-semibold tracking-[-0.02em] group-hover:text-petrol">{{ $translation->name }}</h2>
                    <p class="text-sm leading-relaxed text-ink-soft sm:text-base">{{ $translation->excerpt }}</p>
                </a>
            @endforeach
        </div>
    </article>
</x-layouts.site>
