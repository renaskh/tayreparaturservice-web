@props([
    'title',
])

@php
    $groups = [
        [
            'label' => __('admin.nav_operations'),
            'links' => [
                ['route' => 'admin.dashboard', 'label' => __('admin.dashboard'), 'icon' => 'layout'],
                ['route' => 'admin.requests.index', 'label' => __('admin.requests'), 'icon' => 'inbox'],
            ],
        ],
        [
            'label' => __('admin.nav_content'),
            'links' => [
                ['route' => 'admin.categories.index', 'label' => __('admin.categories'), 'icon' => 'layers'],
                ['route' => 'admin.services.index', 'label' => __('admin.services'), 'icon' => 'wrench'],
                ['route' => 'admin.faqs.index', 'label' => __('admin.faqs'), 'icon' => 'clipboard'],
                ['route' => 'admin.pages.index', 'label' => __('admin.pages'), 'icon' => 'file'],
            ],
        ],
        [
            'label' => __('admin.nav_settings'),
            'links' => [
                ['route' => 'admin.company.edit', 'label' => __('admin.company'), 'icon' => 'building'],
                ['route' => 'admin.account.edit', 'label' => __('admin.account'), 'icon' => 'user'],
            ],
        ],
    ];
    $adminUser = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex, nofollow">
        <title>{{ $title }} | {{ __('common.brand') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-paper-2 font-sans text-ink">
        <div class="fixed inset-0 z-40 hidden bg-ink/50 lg:hidden" data-nav-backdrop></div>
        <div class="lg:grid lg:min-h-screen lg:grid-cols-[17rem_minmax(0,1fr)]">
            <aside class="hidden flex-col bg-ink text-paper max-lg:fixed max-lg:inset-y-0 max-lg:left-0 max-lg:z-50 max-lg:w-72 lg:flex lg:min-h-screen" data-nav-panel>
                <div class="flex items-center justify-between gap-3 border-b border-white/10 px-5 py-5">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center bg-paper text-[0.68rem] font-semibold tracking-[0.2em] text-ink">TAY</span>
                        <span class="leading-tight">
                            <span class="block text-sm font-semibold tracking-tight">{{ __('common.brand') }}</span>
                            <span class="block text-[0.65rem] tracking-[0.18em] text-paper/45 uppercase">{{ __('admin.control_center') }}</span>
                        </span>
                    </a>
                    <button type="button" class="inline-flex h-8 w-8 items-center justify-center text-paper/60 lg:hidden" data-nav-toggle aria-expanded="false">
                        <span class="sr-only">{{ __('common.close') }}</span>
                        <x-icon name="close" class="h-4 w-4" />
                    </button>
                </div>

                <nav class="flex min-h-0 flex-1 flex-col gap-6 overflow-y-auto px-3 py-5 text-sm" aria-label="{{ __('admin.dashboard') }}">
                    @foreach ($groups as $group)
                        <div>
                            <p class="px-3 tay-kicker text-paper/35">{{ $group['label'] }}</p>
                            <div class="mt-2 flex flex-col gap-1">
                                @foreach ($group['links'] as $link)
                                    @php
                                        $wildcard = preg_replace('/\.(index|edit)$/', '.*', $link['route']) ?: $link['route'];
                                        $isActive = request()->routeIs($link['route'], $wildcard);
                                    @endphp
                                    <a
                                        href="{{ route($link['route']) }}"
                                        @if ($isActive) aria-current="page" @endif
                                        @class([
                                            'flex items-center gap-3 rounded-sm px-3 py-2 transition',
                                            'bg-paper/10 text-paper' => $isActive,
                                            'text-paper/70 hover:bg-paper/5 hover:text-paper' => ! $isActive,
                                        ])
                                    >
                                        <x-icon :name="$link['icon']" class="h-4 w-4 shrink-0" />
                                        <span>{{ $link['label'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </nav>

                <div class="mt-auto border-t border-white/10 px-5 py-4">
                    @if ($adminUser)
                        <p class="truncate text-sm font-medium">{{ $adminUser->name }}</p>
                        <p class="truncate text-xs text-paper/45">{{ $adminUser->email }}</p>
                    @endif
                    <div class="mt-4 flex items-center justify-between gap-3">
                        <a href="{{ url('/de') }}" class="text-xs text-paper/55 hover:text-paper">{{ __('admin.view_site') }}</a>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="text-xs text-paper/55 hover:text-paper">{{ __('admin.sign_out') }}</button>
                        </form>
                    </div>
                </div>
            </aside>

            <div class="flex min-w-0 flex-col">
                <header class="sticky top-0 z-30 flex items-center justify-between gap-3 border-b border-line bg-paper/90 px-5 py-4 backdrop-blur-md sm:px-8">
                    <div class="flex min-w-0 items-center gap-3">
                        <button
                            type="button"
                            class="inline-flex h-10 w-10 shrink-0 items-center justify-center border border-line bg-paper lg:hidden"
                            data-nav-toggle
                            aria-expanded="false"
                        >
                            <span class="sr-only">{{ __('common.menu') }}</span>
                            <x-icon name="menu" class="h-5 w-5" />
                        </button>
                        <div class="min-w-0">
                            <p class="tay-kicker text-ink-soft">{{ __('admin.control_center') }}</p>
                            <h1 class="truncate text-xl font-semibold tracking-[-0.03em] sm:text-2xl">{{ $title }}</h1>
                        </div>
                    </div>
                    <x-button href="{{ url('/de') }}" variant="secondary" class="hidden sm:inline-flex">{{ __('admin.view_site') }}</x-button>
                </header>
                <main class="flex-1 px-5 py-6 sm:px-8 sm:py-8">
                    @if (session('status'))
                        <p class="mb-6 border border-line bg-accent-soft px-4 py-3 text-sm">{{ session('status') }}</p>
                    @endif
                    @if ($errors->any())
                        <div class="mb-6 border border-line bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
                            <p class="font-medium">{{ __('admin.form_errors') }}</p>
                            <ul class="mt-2 list-disc space-y-1 pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
