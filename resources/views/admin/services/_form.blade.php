@use('App\Actions\SyncTranslations')
@use('App\Enums\Locale')

<form method="POST" action="{{ $action }}" class="max-w-3xl space-y-8 border border-line bg-paper p-5 sm:p-8">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div>
        <label for="service_category_id" class="text-sm font-medium">{{ __('admin.category') }} <span class="text-petrol">*</span></label>
        <select id="service_category_id" name="service_category_id" required class="tay-field">
            <option value="">{{ __('admin.unspecified') }}</option>
            @foreach ($categories as $categoryOption)
                <option value="{{ $categoryOption->id }}" @selected((string) old('service_category_id', $service?->service_category_id) === (string) $categoryOption->id)>
                    {{ $categoryOption->translated('name', 'de', $categoryOption->key) }}
                </option>
            @endforeach
        </select>
        @error('service_category_id')
            <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
        @enderror
    </div>

    <x-admin.field name="key" :label="__('admin.key')" :value="$service?->key" required maxlength="80" />
    <x-admin.field name="icon" :label="__('admin.icon')" :value="$service?->icon" maxlength="40" />
    <x-admin.field name="sort_order" type="number" :label="__('admin.sort_order')" :value="$service?->sort_order ?? 0" required min="0" max="9999" />

    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $service?->is_active ?? true))>
        {{ __('admin.is_active') }}
    </label>

    @foreach (Locale::cases() as $locale)
        @php
            $translation = $service?->translations?->firstWhere('locale', $locale->value);
        @endphp
        <fieldset class="space-y-6 border-t border-line pt-8">
            <legend class="text-lg font-semibold tracking-[-0.02em]">{{ $locale->label() }}</legend>
            <x-admin.field
                :name="'translations['.$locale->value.'][name]'"
                :old-key="'translations.'.$locale->value.'.name'"
                :label="__('admin.name')"
                :value="$translation?->name"
                required
                maxlength="160"
            />
            <x-admin.field
                :name="'translations['.$locale->value.'][slug]'"
                :old-key="'translations.'.$locale->value.'.slug'"
                :label="__('admin.slug')"
                :value="$translation?->slug"
                required
                maxlength="160"
            />
            <x-admin.textarea
                :name="'translations['.$locale->value.'][excerpt]'"
                :old-key="'translations.'.$locale->value.'.excerpt'"
                :label="__('admin.excerpt')"
                :value="$translation?->excerpt"
                required
                :rows="3"
            />
            <x-admin.textarea
                :name="'translations['.$locale->value.'][description]'"
                :old-key="'translations.'.$locale->value.'.description'"
                :label="__('admin.description')"
                :value="$translation?->description"
                required
                :rows="8"
            />
            <x-admin.textarea
                :name="'translations['.$locale->value.'][features]'"
                :old-key="'translations.'.$locale->value.'.features'"
                :label="__('admin.features')"
                :value="SyncTranslations::textarea($translation?->features)"
                :rows="6"
            />
            <x-admin.field
                :name="'translations['.$locale->value.'][seo_title]'"
                :old-key="'translations.'.$locale->value.'.seo_title'"
                :label="__('admin.seo_title')"
                :value="$translation?->seo_title"
                maxlength="160"
            />
            <x-admin.textarea
                :name="'translations['.$locale->value.'][seo_description]'"
                :old-key="'translations.'.$locale->value.'.seo_description'"
                :label="__('admin.seo_description')"
                :value="$translation?->seo_description"
                :rows="3"
            />
            <x-admin.field
                :name="'translations['.$locale->value.'][seo_keywords]'"
                :old-key="'translations.'.$locale->value.'.seo_keywords'"
                :label="__('admin.seo_keywords')"
                :value="$translation?->seo_keywords"
                maxlength="255"
            />
        </fieldset>
    @endforeach

    <div class="flex flex-wrap gap-3">
        <x-button>{{ __('admin.save') }}</x-button>
        <x-button href="{{ route('admin.services.index') }}" variant="secondary">{{ __('admin.back') }}</x-button>
    </div>
</form>
