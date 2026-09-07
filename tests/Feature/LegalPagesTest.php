<?php

namespace Tests\Feature;

use Tests\TestCase;

class LegalPagesTest extends TestCase
{
    public function test_imprint_shows_provider_identity_and_eu_notices(): void
    {
        $this->get('/de/impressum')
            ->assertOk()
            ->assertSee('Impressum', false)
            ->assertSee('Enes Handy Reparatur', false)
            ->assertSee('Kübra Tay', false)
            ->assertSee('Rosenstraße 19', false)
            ->assertSee('63450 Hanau', false)
            ->assertSee('DE347824732', false)
            ->assertSee('info@eneshandyreparatur.de', false)
            ->assertSee('+49 163 3609131', false)
            ->assertSee('https://ec.europa.eu/consumers/odr', false)
            ->assertSee('Verbraucherschlichtungsstelle', false)
            ->assertSee('Es besteht kein Eintrag im Handelsregister', false)
            ->assertDontSee('Bitte ergänzen', false)
            ->assertDontSee('legal.imprint.', false);
    }

    public function test_privacy_policy_describes_the_contact_form_and_session_cookies(): void
    {
        $this->get('/de/datenschutz')
            ->assertOk()
            ->assertSee('Kontakt- und Anfrageformular', false)
            ->assertSee('technisch notwendiges Sitzungs-Cookie', false)
            ->assertSee('Enes Handy Reparatur', false)
            ->assertSee('info@eneshandyreparatur.de', false)
            ->assertDontSee('Google Analytics', false)
            ->assertDontSee('sobald sie feststehen', false);
    }

    public function test_english_legal_pages_are_available(): void
    {
        $this->get('/en/privacy')->assertOk()->assertSee('Privacy Policy', false);
        $this->get('/en/terms')->assertOk()->assertSee('Terms &amp; Conditions', false);
        $this->get('/en/withdrawal')->assertOk()->assertSee('Withdrawal Policy', false);
        $this->get('/en/imprint')->assertOk()->assertSee('Imprint', false);
    }

    public function test_terms_and_withdrawal_use_provider_identity_instead_of_homework_placeholders(): void
    {
        $this->get('/de/agb')
            ->assertOk()
            ->assertSee('Enes Handy Reparatur', false)
            ->assertDontSee('Hier ist zu beschreiben', false);

        $this->get('/de/widerruf')
            ->assertOk()
            ->assertSee('Rosenstraße 19', false)
            ->assertSee('info@eneshandyreparatur.de', false);
    }
}
