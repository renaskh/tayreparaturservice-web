@props([
    'name',
    'eager' => false,
    'decorative' => false,
])

@php
    $media = \App\Support\SiteMedia::definition($name);
    $objectClass = match ($name) {
        'software-code' => 'object-[center_40%]',
        'technical-workstation' => 'object-[center_22%]',
        'industrial-testing' => 'object-[center_30%]',
        'source-code' => 'object-[center_40%]',
        'engineering-work' => 'object-[center_42%]',
        'workshop-tools' => 'object-[center_45%]',
        'workshop-planning' => 'object-[center_40%]',
        'business-dashboard' => 'object-[center_40%]',
        'code-review' => 'object-[center_40%]',
        'engineering-lab' => 'object-[center_35%]',
        'laptop-code' => 'object-[center_40%]',
        default => 'object-center',
    };
@endphp

@if ($media)
    <span {{ $attributes->merge(['class' => 'block h-full w-full overflow-hidden']) }}>
        <picture class="block h-full w-full">
            <source type="image/webp" srcset="{{ \App\Support\SiteMedia::webpUrl($name) }}">
            <img
                src="{{ \App\Support\SiteMedia::jpgUrl($name) }}"
                alt="{{ $decorative ? '' : __($media['alt']) }}"
                width="{{ $media['width'] }}"
                height="{{ $media['height'] }}"
                @if ($eager)
                    fetchpriority="high"
                @else
                    loading="lazy"
                @endif
                decoding="async"
                class="h-full w-full object-cover {{ $objectClass }}"
                @if ($decorative)
                    aria-hidden="true"
                @endif
            >
        </picture>
    </span>
@endif
