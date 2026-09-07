<?php

namespace Tests\Feature;

use Database\Seeders\ServiceContentSeeder;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    public function test_sitemap_lists_localized_service_urls_and_hreflang_alternates(): void
    {
        $this->seed(ServiceContentSeeder::class);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('content-type', 'application/xml; charset=UTF-8')
            ->assertSee('http://localhost/de/leistungen/software-it/softwareentwicklung', false)
            ->assertSee('http://localhost/de/leistungen/software-it/desktop-anwendungen', false)
            ->assertSee('http://localhost/en/services/software-it/software-development', false)
            ->assertSee('http://localhost/en/services/software-it/mobile-apps', false)
            ->assertSee('hreflang="de-DE"', false)
            ->assertSee('hreflang="x-default"', false);
    }

    public function test_robots_txt_points_to_the_sitemap(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Sitemap: http://localhost/sitemap.xml', false)
            ->assertSee('Disallow: /admin', false);
    }
}
