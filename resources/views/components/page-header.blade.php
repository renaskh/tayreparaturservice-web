@props([
    'eyebrow' => null,
    'title',
    'lead' => null,
    'image' => null,
])

<section class="relative overflow-hidden bg-ink text-paper">
    @if ($image)
        <div class="pointer-events-none absolute inset-0" aria-hidden="true">
            <x-site-photo :name="$image" decorative class="absolute inset-0 opacity-50" />
            <div class="absolute inset-0 bg-gradient-to-r from-ink via-ink/82 to-ink/55"></div>
        </div>
    @else
        <div class="pointer-events-none absolute inset-0 opacity-30" aria-hidden="true">
            <svg class="h-full w-full text-white" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="page-grid" width="56" height="56" patternUnits="userSpaceOnUse">
                        <path d="M56 0H0V56" fill="none" stroke="currentColor" stroke-width="0.6" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#page-grid)" />
            </svg>
        </div>
    @endif
    <div class="tay-shell relative py-16 sm:py-20 lg:py-24">
        @if ($eyebrow)
            <x-kicker invert>{{ $eyebrow }}</x-kicker>
        @endif
        <h1 class="tay-display mt-4 max-w-3xl">{{ $title }}</h1>
        @if ($lead)
            <p class="mt-5 max-w-2xl text-lg leading-relaxed text-paper/70">{{ $lead }}</p>
        @endif
        {{ $slot }}
    </div>
</section>
