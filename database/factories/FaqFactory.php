<?php

namespace Database\Factories;

use App\Models\Faq;
use App\Models\FaqTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Faq>
 */
class FaqFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => fake()->unique()->slug(2),
            'sort_order' => fake()->numberBetween(1, 20),
            'is_active' => true,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Faq $faq): void {
            foreach (['de', 'en'] as $locale) {
                FaqTranslation::query()->create([
                    'faq_id' => $faq->id,
                    'locale' => $locale,
                    'question' => fake()->sentence().'?',
                    'answer' => fake()->paragraph(),
                ]);
            }
        });
    }
}
