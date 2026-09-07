@props([
    'name',
    'label',
    'type' => 'text',
    'value' => '',
    'oldKey' => null,
    'required' => false,
])

@php
    $oldKey ??= $name;
    $id = $attributes->get('id') ?? str_replace(['[', ']'], ['-', ''], $name);
@endphp

<div>
    <label for="{{ $id }}" class="text-sm font-medium">
        {{ $label }}
        @if ($required)
            <span class="text-petrol">*</span>
        @endif
    </label>
    <input
        id="{{ $id }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ $type === 'password' ? '' : old($oldKey, $value) }}"
        @required($required)
        {{ $attributes->except('id')->merge(['class' => 'tay-field']) }}
    >
    @error($oldKey)
        <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
    @enderror
</div>
