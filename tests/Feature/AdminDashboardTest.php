<?php

namespace Tests\Feature;

use App\Enums\ServiceRequestStatus;
use App\Models\Faq;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\User;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    public function test_dashboard_lists_recent_enquiries(): void
    {
        $user = User::factory()->create();
        ServiceRequest::factory()->create([
            'name' => 'Alex Muster',
            'email' => 'alex@example.com',
        ]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Alex Muster', false)
            ->assertSee('alex@example.com', false)
            ->assertSee('Übersicht', false);
    }

    public function test_dashboard_escapes_enquiry_names(): void
    {
        $user = User::factory()->create();
        ServiceRequest::factory()->create([
            'name' => '<script>alert(1)</script>',
        ]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_dashboard_greets_the_signed_in_user_in_the_morning(): void
    {
        $this->travelTo('2026-09-07 09:15:00');

        $user = User::factory()->create([
            'name' => 'Kübra Tay',
        ]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Guten Morgen, Kübra Tay', false)
            ->assertSee('Betrieb', false)
            ->assertSee('Inhalte', false)
            ->assertSee('Einstellungen', false);
    }

    public function test_dashboard_escapes_the_signed_in_user_name(): void
    {
        $user = User::factory()->create([
            'name' => '<script>alert(1)</script>',
        ]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_dashboard_summarises_request_and_catalog_counts(): void
    {
        $this->travelTo('2026-09-09 12:00:00');

        $user = User::factory()->create();

        ServiceRequest::factory()->create([
            'status' => ServiceRequestStatus::New,
            'created_at' => now(),
        ]);
        ServiceRequest::factory()->create([
            'status' => ServiceRequestStatus::InReview,
            'created_at' => now()->subWeek(),
        ]);
        ServiceRequest::factory()->create([
            'status' => ServiceRequestStatus::Completed,
            'created_at' => now()->subWeeks(3),
        ]);
        Service::factory()->count(2)->create();
        Service::factory()->inactive()->create();
        Faq::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertViewHas('newRequestCount', 1)
            ->assertViewHas('inProgressCount', 1)
            ->assertViewHas('requestsThisWeek', 1)
            ->assertViewHas('requestCount', 3)
            ->assertViewHas('publishedServiceCount', 2)
            ->assertViewHas('serviceCount', 3)
            ->assertViewHas('faqCount', 1)
            ->assertSee('Neue Anfragen', false)
            ->assertSee('Offene Vorgänge', false)
            ->assertSee('Diese Woche', false)
            ->assertSee('Veröffentlichte Leistungen', false);
    }
}
