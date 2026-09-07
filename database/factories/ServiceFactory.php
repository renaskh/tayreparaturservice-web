<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_category_id' => ServiceCategory::factory(),
            'key' => fake()->unique()->slug(2),
            'icon' => 'code',
            'sort_order' => fake()->numberBetween(1, 20),
            'is_active' => true,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Service $service): void {
            foreach (['de', 'en'] as $locale) {
                ServiceTranslation::query()->create([
                    'service_id' => $service->id,
                    'locale' => $locale,
                    'name' => fake()->words(3, true),
                    'slug' => $service->key.'-'.$locale,
                    'excerpt' => fake()->sentence(),
                    'description' => fake()->paragraphs(2, true),
                    'features' => [fake()->sentence(6), fake()->sentence(6), fake()->sentence(6)],
                    'seo_title' => fake()->sentence(4),
                    'seo_description' => fake()->sentence(12),
                ]);
            }
        });
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_active' => false,
        ]);
    }
}
