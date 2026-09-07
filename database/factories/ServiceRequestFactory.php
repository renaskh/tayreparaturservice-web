<?php

namespace Database\Factories;

use App\Enums\Locale;
use App\Enums\ServiceRequestStatus;
use App\Models\ServiceRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ServiceRequest>
 */
class ServiceRequestFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'company' => fake()->optional()->company(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->optional()->numerify('+49 ########'),
            'message' => fake()->paragraphs(2, true),
            'locale' => Locale::German,
            'status' => ServiceRequestStatus::New,
            'privacy_consent_at' => now(),
        ];
    }
}
