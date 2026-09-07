@use('App\Support\Localization')
@use('App\Support\SiteMedia')

@php
    $translation = $service->translation();
    $features = $translation?->features ?? [];
@endphp

<x-layouts.site :title="$metaTitle" :description="$metaDescription" :canonical="$canonical">
    <x-page-header
        :eyebrow="$category->translated('name')"
        :title="$service->translated('name')"
        :lead="$service->translated('excerpt')"
        :image="SiteMedia::forCategory((string) $category->key)"
    >
        <nav class="mt-8 text-sm text-paper/55" aria-label="Breadcrumb">
            <ol class="flex flex-wrap gap-2">
                <li><a class="hover:text-paper" href="{{ Localization::route('services.index') }}">{{ __('nav.services') }}</a></li>
                <li aria-hidden="true">/</li>
                <li><a class="hover:text-paper" href="{{ Localization::route('services.category', ['serviceCategory' => $category->translated('slug')]) }}">{{ $category->translated('name') }}</a></li>
            </ol>
        </nav>
    </x-page-header>

    <article class="bg-paper">
        <div class="tay-shell grid gap-12 py-16 lg:grid-cols-[minmax(0,1.35fr)_minmax(18rem,0.65fr)] lg:py-24">
            <div>
                <div class="max-w-3xl space-y-5 text-lg leading-relaxed text-ink-soft">
                    @foreach (preg_split('/\n+/', (string) $service->translated('description')) as $paragraph)
                        @if (trim($paragraph) !== '')
                            <p>{{ $paragraph }}</p>
                        @endif
                    @endforeach
                </div>

                @if (is_array($features) && count($features) > 0)
                    <section class="mt-14">
                        <h2 class="text-xl font-semibold tracking-[-0.02em]">{{ __('pages.services.includes') }}</h2>
                        <ul class="mt-6 divide-y divide-line border-y border-line">
                            @foreach ($features as $feature)
                                <li class="flex gap-4 py-4 text-sm">
                                    <span class="mt-1 h-px w-6 shrink-0 bg-petrol" aria-hidden="true"></span>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                <section class="mt-14 grid gap-10 md:grid-cols-2">
                    <div>
                        <h2 class="text-lg font-semibold">{{ __('pages.services.for') }}</h2>
                        <p class="mt-3 text-sm leading-relaxed text-ink-soft">{{ __('pages.services.audience') }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold">{{ __('pages.services.value') }}</h2>
                        <p class="mt-3 text-sm leading-relaxed text-ink-soft">{{ __('pages.services.value_text') }}</p>
                    </div>
                </section>
            </div>

            <aside class="h-fit bg-ink px-6 py-8 text-paper">
                <p class="tay-kicker text-signal">{{ __('pages.services.how') }}</p>
                <p class="mt-4 text-sm leading-relaxed text-paper/70">{{ __('pages.services.how_text') }}</p>
                <x-button href="{{ Localization::route('contact.create') }}" variant="invert" class="mt-6 w-full">{{ __('pages.services.request') }}</x-button>
                <a class="mt-4 inline-block text-sm text-paper/55 transition hover:text-paper" href="{{ Localization::route('services.category', ['serviceCategory' => $category->translated('slug')]) }}">
                    {{ __('common.back_to_overview') }}
                </a>
            </aside>
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section class="bg-ink text-paper">
            <div class="tay-shell py-16 lg:py-20">
                <h2 class="text-2xl font-semibold tracking-[-0.02em]">{{ __('common.related_services') }}</h2>
                <div class="mt-8 divide-y divide-white/10 border-y border-white/10">
                    @foreach ($related as $item)
                        @php $itemTranslation = $item->translation(); @endphp
                        @continue(! $itemTranslation)
                        <a class="flex flex-col gap-2 py-6 transition hover:text-signal sm:flex-row sm:items-baseline sm:justify-between sm:gap-10" href="{{ Localization::route('services.show', ['serviceCategory' => $category->translated('slug'), 'service' => $itemTranslation->slug]) }}">
                            <span class="font-medium">{{ $itemTranslation->name }}</span>
                            <span class="max-w-xl text-sm text-paper/60">{{ $itemTranslation->excerpt }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.site>
