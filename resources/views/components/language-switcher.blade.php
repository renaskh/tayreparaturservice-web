@use('App\Support\Localization')
@props([
    'alternates' => [],
    'current' => null,
    'inverted' => false,
])

@php
    $currentLocale = $current ?: app()->getLocale();
    $textClass = $inverted ? 'text-paper/70 hover:text-paper' : 'text-ink-soft hover:text-ink';
    $activeClass = $inverted ? 'text-paper' : 'text-ink';
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center gap-2 text-xs font-medium tracking-wide uppercase']) }} role="navigation" aria-label="{{ __('common.language') }}">
    @foreach (Localization::supported() as $locale)
        @php
            $href = $alternates[$locale] ?? Localization::route('home', [], $locale);
            $isCurrent = $locale === $currentLocale;
        @endphp
        <a
            href="{{ $href }}"
            hreflang="{{ $locale }}"
            lang="{{ $locale }}"
            class="{{ $isCurrent ? $activeClass.' underline underline-offset-4' : $textClass }}"
            @if ($isCurrent) aria-current="true" @endif
        >
            {{ config('localization.names.'.$locale) }}
        </a>
        @if (! $loop->last)
            <span class="{{ $inverted ? 'text-paper/30' : 'text-line' }}" aria-hidden="true">/</span>
        @endif
    @endforeach
</div>
