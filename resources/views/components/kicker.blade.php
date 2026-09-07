@props([
    'invert' => false,
])

<p {{ $attributes->merge(['class' => 'tay-kicker '.($invert ? 'text-signal' : 'text-petrol')]) }}>
    {{ $slot }}
</p>
