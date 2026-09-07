@props([
    'name',
    'label',
    'value' => '',
    'oldKey' => null,
    'required' => false,
    'rows' => 6,
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
    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        @required($required)
        {{ $attributes->except('id')->merge(['class' => 'tay-field']) }}
    >{{ old($oldKey, $value) }}</textarea>
    @error($oldKey)
        <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
    @enderror
</div>
