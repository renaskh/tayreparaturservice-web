<?php

namespace App\Http\Requests\Admin;

use App\Enums\Locale;
use App\Http\Requests\Admin\Concerns\ValidatesTranslations;
use App\Models\ServiceCategory;
use App\Models\ServiceCategoryTranslation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceCategoryRequest extends FormRequest
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
        $category = $this->route('serviceCategory');

        if ($category instanceof ServiceCategory) {
            $category->loadMissing('translations');
        }
        $categoryId = $category instanceof ServiceCategory ? $category->id : null;

        $rules = [
            'key' => [
                'required',
                'string',
                'max:80',
                'alpha_dash',
                Rule::unique(ServiceCategory::class, 'key')->ignore($categoryId),
            ],
            'icon' => ['nullable', 'string', 'max:40'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['sometimes', 'boolean'],
            ...$this->translationRules([
                'name' => ['required', 'string', 'max:160'],
                'slug' => ['required', 'string', 'max:160'],
                'excerpt' => ['required', 'string', 'max:500'],
                'description' => ['required', 'string', 'max:20000'],
                'seo_title' => ['nullable', 'string', 'max:160'],
                'seo_description' => ['nullable', 'string', 'max:320'],
                'seo_keywords' => ['nullable', 'string', 'max:255'],
            ]),
        ];

        foreach (Locale::values() as $locale) {
            $translationId = $category instanceof ServiceCategory
                ? $category->translations->firstWhere('locale', $locale)?->id
                : null;

            $rules['translations.'.$locale.'.slug'][] = Rule::unique(ServiceCategoryTranslation::class, 'slug')
                ->where('locale', $locale)
                ->ignore($translationId);
        }

        return $rules;
    }
}
