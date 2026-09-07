<?php

namespace Tests\Feature;

use Database\Seeders\FaqSeeder;
use Database\Seeders\ServiceContentSeeder;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_root_redirects_to_german_home(): void
    {
        $this->get('/')
            ->assertRedirect('/de')
            ->assertStatus(301);
    }

    public function test_german_home_renders_headline_and_services(): void
    {
        $this->seed([ServiceContentSeeder::class, FaqSeeder::class]);

        $this->get('/de')
            ->assertOk()
            ->assertSee('Technik mit Haltung', false)
            ->assertSee('Professioneller technischer Service für moderne Unternehmen', false)
            ->assertSee('Software &amp; IT-Dienstleistungen', false)
            ->assertSee('Service anfragen', false)
            ->assertSee('Technische Leistungsbereiche', false)
            ->assertSee('Desktop-Anwendungen', false)
            ->assertSee('Smartphone-Apps', false)
            ->assertSee('Buchhaltung &amp; Rechnungen', false)
            ->assertSee('So funktioniert unser Service', false);
    }

    public function test_english_home_renders_translated_copy(): void
    {
        $this->seed([ServiceContentSeeder::class, FaqSeeder::class]);

        $this->get('/en')
            ->assertOk()
            ->assertSee('Technology with discipline', false)
            ->assertSee('Professional technical services for modern businesses', false)
            ->assertSee('Request a Service', false)
            ->assertSee('Software &amp; IT Services', false)
            ->assertSee('Desktop applications', false)
            ->assertSee('How Our Service Works', false);
    }
}
