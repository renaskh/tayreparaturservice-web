<?php

namespace Tests\Feature;

use App\Support\SiteMedia;
use Database\Seeders\FaqSeeder;
use Database\Seeders\ServiceContentSeeder;
use Tests\TestCase;

class SitePhotosTest extends TestCase
{
    public function test_optimized_photos_exist_in_the_public_images_directory(): void
    {
        $this->assertFileExists(public_path('images/infrastructure-servers.webp'));
        $this->assertFileExists(public_path('images/technical-office.jpg'));
        $this->assertFileExists(public_path('images/electronics-board.webp'));
        $this->assertFileExists(public_path('images/source-code.webp'));
        $this->assertFileExists(public_path('images/laboratory-work.jpg'));
        $this->assertFileExists(public_path('images/workshop-tools.webp'));
        $this->assertFileExists(public_path('images/engineering-work.jpg'));
        $this->assertFileExists(public_path('images/code-review.webp'));
        $this->assertFileExists(public_path('images/engineering-lab.jpg'));
        $this->assertFileExists(public_path('images/laptop-code.webp'));
    }

    public function test_home_places_photos_in_matching_sections(): void
    {
        $this->seed([ServiceContentSeeder::class, FaqSeeder::class]);

        $this->get('/de')
            ->assertOk()
            ->assertSee('/images/infrastructure-servers.webp', false)
            ->assertSee('/images/technical-office.webp', false)
            ->assertSee('/images/software-code.webp', false)
            ->assertSee('/images/technical-workstation.webp', false)
            ->assertSee('/images/electronics-chip.webp', false)
            ->assertSee('/images/industrial-testing.webp', false)
            ->assertSee('/images/source-code.webp', false)
            ->assertSee('/images/motherboard-detail.webp', false)
            ->assertSee('/images/abstract-tech.webp', false)
            ->assertSee('/images/hardware-board.webp', false)
            ->assertSee('/images/laboratory-work.webp', false)
            ->assertSee('/images/business-dashboard.webp', false)
            ->assertSee('/images/workshop-tools.webp', false)
            ->assertSee('/images/workshop-planning.webp', false)
            ->assertSee('/images/laptop-code.webp', false)
            ->assertSee('Technische Arbeitsplätze mit mehreren Monitoren', false)
            ->assertSee('Hand mit Stift auf einer technischen Zeichnung', false);
    }

    public function test_service_and_industry_photos_follow_the_subject_of_the_image(): void
    {
        $this->assertSame('software-code', SiteMedia::forCategory('software-it'));
        $this->assertSame('technical-workstation', SiteMedia::forCategory('technical-support'));
        $this->assertSame('electronics-chip', SiteMedia::forCategory('repair-electronics'));
        $this->assertSame('industrial-testing', SiteMedia::forCategory('business-industry'));
        $this->assertSame('source-code', SiteMedia::forCategory('technology-companies'));
        $this->assertSame('abstract-tech', SiteMedia::forIndustry('tech'));
        $this->assertSame('hardware-board', SiteMedia::forIndustry('manufacturing'));
        $this->assertSame('laboratory-work', SiteMedia::forIndustry('lab'));
        $this->assertSame('business-dashboard', SiteMedia::forIndustry('business'));
        $this->assertSame('workshop-tools', SiteMedia::forIndustry('workshop'));
        $this->assertSame('laptop-code', SiteMedia::forIndustry('commercial'));
    }

    public function test_about_business_and_contact_pages_use_matching_photos(): void
    {
        $this->get('/de/ueber-uns')
            ->assertOk()
            ->assertSee('/images/circuit-glow.webp', false)
            ->assertSee('/images/technical-office.webp', false);

        $this->get('/de/fuer-unternehmen')
            ->assertOk()
            ->assertSee('/images/engineering-lab.webp', false)
            ->assertSee('/images/industrial-testing.webp', false);

        $this->get('/de/kontakt')
            ->assertOk()
            ->assertSee('/images/code-review.webp', false);
    }

    public function test_faq_header_uses_the_hardware_photo(): void
    {
        $this->seed(FaqSeeder::class);

        $this->get('/de/faq')
            ->assertOk()
            ->assertSee('/images/memory-modules.webp', false);
    }

    public function test_technology_companies_category_uses_the_source_code_photo(): void
    {
        $this->seed(ServiceContentSeeder::class);

        $this->get('/de/leistungen/technologieunternehmen')
            ->assertOk()
            ->assertSee('/images/source-code.webp', false);
    }

    public function test_open_graph_image_points_to_the_server_photo(): void
    {
        $this->seed([ServiceContentSeeder::class, FaqSeeder::class]);

        $this->get('/de')
            ->assertOk()
            ->assertSee('og:image', false)
            ->assertSee('/images/infrastructure-servers.jpg', false)
            ->assertSee('summary_large_image', false);
    }
}
