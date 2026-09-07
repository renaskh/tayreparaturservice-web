<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function test_login_page_renders_and_is_not_indexed(): void
    {
        $this->get(route('admin.login'))
            ->assertOk()
            ->assertSee('Anmeldung', false)
            ->assertSee('noindex, nofollow', false);
    }

    public function test_valid_credentials_authenticate_and_redirect_to_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => 'secret-password',
        ]);

        $this->from(route('admin.login'))
            ->post(route('admin.login.store'), [
                'email' => $user->email,
                'password' => 'secret-password',
            ])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_credentials_stay_on_login_with_translated_error(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => 'secret-password',
        ]);

        $this->from(route('admin.login'))
            ->post(route('admin.login.store'), [
                'email' => $user->email,
                'password' => 'wrong-password',
            ])
            ->assertRedirect(route('admin.login'))
            ->assertInvalid([
                'email' => 'Diese Zugangsdaten stimmen nicht mit unseren Daten überein.',
            ]);

        $this->assertGuest();
    }

    public function test_guests_are_redirected_from_the_dashboard_to_login(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_authenticated_users_are_redirected_away_from_login(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.login'))
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_logout_ends_the_session(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.logout'))
            ->assertRedirect(route('admin.login'));

        $this->assertGuest();
    }

    public function test_public_registration_is_not_available(): void
    {
        $this->get('/register')->assertNotFound();
        $this->post('/register')->assertNotFound();
        $this->get('/admin/register')->assertNotFound();
    }

    public function test_admin_user_command_creates_a_sign_in_account(): void
    {
        $this->artisan('admin:user', [
            'email' => 'ops@example.com',
            '--name' => 'Ops',
            '--password' => 'command-password',
        ])->assertSuccessful();

        $user = User::query()->where('email', 'ops@example.com')->first();

        $this->assertNotNull($user);
        $this->assertSame('Ops', $user->name);
        $this->assertTrue(Hash::check('command-password', $user->password));
    }
}
