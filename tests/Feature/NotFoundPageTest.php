<?php

namespace Tests\Feature;

use Tests\TestCase;

class NotFoundPageTest extends TestCase
{
    public function test_unknown_german_path_renders_localized_not_found_page(): void
    {
        $this->get('/de/diese-seite-gibt-es-nicht')
            ->assertNotFound()
            ->assertSee('Seite nicht gefunden', false);
    }

    public function test_unknown_english_path_renders_english_not_found_page(): void
    {
        $this->get('/en/this-page-does-not-exist')
            ->assertNotFound()
            ->assertSee('Page not found', false);
    }
}
