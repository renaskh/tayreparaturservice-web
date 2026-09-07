<?php

namespace App\Http\Requests\Admin;

use App\Enums\Locale;
use App\Http\Requests\Admin\Concerns\ValidatesTranslations;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceTranslation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCatalogServiceRequest extends FormRequest
{
    use ValidatesTranslations;

    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [
            'service_category_id' => ['required', 'integer', Rule::exists(ServiceCategory::class, 'id')],
            'key' => ['required', 'string', 'max:80', 'alpha_dash', Rule::unique(Service::class, 'key')],
            'icon' => ['nullable', 'string', 'max:40'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['sometimes', 'boolean'],
            ...$this->translationRules([
                'name' => ['required', 'string', 'max:160'],
                'slug' => ['required', 'string', 'max:160'],
                'excerpt' => ['required', 'string', 'max:500'],
                'description' => ['required', 'string', 'max:20000'],
                'features' => ['nullable', 'string', 'max:8000'],
                'seo_title' => ['nullable', 'string', 'max:160'],
                'seo_description' => ['nullable', 'string', 'max:320'],
                'seo_keywords' => ['nullable', 'string', 'max:255'],
            ]),
        ];

        foreach (Locale::values() as $locale) {
            $rules['translations.'.$locale.'.slug'][] = Rule::unique(ServiceTranslation::class, 'slug')->where('locale', $locale);
        }

        return $rules;
    }
}
