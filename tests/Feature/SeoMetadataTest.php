<?php

namespace Tests\Feature;

use Database\Seeders\ServiceContentSeeder;
use Tests\TestCase;

class SeoMetadataTest extends TestCase
{
    public function test_home_includes_canonical_open_graph_and_hreflang(): void
    {
        $this->seed(ServiceContentSeeder::class);

        $this->get('/de')
            ->assertOk()
            ->assertSee('<link rel="canonical" href="http://localhost/de">', false)
            ->assertSee('hreflang="de-DE"', false)
            ->assertSee('hreflang="en"', false)
            ->assertSee('hreflang="x-default"', false)
            ->assertSee('og:title', false)
            ->assertSee('application/ld+json', false);
    }

    public function test_german_service_page_canonical_points_to_german_url(): void
    {
        $this->seed(ServiceContentSeeder::class);

        $this->get('/de/leistungen/software-it/softwareentwicklung')
            ->assertOk()
            ->assertSee('<link rel="canonical" href="http://localhost/de/leistungen/software-it/softwareentwicklung">', false)
            ->assertSee('hreflang="en"', false)
            ->assertSee('http://localhost/en/services/software-it/software-development', false);
    }

    public function test_security_headers_are_present(): void
    {
        $this->get('/de')
            ->assertOk()
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }
}
