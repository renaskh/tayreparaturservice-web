<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_application_redirects_the_root_to_the_default_locale(): void
    {
        $this->get('/')
            ->assertRedirect('/de');
    }
}
