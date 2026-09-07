@props([
    'status',
])

@php
    $classes = match ($status->value) {
        'new' => 'bg-accent-soft text-petrol',
        'in_review' => 'bg-paper-2 text-ink-soft',
        'contacted' => 'bg-ink text-signal',
        'in_progress' => 'bg-petrol text-paper',
        'completed' => 'bg-paper-2 text-ink',
        default => 'bg-line text-ink-soft',
    };
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2 py-0.5 text-[0.625rem] font-medium tracking-[0.14em] uppercase '.$classes]) }}>
    {{ $status->label() }}
</span>
