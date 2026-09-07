<?php

namespace App\Http\Requests;

use App\Models\Service;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, list<string|ValidationRule>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'company' => ['nullable', 'string', 'max:160'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'service_category_id' => [
                'nullable',
                'integer',
                Rule::exists('service_categories', 'id')->where('is_active', true),
            ],
            'service_id' => [
                'nullable',
                'integer',
                Rule::exists('services', 'id')->where('is_active', true),
            ],
            'message' => ['required', 'string', 'min:20', 'max:5000'],
            'privacy_consent' => ['accepted'],
            'website' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => __('contact.fields.name'),
            'company' => __('contact.fields.company'),
            'email' => __('contact.fields.email'),
            'phone' => __('contact.fields.phone'),
            'service_category_id' => __('contact.fields.category'),
            'service_id' => __('contact.fields.service'),
            'message' => __('contact.fields.message'),
            'privacy_consent' => __('contact.fields.privacy'),
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'privacy_consent.accepted' => __('contact.validation.privacy'),
            'message.min' => __('contact.validation.message_min'),
        ];
    }

    /**
     * @return list<callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($validator->errors()->hasAny(['service_id', 'service_category_id'])) {
                    return;
                }

                $serviceId = $this->integer('service_id');
                $categoryId = $this->integer('service_category_id');

                if ($serviceId === 0) {
                    return;
                }

                $service = Service::query()->find($serviceId);

                if ($service === null) {
                    return;
                }

                if ($categoryId !== 0 && $service->service_category_id !== $categoryId) {
                    $validator->errors()->add('service_id', __('contact.validation.service_mismatch'));
                }
            },
        ];
    }
}
