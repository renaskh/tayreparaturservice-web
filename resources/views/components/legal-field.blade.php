@use('App\Support\Company')
@props([
    'label',
    'key',
])

@if (Company::has($key))
    <div class="border-b border-line py-4">
        <dt class="text-xs font-semibold tracking-[0.18em] text-ink-soft uppercase">{{ $label }}</dt>
        <dd class="mt-1">{{ Company::value($key) }}</dd>
    </div>
@endif
