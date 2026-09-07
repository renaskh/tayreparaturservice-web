@props([
    'title',
    'text',
    'href',
    'kind' => 'tech',
    'photo' => null,
    'index' => 0,
])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'group relative flex min-h-[17rem] flex-col justify-end overflow-hidden bg-ink-mid px-6 py-7 sm:min-h-[20rem] sm:px-8 sm:py-8']) }} data-reveal style="--reveal-delay: {{ $index * 70 }}ms">
    @if ($photo)
        <x-site-photo :name="$photo" decorative class="pointer-events-none absolute inset-0 transition duration-700 group-hover:scale-[1.05]" />
    @else
        <x-industry-visual :kind="$kind" class="pointer-events-none absolute inset-0 h-full w-full transition duration-700 group-hover:scale-[1.05]" />
    @endif
    <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-ink via-ink/60 to-ink/10"></div>
    <div class="relative">
        <p class="tay-kicker text-signal/80">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</p>
        <h3 class="mt-4 text-2xl font-semibold tracking-[-0.03em] text-paper transition duration-200 group-hover:text-signal">{{ $title }}</h3>
        <p class="mt-3 max-w-md text-sm leading-relaxed text-paper/70">{{ $text }}</p>
    </div>
</a>
