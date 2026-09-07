<?php

namespace Tests\Feature;

use App\Enums\ServiceRequestStatus;
use App\Models\Faq;
use App\Models\ServiceCategory;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Support\Company;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminSiteManagementTest extends TestCase
{
    public function test_guest_cannot_update_company_details(): void
    {
        $this->from(route('admin.login'))
            ->put(route('admin.company.update'), [
                'legal_name' => 'Unerlaubt',
            ])
            ->assertRedirect(route('admin.login'));

        $this->assertNotSame('Unerlaubt', Company::value('legal_name'));
    }

    public function test_company_form_stores_imprint_values(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('admin.company.edit'))
            ->put(route('admin.company.update'), [
                'legal_name' => 'Neue Werkstatt GmbH',
                'email' => 'office@example.com',
                'website' => 'https://example.com',
            ])
            ->assertRedirect(route('admin.company.edit'))
            ->assertSessionHas('status', 'Gespeichert.');

        $this->assertSame('Neue Werkstatt GmbH', Company::value('legal_name'));
        $this->assertSame('office@example.com', Company::value('email'));
    }

    public function test_faq_is_created_with_german_and_english_copy(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('admin.faqs.create'))
            ->post(route('admin.faqs.store'), [
                'key' => 'office-hours',
                'sort_order' => 3,
                'is_active' => 1,
                'translations' => [
                    'de' => [
                        'question' => 'Wann sind Sie erreichbar?',
                        'answer' => 'Nach Vereinbarung.',
                    ],
                    'en' => [
                        'question' => 'When can we reach you?',
                        'answer' => 'By appointment.',
                    ],
                ],
            ])
            ->assertRedirect(route('admin.faqs.index'))
            ->assertSessionHas('status', 'Gespeichert.');

        $faq = Faq::query()->where('key', 'office-hours')->with('translations')->first();

        $this->assertNotNull($faq);
        $this->assertSame('Wann sind Sie erreichbar?', $faq->translated('question', 'de'));
        $this->assertSame('When can we reach you?', $faq->translated('question', 'en'));
    }

    public function test_empty_faq_payload_returns_validation_errors(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('admin.faqs.create'))
            ->post(route('admin.faqs.store'), [])
            ->assertRedirect(route('admin.faqs.create'))
            ->assertInvalid(['key', 'sort_order', 'translations']);
    }

    public function test_category_update_keeps_existing_slugs(): void
    {
        $user = User::factory()->create();
        $category = ServiceCategory::factory()->create();
        $category->load('translations');

        $this->actingAs($user)
            ->from(route('admin.categories.edit', $category))
            ->put(route('admin.categories.update', $category), $this->categoryPayload($category))
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('status', 'Gespeichert.');
    }

    public function test_enquiry_status_can_be_changed(): void
    {
        $user = User::factory()->create();
        $serviceRequest = ServiceRequest::factory()->create([
            'status' => ServiceRequestStatus::New,
        ]);

        $this->actingAs($user)
            ->from(route('admin.requests.show', $serviceRequest))
            ->patch(route('admin.requests.update', $serviceRequest), [
                'status' => ServiceRequestStatus::Contacted->value,
            ])
            ->assertRedirect(route('admin.requests.show', $serviceRequest))
            ->assertSessionHas('status', 'Gespeichert.');

        $this->assertSame(ServiceRequestStatus::Contacted, $serviceRequest->fresh()->status);
    }

    public function test_unknown_page_group_is_not_found(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/admin/pages/unknown-group')
            ->assertNotFound();
    }

    public function test_password_change_requires_the_current_password(): void
    {
        $user = User::factory()->create([
            'password' => 'old-password',
        ]);

        $this->actingAs($user)
            ->from(route('admin.account.edit'))
            ->put(route('admin.account.update'), [
                'name' => $user->name,
                'email' => $user->email,
                'current_password' => 'wrong-password',
                'password' => 'new-password-123',
                'password_confirmation' => 'new-password-123',
            ])
            ->assertRedirect(route('admin.account.edit'))
            ->assertInvalid(['current_password']);

        $this->assertTrue(Hash::check('old-password', $user->fresh()->password));
    }

    public function test_password_change_updates_the_account(): void
    {
        $user = User::factory()->create([
            'password' => 'old-password',
        ]);

        $this->actingAs($user)
            ->from(route('admin.account.edit'))
            ->put(route('admin.account.update'), [
                'name' => $user->name,
                'email' => $user->email,
                'current_password' => 'old-password',
                'password' => 'new-password-123',
                'password_confirmation' => 'new-password-123',
            ])
            ->assertRedirect(route('admin.account.edit'))
            ->assertSessionHas('status', 'Passwort geändert.');

        $this->assertTrue(Hash::check('new-password-123', $user->fresh()->password));
    }

    public function test_account_name_and_email_can_be_updated_without_changing_the_password(): void
    {
        $user = User::factory()->create([
            'name' => 'Alt Name',
            'email' => 'alt@example.com',
            'password' => 'keep-password',
        ]);

        $this->actingAs($user)
            ->from(route('admin.account.edit'))
            ->put(route('admin.account.update'), [
                'name' => 'Kübra Tay',
                'email' => 'office@example.com',
            ])
            ->assertRedirect(route('admin.account.edit'))
            ->assertSessionHas('status', 'Gespeichert.');

        $user->refresh();

        $this->assertSame('Kübra Tay', $user->name);
        $this->assertSame('office@example.com', $user->email);
        $this->assertTrue(Hash::check('keep-password', $user->password));
    }

    public function test_empty_company_email_setting_does_not_fall_back_to_config(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('admin.company.update'), [
                'email' => '',
            ])
            ->assertRedirect();

        $this->assertSame('', Company::value('email', ''));
        $this->assertFalse(Company::has('email'));
    }

    public function test_enquiry_list_can_be_filtered_by_status(): void
    {
        $user = User::factory()->create();
        ServiceRequest::factory()->create([
            'name' => 'Neue Anfrage',
            'status' => ServiceRequestStatus::New,
        ]);
        ServiceRequest::factory()->create([
            'name' => 'Abgeschlossene Anfrage',
            'status' => ServiceRequestStatus::Completed,
        ]);

        $this->actingAs($user)
            ->get(route('admin.requests.index', ['status' => 'completed']))
            ->assertOk()
            ->assertSee('Abgeschlossene Anfrage', false)
            ->assertDontSee('Neue Anfrage', false);
    }

    /**
     * @return array<string, mixed>
     */
    private function categoryPayload(ServiceCategory $category): array
    {
        $translations = [];

        foreach ($category->translations as $translation) {
            $translations[$translation->locale] = [
                'name' => $translation->name,
                'slug' => $translation->slug,
                'excerpt' => $translation->excerpt,
                'description' => $translation->description,
                'seo_title' => $translation->seo_title,
                'seo_description' => $translation->seo_description,
                'seo_keywords' => $translation->seo_keywords,
            ];
        }

        return [
            'key' => $category->key,
            'icon' => $category->icon,
            'sort_order' => $category->sort_order,
            'is_active' => 1,
            'translations' => $translations,
        ];
    }
}
