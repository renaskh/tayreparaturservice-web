<?php

namespace App\Http\Requests\Admin;

use App\Support\Company;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, list<string|ValidationRule>>
     */
    public function rules(): array
    {
        $rules = [];

        foreach (Company::keys() as $key) {
            $rules[$key] = ['nullable', 'string', 'max:255'];
        }

        $rules['email'] = ['nullable', 'email:rfc', 'max:255'];
        $rules['website'] = ['nullable', 'url', 'max:255'];

        return $rules;
    }
}
