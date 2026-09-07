@use('App\Support\Localization')
@use('App\Support\SiteMedia')

@props([
    'category',
    'index' => 0,
])

@php
    $translation = $category->translation();
    $reversed = $index % 2 === 1;
    $count = $category->services->count();
    $photo = SiteMedia::forCategory((string) $category->key);
@endphp

@if ($translation)
    <article {{ $attributes->merge(['class' => 'group relative overflow-hidden bg-ink']) }} data-reveal>
        <div class="tay-service-frame lg:w-1/2 {{ $reversed ? 'lg:ml-auto' : '' }}">
            @if ($photo)
                <x-site-photo :name="$photo" decorative class="absolute inset-0 transition duration-700 group-hover:scale-[1.03]" />
            @else
                <x-category-visual :name="$category->icon ?? 'layers'" class="absolute inset-0 h-full w-full" />
            @endif
            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-ink/55 via-ink/10 to-transparent"></div>
        </div>
        <div class="flex flex-col justify-center px-5 py-10 sm:px-6 sm:py-12 lg:absolute lg:inset-y-0 lg:w-1/2 lg:px-10 lg:py-8 xl:px-16 xl:py-10 {{ $reversed ? 'lg:left-0' : 'lg:right-0' }}">
            <p class="tay-kicker text-signal/80">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }} / {{ strtoupper($category->key) }}</p>
            <h3 class="mt-4 text-2xl font-semibold tracking-[-0.03em] text-paper xl:mt-5 xl:text-3xl">
                <a class="transition duration-200 hover:text-signal" href="{{ Localization::route('services.category', ['serviceCategory' => $translation->slug]) }}">
                    {{ $translation->name }}
                </a>
            </h3>
            <p class="mt-3 max-w-xl text-sm leading-relaxed text-paper/70 xl:mt-4 xl:text-base">{{ $translation->excerpt }}</p>
            <div class="mt-6 flex flex-wrap items-center gap-x-8 gap-y-3 text-sm xl:mt-8">
                <p class="tabular-nums tracking-wide text-paper/50">{{ __('home.services.count', ['count' => $count]) }}</p>
                <a class="inline-flex items-center gap-2 font-medium text-signal transition duration-200 group-hover:gap-3" href="{{ Localization::route('services.category', ['serviceCategory' => $translation->slug]) }}">
                    {{ __('home.services.explore') }}
                    <span aria-hidden="true">→</span>
                </a>
            </div>
        </div>
    </article>
@endif
