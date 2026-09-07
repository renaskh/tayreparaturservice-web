@use('App\Support\Localization')
@use('App\Support\SiteMedia')

<x-layouts.site :title="$metaTitle" :description="$metaDescription" :canonical="$canonical">
    <x-page-header :eyebrow="__('pages.services.eyebrow')" :title="__('pages.services.title')" :lead="__('pages.services.lead')" image="infrastructure-servers" />

    <div class="bg-paper">
        @foreach ($categories as $category)
            @php
                $translation = $category->translation();
                $photo = SiteMedia::forCategory((string) $category->key);
            @endphp
            @continue(! $translation)
            <section class="border-b border-line">
                <div class="tay-shell grid gap-10 py-16 lg:grid-cols-12 lg:py-20">
                    <div class="lg:col-span-5" data-reveal>
                        <div class="relative mb-6 aspect-[16/10] overflow-hidden bg-ink">
                            @if ($photo)
                                <x-site-photo :name="$photo" decorative class="absolute inset-0" />
                            @else
                                <x-category-visual :name="$category->icon ?? 'layers'" class="h-full w-full" />
                            @endif
                        </div>
                        <p class="tay-kicker text-petrol">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</p>
                        <h2 class="mt-4 text-3xl font-semibold tracking-[-0.03em]">{{ $translation->name }}</h2>
                        <p class="mt-4 max-w-md text-ink-soft">{{ $translation->excerpt }}</p>
                        <a class="mt-6 inline-flex items-center gap-2 text-sm font-medium text-petrol transition hover:gap-3" href="{{ Localization::route('services.category', ['serviceCategory' => $translation->slug]) }}">
                            {{ __('home.services.explore') }}
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>
                    <ul class="divide-y divide-line border-y border-line lg:col-span-7">
                        @foreach ($category->services as $service)
                            @php $serviceTranslation = $service->translation(); @endphp
                            @continue(! $serviceTranslation)
                            <li>
                                <a class="group flex flex-col gap-2 py-5 transition duration-200 hover:bg-paper-2 sm:flex-row sm:items-baseline sm:justify-between sm:gap-8 sm:px-4" href="{{ Localization::route('services.show', ['serviceCategory' => $translation->slug, 'service' => $serviceTranslation->slug]) }}">
                                    <span class="font-medium tracking-tight group-hover:text-petrol">{{ $serviceTranslation->name }}</span>
                                    <span class="max-w-md text-sm text-ink-soft">{{ $serviceTranslation->excerpt }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
        @endforeach
    </div>
</x-layouts.site>
