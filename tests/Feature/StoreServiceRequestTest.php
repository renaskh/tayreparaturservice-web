<?php

namespace Tests\Feature;

use App\Mail\ServiceRequestReceived;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceRequest;
use Database\Seeders\ServiceContentSeeder;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class StoreServiceRequestTest extends TestCase
{
    public function test_valid_payload_creates_request_and_shows_success_message(): void
    {
        $this->seed(ServiceContentSeeder::class);
        config(['company.email' => 'ops@example.com']);
        Mail::fake();

        $category = ServiceCategory::query()->where('key', 'software-it')->firstOrFail();
        $service = Service::query()->where('key', 'software-development')->firstOrFail();

        $this->from('/de/kontakt')
            ->post('/de/kontakt', $this->validPayload([
                'service_category_id' => $category->id,
                'service_id' => $service->id,
            ]))
            ->assertRedirect('/de/kontakt')
            ->assertSessionHas('status');

        $this->assertDatabaseHas('service_requests', [
            'email' => 'alex@example.com',
            'name' => 'Alex Muster',
            'locale' => 'de',
            'status' => 'new',
        ]);

        Mail::assertSent(ServiceRequestReceived::class);
    }

    public function test_empty_payload_returns_translated_validation_messages(): void
    {
        $this->from('/de/kontakt')
            ->post('/de/kontakt', [])
            ->assertRedirect('/de/kontakt')
            ->assertInvalid([
                'name' => 'Name ist erforderlich.',
                'email' => 'E-Mail ist erforderlich.',
                'message' => 'Nachricht ist erforderlich.',
                'privacy_consent' => 'Bitte bestätigen Sie die Datenschutzhinweise, um die Anfrage zu senden.',
            ]);
    }

    public function test_english_validation_messages_are_used_on_english_form(): void
    {
        $this->from('/en/contact')
            ->post('/en/contact', [])
            ->assertInvalid([
                'name' => 'The Name field is required.',
            ]);
    }

    public function test_honeypot_submission_does_not_store_a_request(): void
    {
        $this->post('/de/kontakt', $this->validPayload([
            'website' => 'http://spam.example',
        ]))
            ->assertRedirect('/de/kontakt')
            ->assertSessionHas('status');

        $this->assertDatabaseCount('service_requests', 0);
    }

    public function test_mail_escapes_html_in_the_message(): void
    {
        config(['company.email' => 'ops@example.com']);

        $request = ServiceRequest::factory()->create([
            'name' => "O'Reilly <script>alert(1)</script>",
            'message' => '<script>alert(1)</script> bitte anrufen',
        ]);

        $html = (new ServiceRequestReceived($request))->render();

        $this->assertStringContainsString('script', $html);
        $this->assertStringNotContainsString('<script>alert(1)</script>', $html);
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Alex Muster',
            'company' => 'Muster GmbH',
            'email' => 'alex@example.com',
            'phone' => '+49 123 456789',
            'message' => 'Wir benötigen Unterstützung bei einer internen Webanwendung und der Anbindung einer bestehenden Datenbank.',
            'privacy_consent' => '1',
        ], $overrides);
    }
}
