@use('App\Support\Localization')
@use('App\Support\SiteMedia')

@php
    $categoryUrl = function (string $key) use ($categories): string {
        $category = $categories->firstWhere('key', $key);
        $slug = $category?->translated('slug');

        if (! is_string($slug) || $slug === '') {
            return Localization::route('business');
        }

        return Localization::route('services.category', ['serviceCategory' => $slug]);
    };

    $serviceUrl = function (string $key) use ($categories, $categoryUrl): string {
        foreach ($categories as $category) {
            $service = $category->services->firstWhere('key', $key);
            $serviceSlug = $service?->translated('slug');
            $categorySlug = $category->translated('slug');

            if (is_string($serviceSlug) && $serviceSlug !== '' && is_string($categorySlug) && $categorySlug !== '') {
                return Localization::route('services.show', [
                    'serviceCategory' => $categorySlug,
                    'service' => $serviceSlug,
                ]);
            }
        }

        return $categoryUrl('software-it');
    };
@endphp

<x-layouts.site :title="$metaTitle" :description="$metaDescription" :canonical="$canonical">
    <section class="relative overflow-hidden bg-ink text-paper">
        <div class="tay-shell grid items-stretch lg:grid-cols-[minmax(0,0.92fr)_minmax(0,1.08fr)]">
            <div class="relative z-10 flex flex-col justify-center py-16 sm:py-20 lg:py-28">
                <x-kicker invert>{{ __('home.hero.eyebrow') }}</x-kicker>
                <h1 class="tay-display mt-6 max-w-xl">{{ __('home.hero.title') }}</h1>
                <p class="mt-6 max-w-lg text-lg font-medium text-signal">{{ __('home.hero.value') }}</p>
                <p class="mt-4 max-w-lg text-base leading-relaxed text-paper/70 sm:text-lg">{{ __('home.hero.lead') }}</p>
                <p class="mt-5 text-sm text-paper/55">{{ __('home.hero.trust') }}</p>
                <div class="mt-10 flex flex-col gap-3 sm:flex-row">
                    <x-button href="{{ Localization::route('contact.create') }}" variant="invert">{{ __('common.request_service') }}</x-button>
                    <x-button href="{{ Localization::route('services.index') }}" variant="outline-invert">{{ __('common.our_services') }}</x-button>
                </div>
            </div>
            <div class="relative -mx-5 min-h-[18rem] sm:-mx-6 lg:mx-0 lg:min-h-full">
                <x-hero-visual />
            </div>
        </div>
        <div class="border-t border-white/10">
            <p class="tay-shell py-4 text-[0.6875rem] font-medium tracking-[0.22em] text-paper/45 uppercase">{{ __('home.hero.domains') }}</p>
        </div>
    </section>

    <section class="bg-paper">
        <div class="tay-shell grid items-center gap-10 py-20 lg:grid-cols-[minmax(0,0.92fr)_minmax(0,1.08fr)] lg:gap-16 lg:py-28">
            <div data-reveal>
                <h2 class="tay-title max-w-md">{{ __('home.intro.title') }}</h2>
                <p class="mt-6 max-w-2xl text-lg leading-relaxed text-ink-soft">{{ __('home.intro.text') }}</p>
            </div>
            <div class="relative aspect-[3/2] overflow-hidden bg-ink lg:aspect-auto lg:min-h-[22rem]" data-reveal style="--reveal-delay: 80ms">
                <x-site-photo name="technical-office" class="absolute inset-0" />
            </div>
        </div>
    </section>

    <section class="bg-paper-2">
        <div class="tay-shell py-20 lg:py-28">
            <div class="max-w-2xl" data-reveal>
                <x-kicker>{{ __('home.development.eyebrow') }}</x-kicker>
                <h2 class="tay-title mt-5">{{ __('home.development.title') }}</h2>
                <p class="mt-4 text-ink-soft">{{ __('home.development.lead') }}</p>
            </div>
            <ul class="mt-14 grid gap-px bg-line sm:grid-cols-2 lg:grid-cols-3">
                @foreach (__('home.development.items') as $item)
                    <li data-reveal style="--reveal-delay: {{ $loop->index * 50 }}ms">
                        <a href="{{ $serviceUrl($item['service']) }}" class="group flex h-full flex-col bg-paper-2 px-6 py-8 transition duration-200 hover:bg-paper sm:px-8">
                            <div class="flex items-baseline justify-between gap-4">
                                <span class="tabular-nums text-sm text-petrol">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="tay-kicker text-ink-soft/60">{{ $item['code'] }}</span>
                            </div>
                            <h3 class="mt-8 text-xl font-semibold tracking-[-0.02em] transition duration-200 group-hover:text-petrol">{{ $item['title'] }}</h3>
                            <p class="mt-3 grow text-sm leading-relaxed text-ink-soft">{{ $item['text'] }}</p>
                            <span class="mt-6 text-sm font-medium text-petrol underline-offset-4 group-hover:underline">{{ __('home.development.explore') }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <section class="bg-ink text-paper">
        <div class="tay-shell py-20 lg:py-28">
            <div class="grid items-center gap-10 lg:grid-cols-[minmax(0,0.92fr)_minmax(0,1.08fr)] lg:gap-16">
                <div class="max-w-2xl" data-reveal>
                    <x-kicker invert>{{ __('home.capabilities.eyebrow') }}</x-kicker>
                    <h2 class="tay-title mt-5">{{ __('home.capabilities.title') }}</h2>
                    <p class="mt-4 text-paper/65">{{ __('home.capabilities.lead') }}</p>
                </div>
                <div class="relative aspect-[3/2] overflow-hidden bg-ink-mid lg:aspect-auto lg:min-h-[18rem]" data-reveal style="--reveal-delay: 80ms">
                    <x-site-photo name="motherboard-detail" class="absolute inset-0" />
                </div>
            </div>
            <ul class="mt-14 grid sm:grid-cols-2 lg:grid-cols-4">
                @foreach (__('home.capabilities.items') as $item)
                    <li class="group border-t border-white/10 py-8 sm:px-6 lg:px-8" data-reveal style="--reveal-delay: {{ $loop->index * 50 }}ms">
                        <div class="flex items-baseline justify-between gap-4">
                            <span class="tabular-nums text-sm text-signal/80">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="tay-kicker text-paper/35">{{ $item['code'] }}</span>
                        </div>
                        <h3 class="mt-8 text-xl font-semibold tracking-[-0.02em]">{{ $item['title'] }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-paper/60">{{ $item['text'] }}</p>
                        <span class="mt-8 block h-px w-8 bg-signal/50 transition duration-300 group-hover:w-16" aria-hidden="true"></span>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <section class="bg-paper-2">
        <div class="tay-shell flex flex-col justify-between gap-8 py-16 lg:flex-row lg:items-end lg:py-20">
            <div class="max-w-2xl" data-reveal>
                <x-kicker>{{ __('nav.services') }}</x-kicker>
                <h2 class="tay-title mt-4">{{ __('home.services.title') }}</h2>
                <p class="mt-4 text-ink-soft">{{ __('home.services.lead') }}</p>
            </div>
            <x-button href="{{ Localization::route('services.index') }}" variant="secondary">{{ __('common.all_services') }}</x-button>
        </div>
        <div class="flex flex-col overflow-x-hidden bg-ink">
            @foreach ($categories as $category)
                <x-service-panel :category="$category" :index="$loop->index" />
            @endforeach
        </div>
    </section>

    <section class="bg-ink text-paper">
        <div class="tay-shell py-20 lg:py-28">
            <div class="max-w-2xl" data-reveal>
                <x-kicker invert>{{ __('home.industries.eyebrow') }}</x-kicker>
                <h2 class="tay-title mt-5">{{ __('home.industries.title') }}</h2>
                <p class="mt-4 text-paper/65">{{ __('home.industries.lead') }}</p>
            </div>
            <div class="mt-14 grid gap-px bg-white/10 sm:grid-cols-2 xl:grid-cols-3">
                @foreach (__('home.industries.items') as $item)
                    @php
                        $href = $item['link'] === 'business'
                            ? Localization::route('business')
                            : $categoryUrl($item['link']);
                    @endphp
                    <x-industry-panel
                        :title="$item['title']"
                        :text="$item['text']"
                        :href="$href"
                        :kind="$item['kind']"
                        :photo="SiteMedia::forIndustry($item['kind'])"
                        :index="$loop->index"
                    />
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-paper">
        <div class="tay-shell py-20 lg:py-28">
            <div class="grid items-center gap-10 lg:grid-cols-[minmax(0,0.92fr)_minmax(0,1.08fr)] lg:gap-16">
                <div class="max-w-2xl" data-reveal>
                    <x-kicker>{{ __('common.process.eyebrow') }}</x-kicker>
                    <h2 class="tay-title mt-5">{{ __('common.process.title') }}</h2>
                    <p class="mt-4 text-ink-soft">{{ __('common.process.lead') }}</p>
                </div>
                <div class="relative aspect-[3/2] overflow-hidden bg-ink lg:aspect-auto lg:min-h-[18rem]" data-reveal style="--reveal-delay: 80ms">
                    <x-site-photo name="workshop-planning" class="absolute inset-0" />
                </div>
            </div>
            <ol class="relative mt-16 grid gap-10 lg:grid-cols-5 lg:gap-6">
                <span class="pointer-events-none absolute top-5 right-[10%] left-[10%] hidden h-px bg-line lg:block" aria-hidden="true"></span>
                @foreach (__('common.process.steps') as $index => $step)
                    <li class="relative" data-reveal style="--reveal-delay: {{ $index * 70 }}ms">
                        <span class="relative z-10 flex h-10 w-10 items-center justify-center bg-petrol text-xs font-medium text-white tabular-nums">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                        <h3 class="mt-5 text-lg font-semibold tracking-[-0.02em]">{{ $step['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-ink-soft">{{ $step['text'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <section class="bg-ink text-paper">
        <div class="tay-shell py-20 lg:py-28">
            <div class="max-w-2xl" data-reveal>
                <x-kicker invert>{{ __('home.principles.eyebrow') }}</x-kicker>
                <h2 class="tay-title mt-5">{{ __('home.principles.title') }}</h2>
                <p class="mt-4 text-paper/65">{{ __('home.principles.lead') }}</p>
            </div>
            <div class="mt-16 divide-y divide-white/10 border-y border-white/10">
                @foreach (__('home.principles.items') as $item)
                    <article class="grid gap-4 py-8 lg:grid-cols-[5.5rem_minmax(14rem,0.7fr)_minmax(0,1.2fr)] lg:items-baseline lg:gap-10 lg:py-10" data-reveal>
                        <p class="tabular-nums text-signal/80">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</p>
                        <h3 class="text-xl font-semibold tracking-[-0.02em]">{{ $item['title'] }}</h3>
                        <p class="text-sm leading-relaxed text-paper/65 sm:text-base">{{ $item['text'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    @if ($faqs->isNotEmpty())
        <section class="bg-paper">
            <div class="tay-shell py-20 lg:py-28">
                <div class="flex flex-col justify-between gap-6 lg:flex-row">
                    <div class="max-w-xl" data-reveal>
                        <x-kicker>{{ __('nav.faq') }}</x-kicker>
                        <h2 class="tay-title mt-4">{{ __('pages.faq.title') }}</h2>
                        <p class="mt-4 text-ink-soft">{{ __('pages.faq.lead') }}</p>
                    </div>
                    <x-button href="{{ Localization::route('faq') }}" variant="secondary">{{ __('nav.faq') }}</x-button>
                </div>
                <div class="mt-12 max-w-3xl">
                    @foreach ($faqs as $faq)
                        @if ($faq->translation())
                            <x-faq-item :question="$faq->translated('question')" :answer="$faq->translated('answer')" />
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="bg-petrol text-paper">
        <div class="tay-shell flex flex-col gap-8 py-16 lg:flex-row lg:items-center lg:justify-between lg:py-20">
            <div class="max-w-xl" data-reveal>
                <h2 class="tay-title">{{ __('home.cta.title') }}</h2>
                <p class="mt-4 text-paper/75">{{ __('home.cta.text') }}</p>
            </div>
            <x-button href="{{ Localization::route('contact.create') }}" variant="invert">
                {{ __('common.request_service') }}
            </x-button>
        </div>
    </section>
</x-layouts.site>
