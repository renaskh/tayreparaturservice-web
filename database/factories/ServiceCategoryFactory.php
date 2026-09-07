<?php

namespace Database\Factories;

use App\Models\ServiceCategory;
use App\Models\ServiceCategoryTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ServiceCategory>
 */
class ServiceCategoryFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $key = fake()->unique()->slug(2);

        return [
            'key' => $key,
            'icon' => 'layers',
            'sort_order' => fake()->numberBetween(1, 20),
            'is_active' => true,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (ServiceCategory $category): void {
            foreach (['de', 'en'] as $locale) {
                ServiceCategoryTranslation::query()->create([
                    'service_category_id' => $category->id,
                    'locale' => $locale,
                    'name' => fake()->words(3, true),
                    'slug' => $category->key.'-'.$locale,
                    'excerpt' => fake()->sentence(),
                    'description' => fake()->paragraphs(2, true),
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
