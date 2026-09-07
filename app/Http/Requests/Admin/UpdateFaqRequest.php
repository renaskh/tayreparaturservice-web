<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Concerns\ValidatesTranslations;
use App\Models\Faq;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFaqRequest extends FormRequest
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
        $faq = $this->route('faq');

        return [
            'key' => [
                'required',
                'string',
                'max:80',
                'alpha_dash',
                Rule::unique(Faq::class, 'key')->ignore($faq instanceof Faq ? $faq->id : null),
            ],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['sometimes', 'boolean'],
            ...$this->translationRules([
                'question' => ['required', 'string', 'max:255'],
                'answer' => ['required', 'string', 'max:8000'],
            ]),
        ];
    }
}
