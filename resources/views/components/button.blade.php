@props([
    'href' => null,
    'variant' => 'primary',
])

@php
    $classes = match ($variant) {
        'secondary' => 'inline-flex items-center justify-center border border-ink px-5 py-2.5 text-sm font-medium text-ink transition duration-200 hover:bg-ink hover:text-paper',
        'ghost' => 'inline-flex items-center justify-center gap-2 text-sm font-medium text-petrol underline-offset-4 transition duration-200 hover:underline',
        'invert' => 'inline-flex items-center justify-center bg-paper px-5 py-2.5 text-sm font-medium text-ink transition duration-200 hover:bg-signal',
        'outline-invert' => 'inline-flex items-center justify-center border border-paper/40 px-5 py-2.5 text-sm font-medium text-paper transition duration-200 hover:border-paper hover:bg-paper/10',
        default => 'inline-flex items-center justify-center bg-petrol px-5 py-2.5 text-sm font-medium text-white transition duration-200 hover:bg-petrol-strong',
    };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="submit" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
