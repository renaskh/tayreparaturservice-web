@use('App\Support\Localization')
@props([
    'category',
])

@php
    $translation = $category->translation();
@endphp

@if ($translation)
    <article class="group relative flex h-full flex-col border border-line bg-white p-6 transition hover:border-accent">
        <div class="mb-5 flex h-11 w-11 items-center justify-center border border-line bg-paper-2 text-accent">
            <x-icon :name="$category->icon ?? 'layers'" />
        </div>
        <h3 class="text-lg font-semibold tracking-tight">
            <a class="after:absolute after:inset-0" href="{{ Localization::route('services.category', ['serviceCategory' => $translation->slug]) }}">
                {{ $translation->name }}
            </a>
        </h3>
        <p class="mt-3 flex-1 text-sm leading-relaxed text-ink-soft">{{ $translation->excerpt }}</p>
        <p class="mt-5 text-sm font-medium text-accent">{{ __('common.learn_more') }}</p>
    </article>
@endif
