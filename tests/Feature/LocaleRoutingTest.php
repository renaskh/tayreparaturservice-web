<?php

namespace Tests\Feature;

use Database\Seeders\ServiceContentSeeder;
use Tests\TestCase;

class LocaleRoutingTest extends TestCase
{
    public function test_language_switcher_points_to_equivalent_english_page(): void
    {
        $this->seed(ServiceContentSeeder::class);

        $this->get('/de/leistungen')
            ->assertOk()
            ->assertSee('href="http://localhost/en/services"', false);
    }

    public function test_english_services_index_uses_localized_path(): void
    {
        $this->seed(ServiceContentSeeder::class);

        $this->get('/en/services')
            ->assertOk()
            ->assertSee('Our Services', false)
            ->assertDontSee('Unsere Leistungen', false);
    }

    public function test_unsupported_locale_prefix_returns_not_found(): void
    {
        $this->get('/fr')
            ->assertNotFound();
    }
}
