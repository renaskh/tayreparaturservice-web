@use('App\Support\Localization')
@use('App\Support\Company')
@props([
    'title' => null,
    'description' => null,
    'canonical' => null,
    'robots' => 'index, follow',
])

@php
    $pageTitle = $title ?: __('seo.home.title');
    $pageDescription = $description ?: __('seo.home.description');
    $canonicalUrl = $canonical ?: url()->current();
    $alternates = $alternateUrls ?? [];
    $locale = $currentLocale ?? app()->getLocale();
    $navCategories = $navCategories ?? collect();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <x-seo
            :title="$pageTitle"
            :description="$pageDescription"
            :canonical="$canonicalUrl"
            :alternates="$alternates"
            :robots="$robots"
        />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-paper font-sans text-ink">
        <a href="#content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:bg-paper focus:px-4 focus:py-2 focus:text-ink">
            {{ __('common.skip') }}
        </a>

        <header class="sticky top-0 z-40 border-b border-white/10 bg-ink/95 text-paper backdrop-blur-md" data-site-header>
            <div class="tay-shell flex items-center justify-between gap-4 py-4">
                <a href="{{ Localization::route('home') }}" class="flex items-center gap-3">
                    <span class="flex h-9 w-9 items-center justify-center bg-paper text-[0.68rem] font-semibold tracking-[0.2em] text-ink">TAY</span>
                    <span class="leading-tight">
                        <span class="block text-sm font-semibold tracking-tight">{{ __('common.brand') }}</span>
                        <span class="hidden text-[0.7rem] tracking-[0.16em] text-paper/50 uppercase sm:block">{{ __('home.hero.eyebrow') }}</span>
                    </span>
                </a>

                <nav class="hidden items-center gap-7 text-sm font-medium lg:flex" aria-label="{{ __('nav.home') }}">
                    <a class="text-paper/65 transition duration-200 hover:text-paper" href="{{ Localization::route('home') }}">{{ __('nav.home') }}</a>
                    <a class="text-paper/65 transition duration-200 hover:text-paper" href="{{ Localization::route('services.index') }}">{{ __('nav.services') }}</a>
                    <a class="text-paper/65 transition duration-200 hover:text-paper" href="{{ Localization::route('business') }}">{{ __('nav.business') }}</a>
                    <a class="text-paper/65 transition duration-200 hover:text-paper" href="{{ Localization::route('about') }}">{{ __('nav.about') }}</a>
                    <a class="text-paper/65 transition duration-200 hover:text-paper" href="{{ Localization::route('faq') }}">{{ __('nav.faq') }}</a>
                    <a class="text-paper/65 transition duration-200 hover:text-paper" href="{{ Localization::route('contact.create') }}">{{ __('nav.contact') }}</a>
                </nav>

                <div class="flex items-center gap-3">
                    <x-language-switcher :alternates="$alternates" :current="$locale" inverted />
                    <span class="hidden sm:inline-flex">
                        <x-button href="{{ Localization::route('contact.create') }}" variant="invert">
                            {{ __('common.request_service') }}
                        </x-button>
                    </span>
                    <button
                        type="button"
                        class="inline-flex h-10 w-10 items-center justify-center border border-white/20 text-paper lg:hidden"
                        data-nav-toggle
                        aria-expanded="false"
                        aria-controls="mobile-nav"
                    >
                        <span class="sr-only">{{ __('common.menu') }}</span>
                        <x-icon name="menu" class="h-5 w-5" />
                    </button>
                </div>
            </div>

            <div id="mobile-nav" class="hidden border-t border-white/10 bg-ink lg:hidden" data-nav-panel>
                <nav class="tay-shell flex flex-col gap-1 py-5 text-base" aria-label="{{ __('common.menu') }}">
                    <a class="py-2 text-paper/80" href="{{ Localization::route('home') }}">{{ __('nav.home') }}</a>
                    <a class="py-2 text-paper/80" href="{{ Localization::route('services.index') }}">{{ __('nav.services') }}</a>
                    <a class="py-2 text-paper/80" href="{{ Localization::route('business') }}">{{ __('nav.business') }}</a>
                    <a class="py-2 text-paper/80" href="{{ Localization::route('about') }}">{{ __('nav.about') }}</a>
                    <a class="py-2 text-paper/80" href="{{ Localization::route('faq') }}">{{ __('nav.faq') }}</a>
                    <a class="py-2 text-paper/80" href="{{ Localization::route('contact.create') }}">{{ __('nav.contact') }}</a>
                    <x-button href="{{ Localization::route('contact.create') }}" variant="invert" class="mt-4">
                        {{ __('common.request_service') }}
                    </x-button>
                </nav>
            </div>
        </header>

        <main id="content">
            {{ $slot }}
        </main>

        <footer class="bg-ink text-paper">
            <div class="h-px bg-gradient-to-r from-transparent via-signal/50 to-transparent"></div>
            <div class="tay-shell grid gap-12 py-16 md:grid-cols-2 lg:grid-cols-4">
                <div class="space-y-4">
                    <p class="tay-kicker text-signal">{{ __('common.brand') }}</p>
                    <p class="max-w-xs text-sm leading-relaxed text-paper/65">{{ __('common.tagline') }}</p>
                    <dl class="space-y-1 text-sm text-paper/65">
                        @if (Company::has('email'))
                            <div>
                                <dt class="sr-only">{{ __('contact.fields.email') }}</dt>
                                <dd><a class="transition hover:text-paper" href="mailto:{{ Company::value('email') }}">{{ Company::value('email') }}</a></dd>
                            </div>
                        @endif
                        @if (Company::has('phone'))
                            <div>
                                <dt class="sr-only">{{ __('contact.fields.phone') }}</dt>
                                <dd><a class="transition hover:text-paper" href="{{ Company::telHref() }}">{{ Company::value('phone') }}</a></dd>
                            </div>
                        @endif
                    </dl>
                    <x-language-switcher :alternates="$alternates" :current="$locale" inverted />
                </div>

                <div>
                    <p class="mb-4 tay-kicker text-paper/40">{{ __('nav.footer_services') }}</p>
                    <ul class="space-y-2 text-sm text-paper/75">
                        @foreach ($navCategories as $category)
                            <li>
                                <a class="transition hover:text-paper" href="{{ Localization::route('services.category', ['serviceCategory' => $category->translated('slug')]) }}">
                                    {{ $category->translated('name') }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <p class="mb-4 tay-kicker text-paper/40">{{ __('nav.company') }}</p>
                    <ul class="space-y-2 text-sm text-paper/75">
                        <li><a class="transition hover:text-paper" href="{{ Localization::route('about') }}">{{ __('nav.about') }}</a></li>
                        <li><a class="transition hover:text-paper" href="{{ Localization::route('business') }}">{{ __('nav.business') }}</a></li>
                        <li><a class="transition hover:text-paper" href="{{ Localization::route('faq') }}">{{ __('nav.faq') }}</a></li>
                        <li><a class="transition hover:text-paper" href="{{ Localization::route('contact.create') }}">{{ __('nav.contact') }}</a></li>
                    </ul>
                </div>

                <div>
                    <p class="mb-4 tay-kicker text-paper/40">{{ __('nav.legal') }}</p>
                    <ul class="space-y-2 text-sm text-paper/75">
                        <li><a class="transition hover:text-paper" href="{{ Localization::route('legal.imprint') }}">{{ __('nav.imprint') }}</a></li>
                        <li><a class="transition hover:text-paper" href="{{ Localization::route('legal.privacy') }}">{{ __('nav.privacy') }}</a></li>
                        <li><a class="transition hover:text-paper" href="{{ Localization::route('legal.terms') }}">{{ __('nav.terms') }}</a></li>
                        <li><a class="transition hover:text-paper" href="{{ Localization::route('legal.withdrawal') }}">{{ __('nav.withdrawal') }}</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10">
                <div class="tay-shell flex flex-col gap-2 py-6 text-xs text-paper/40 lg:flex-row lg:items-center lg:justify-between">
                    <p>&copy; {{ now()->year }} {{ __('common.brand') }}. {{ __('nav.copyright') }}</p>
                    <p>{{ __('nav.disclaimer') }}</p>
                </div>
            </div>
        </footer>
    </body>
</html>
