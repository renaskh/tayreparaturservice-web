@use('App\Enums\Locale')

<form method="POST" action="{{ $action }}" class="max-w-3xl space-y-8 border border-line bg-paper p-5 sm:p-8">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <x-admin.field name="key" :label="__('admin.key')" :value="$faq?->key" required maxlength="80" />
    <x-admin.field name="sort_order" type="number" :label="__('admin.sort_order')" :value="$faq?->sort_order ?? 0" required min="0" max="9999" />

    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $faq?->is_active ?? true))>
        {{ __('admin.is_active') }}
    </label>

    @foreach (Locale::cases() as $locale)
        @php
            $translation = $faq?->translations?->firstWhere('locale', $locale->value);
        @endphp
        <fieldset class="space-y-6 border-t border-line pt-8">
            <legend class="text-lg font-semibold tracking-[-0.02em]">{{ $locale->label() }}</legend>
            <x-admin.field
                :name="'translations['.$locale->value.'][question]'"
                :old-key="'translations.'.$locale->value.'.question'"
                :label="__('admin.question')"
                :value="$translation?->question"
                required
                maxlength="255"
            />
            <x-admin.textarea
                :name="'translations['.$locale->value.'][answer]'"
                :old-key="'translations.'.$locale->value.'.answer'"
                :label="__('admin.answer')"
                :value="$translation?->answer"
                required
                :rows="8"
            />
        </fieldset>
    @endforeach

    <div class="flex flex-wrap gap-3">
        <x-button>{{ __('admin.save') }}</x-button>
        <x-button href="{{ route('admin.faqs.index') }}" variant="secondary">{{ __('admin.back') }}</x-button>
    </div>
</form>
