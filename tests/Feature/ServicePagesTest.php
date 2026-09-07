<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\ServiceCategory;
use Database\Seeders\ServiceContentSeeder;
use Tests\TestCase;

class ServicePagesTest extends TestCase
{
    public function test_german_service_detail_renders_localized_slug_and_copy(): void
    {
        $this->seed(ServiceContentSeeder::class);

        $this->get('/de/leistungen/software-it/softwareentwicklung')
            ->assertOk()
            ->assertSee('Softwareentwicklung', false)
            ->assertSee('So fragen Sie an', false);
    }

    public function test_english_service_detail_uses_english_slug(): void
    {
        $this->seed(ServiceContentSeeder::class);

        $this->get('/en/services/software-it/software-development')
            ->assertOk()
            ->assertSee('Software Development', false)
            ->assertSee('How to request it', false);
    }

    public function test_german_desktop_and_mobile_development_pages_render(): void
    {
        $this->seed(ServiceContentSeeder::class);

        $this->get('/de/leistungen/software-it/desktop-anwendungen')
            ->assertOk()
            ->assertSee('Desktop-Anwendungen', false);

        $this->get('/de/leistungen/software-it/smartphone-apps')
            ->assertOk()
            ->assertSee('Smartphone- und Mobile-Apps', false);

        $this->get('/de/leistungen/software-it/buchhaltung-rechnungen')
            ->assertOk()
            ->assertSee('Buchhaltungs- und Rechnungssysteme', false);
    }

    public function test_inactive_category_returns_not_found(): void
    {
        $category = ServiceCategory::factory()->inactive()->create([
            'key' => 'inactive-cat',
        ]);

        $slug = $category->translated('slug', 'de');

        $this->get('/de/leistungen/'.$slug)
            ->assertNotFound();
    }

    public function test_service_from_another_category_returns_not_found(): void
    {
        $this->seed(ServiceContentSeeder::class);

        $other = Service::query()->where('key', 'smartphone-repair')->firstOrFail();
        $software = ServiceCategory::query()->where('key', 'software-it')->firstOrFail();

        $this->get('/de/leistungen/'.$software->translated('slug', 'de').'/'.$other->translated('slug', 'de'))
            ->assertNotFound();
    }
}
