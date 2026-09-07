<?php

namespace App\Http\Requests\Admin\Concerns;

use App\Enums\Locale;

trait ValidatesTranslations
{
    /**
     * @param  array<string, list<mixed>>  $fields
     * @return array<string, mixed>
     */
    protected function translationRules(array $fields): array
    {
        $rules = [
            'translations' => ['required', 'array'],
        ];

        foreach (Locale::values() as $locale) {
            $rules['translations.'.$locale] = ['required', 'array'];

            foreach ($fields as $name => $fieldRules) {
                $rules['translations.'.$locale.'.'.$name] = $fieldRules;
            }
        }

        return $rules;
    }
}
