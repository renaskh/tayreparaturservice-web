<x-layouts.admin :title="__('admin.page_groups.'.$group)">
    <p class="mb-8">
        <a class="text-sm font-medium text-petrol underline-offset-4 hover:underline" href="{{ route('admin.pages.index') }}">{{ __('admin.back') }}</a>
    </p>

    <form method="POST" action="{{ route('admin.pages.update', $group) }}" class="space-y-10 border border-line bg-paper p-5 sm:p-8">
        @csrf
        @method('PUT')

        @foreach ($fields as $key => $locales)
            @php
                $encodedKey = str_replace('.', '|', $key);
            @endphp
            <fieldset class="space-y-6 border-t border-line pt-8">
                <legend class="font-medium">{{ $key }}</legend>
                @foreach ($locales as $locale => $value)
                    @php
                        $long = str_contains((string) $value, "\n") || mb_strlen((string) $value) > 80;
                    @endphp
                    @if ($long)
                        <x-admin.textarea
                            :name="'contents['.$locale.']['.$encodedKey.']'"
                            :old-key="'contents.'.$locale.'.'.$encodedKey"
                            :label="strtoupper($locale)"
                            :value="$value"
                            :rows="4"
                        />
                    @else
                        <x-admin.field
                            :name="'contents['.$locale.']['.$encodedKey.']'"
                            :old-key="'contents.'.$locale.'.'.$encodedKey"
                            :label="strtoupper($locale)"
                            :value="$value"
                        />
                    @endif
                @endforeach
            </fieldset>
        @endforeach

        <x-button>{{ __('admin.save') }}</x-button>
    </form>
</x-layouts.admin>
