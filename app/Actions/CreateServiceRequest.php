<?php

namespace App\Actions;

use App\Enums\Locale;
use App\Enums\ServiceRequestStatus;
use App\Mail\ServiceRequestReceived;
use App\Models\ServiceRequest;
use App\Support\Company;
use Illuminate\Support\Facades\Mail;

class CreateServiceRequest
{
    /**
     * @param  array{
     *     name: string,
     *     company?: string|null,
     *     email: string,
     *     phone?: string|null,
     *     service_category_id?: int|null,
     *     service_id?: int|null,
     *     message: string,
     *     locale: string
     * }  $data
     */
    public function handle(array $data): ServiceRequest
    {
        $request = ServiceRequest::query()->create([
            'name' => $data['name'],
            'company' => $data['company'] ?? null,
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'service_category_id' => $data['service_category_id'] ?? null,
            'service_id' => $data['service_id'] ?? null,
            'message' => $data['message'],
            'locale' => Locale::from($data['locale']),
            'status' => ServiceRequestStatus::New,
            'privacy_consent_at' => now(),
        ]);

        $notificationEmail = Company::value('email', '');

        if (filter_var($notificationEmail, FILTER_VALIDATE_EMAIL)) {
            Mail::to($notificationEmail)->send(new ServiceRequestReceived($request));
        }

        return $request;
    }
}
