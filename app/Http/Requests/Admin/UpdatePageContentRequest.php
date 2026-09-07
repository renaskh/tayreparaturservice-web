<?php

namespace App\Http\Requests\Admin;

use App\Enums\Locale;
use App\Support\SiteCopy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdatePageContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $localeRules = [];

        foreach (Locale::values() as $locale) {
            $localeRules['contents.'.$locale] = ['required', 'array'];
        }

        return [
            'contents' => ['required', 'array'],
            ...$localeRules,
            'contents.*.*' => ['nullable', 'string'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $group = $this->route('group');

            if (! is_string($group) || ! SiteCopy::isGroup($group)) {
                $validator->errors()->add('contents', __('admin.invalid_group'));
            }
        });
    }
}
