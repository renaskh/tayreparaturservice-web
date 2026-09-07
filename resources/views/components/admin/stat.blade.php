@props([
    'label',
    'value',
    'href' => null,
    'hint' => null,
    'icon' => 'layers',
])

@php
    $classes = 'flex h-full flex-col border border-line bg-paper p-5 transition duration-200';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes.' hover:border-petrol']) }}>
        <span class="flex items-center justify-between gap-3">
            <span class="tay-kicker text-ink-soft">{{ $label }}</span>
            <x-icon :name="$icon" class="h-4 w-4 text-ink-soft" />
        </span>
        <span class="mt-4 text-3xl font-semibold tracking-[-0.03em]">{{ $value }}</span>
        @if ($hint)
            <span class="mt-2 text-sm text-ink-soft">{{ $hint }}</span>
        @endif
    </a>
@else
    <article {{ $attributes->merge(['class' => $classes]) }}>
        <p class="flex items-center justify-between gap-3">
            <span class="tay-kicker text-ink-soft">{{ $label }}</span>
            <x-icon :name="$icon" class="h-4 w-4 text-ink-soft" />
        </p>
        <p class="mt-4 text-3xl font-semibold tracking-[-0.03em]">{{ $value }}</p>
        @if ($hint)
            <p class="mt-2 text-sm text-ink-soft">{{ $hint }}</p>
        @endif
    </article>
@endif
