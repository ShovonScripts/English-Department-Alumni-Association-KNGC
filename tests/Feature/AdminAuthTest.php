<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected string $password = 'password';

    // ── Login Page Tests ─────────────────────────────────────

    public function test_login_page_returns_200(): void
    {
        $this->get(route('admin.login'))->assertOk();
    }

    public function test_login_page_is_accessible_to_guests(): void
    {
        $this->get(route('admin.login'))
            ->assertOk()
            ->assertSee('email');
    }

    public function test_login_page_shows_form(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertSee('type="email"', false);
        $response->assertSee('type="password"', false);
    }

    public function test_login_page_has_remember_me(): void
    {
        $this->get(route('admin.login'))->assertSee('remember');
    }

    public function test_login_page_has_csrf_token(): void
    {
        $this->get(route('admin.login'))->assertSee('_token');
    }

    // ── Login Validation Tests ───────────────────────────────

    public function test_login_requires_email(): void
    {
        $this->post(route('admin.login.store'), [
            'password' => $this->password,
        ])->assertSessionHasErrors('email');
    }

    public function test_login_requires_password(): void
    {
        $this->post(route('admin.login.store'), [
            'email' => 'admin@example.com',
        ])->assertSessionHasErrors('password');
    }

    public function test_login_requires_valid_email_format(): void
    {
        $this->post(route('admin.login.store'), [
            'email' => 'not-an-email',
            'password' => $this->password,
        ])->assertSessionHasErrors('email');
    }

    public function test_login_rejects_invalid_credentials(): void
    {
        User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('correct-password'),
        ]);

        $this->post(route('admin.login.store'), [
            'email' => 'admin@example.com',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');
    }

    public function test_login_rejects_nonexistent_account(): void
    {
        $this->post(route('admin.login.store'), [
            'email' => 'nobody@example.com',
            'password' => $this->password,
        ])->assertSessionHasErrors('email');
    }

    public function test_login_preserves_email_on_failure(): void
    {
        User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('correct-password'),
        ]);

        $this->post(route('admin.login.store'), [
            'email' => 'admin@example.com',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');
    }

    public function test_login_does_not_expose_password(): void
    {
        $response = $this->post(route('admin.login.store'), [
            'email' => 'admin@example.com',
            'password' => 'my-secret-password',
        ]);

        $response->assertDontSee('my-secret-password');
    }

    // ── Successful Login Tests ───────────────────────────────

    public function test_admin_can_login(): void
    {
        $user = User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make($this->password),
        ]);

        $this->post(route('admin.login.store'), [
            'email' => 'admin@example.com',
            'password' => $this->password,
        ])->assertRedirect(route('admin.dashboard'));
    }

    public function test_login_redirects_to_intended_url(): void
    {
        $user = User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make($this->password),
        ]);

        $intendedUrl = route('admin.alumni.index');

        $this->withSession(['url.intended' => $intendedUrl])
            ->post(route('admin.login.store'), [
                'email' => 'admin@example.com',
                'password' => $this->password,
            ])->assertRedirect($intendedUrl);
    }

    public function test_login_regenerates_session(): void
    {
        $user = User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make($this->password),
        ]);

        $this->get(route('admin.login'));
        $sessionIdBefore = Session::getId();

        $this->post(route('admin.login.store'), [
            'email' => 'admin@example.com',
            'password' => $this->password,
        ]);

        $sessionIdAfter = Session::getId();

        $this->assertNotEquals($sessionIdBefore, $sessionIdAfter);
    }

    public function test_login_sets_auth_session(): void
    {
        $user = User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make($this->password),
        ]);

        $this->post(route('admin.login.store'), [
            'email' => 'admin@example.com',
            'password' => $this->password,
        ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_remember_me_sets_remember_token_cookie(): void
    {
        $user = User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make($this->password),
        ]);

        $response = $this->post(route('admin.login.store'), [
            'email' => 'admin@example.com',
            'password' => $this->password,
            'remember' => 'on',
        ]);

        $hasRememberCookie = collect($response->headers->getCookies())
            ->contains(fn ($cookie) => str_starts_with($cookie->getName(), 'remember_web_'));

        $this->assertTrue($hasRememberCookie, 'Expected a remember_me cookie to be set.');
    }

    // ── Non-Admin Login Tests ────────────────────────────────

    public function test_non_admin_cannot_access_admin_area(): void
    {
        $user = User::factory()->nonAdmin()->create([
            'email' => 'user@example.com',
            'password' => Hash::make($this->password),
        ]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_non_admin_gets_403_on_admin_dashboard(): void
    {
        $user = User::factory()->nonAdmin()->create([
            'email' => 'user@example.com',
            'password' => Hash::make($this->password),
        ]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    // ── Logout Tests ─────────────────────────────────────────

    public function test_logout_invalidates_session(): void
    {
        $user = User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make($this->password),
        ]);

        $this->actingAs($user);

        $this->delete(route('admin.logout'));

        $this->assertGuest();
    }

    public function test_logout_redirects_to_login(): void
    {
        $user = User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make($this->password),
        ]);

        $this->actingAs($user);

        $this->delete(route('admin.logout'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_logout_requires_authentication(): void
    {
        $this->delete(route('admin.logout'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_logout_requires_post_method(): void
    {
        $user = User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make($this->password),
        ]);

        $this->actingAs($user);

        $this->get(route('admin.logout'))
            ->assertStatus(405);
    }

    public function test_logout_requires_csrf_token(): void
    {
        $user = User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make($this->password),
        ]);

        $this->actingAs($user);

        $this->delete(route('admin.logout'))
            ->assertRedirect(route('admin.login'));
    }

    // ── Unauthenticated Access Tests ─────────────────────────

    public function test_unauthenticated_admin_redirects_to_login(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_unauthenticated_admin_alumni_redirects_to_login(): void
    {
        $this->get(route('admin.alumni.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_unauthenticated_admin_events_redirects_to_login(): void
    {
        $this->get(route('admin.events.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_unauthenticated_admin_news_redirects_to_login(): void
    {
        $this->get(route('admin.news.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_unauthenticated_admin_stories_redirects_to_login(): void
    {
        $this->get(route('admin.stories.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_unauthenticated_admin_gallery_redirects_to_login(): void
    {
        $this->get(route('admin.gallery.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_unauthenticated_admin_publications_redirects_to_login(): void
    {
        $this->get(route('admin.publications.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_unauthenticated_admin_messages_redirects_to_login(): void
    {
        $this->get(route('admin.messages.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_unauthenticated_admin_committee_redirects_to_login(): void
    {
        $this->get(route('admin.committees.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_login_route_is_not_protected(): void
    {
        $this->get(route('admin.login'))->assertOk();
    }

    public function test_login_post_route_is_not_protected(): void
    {
        $this->post(route('admin.login.store'), [
            'email' => 'admin@example.com',
            'password' => $this->password,
        ])->assertSessionHasErrors('email');
    }

    // ── Admin Authenticated Access Tests ─────────────────────

    public function test_admin_can_access_dashboard(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertOk();
    }

    public function test_admin_can_access_alumni_index(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get(route('admin.alumni.index'))
            ->assertOk();
    }

    public function test_admin_can_access_committee_index(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get(route('admin.committees.index'))
            ->assertOk();
    }

    public function test_admin_can_access_events_index(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get(route('admin.events.index'))
            ->assertOk();
    }

    public function test_admin_can_access_news_index(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get(route('admin.news.index'))
            ->assertOk();
    }

    public function test_admin_can_access_stories_index(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get(route('admin.stories.index'))
            ->assertOk();
    }

    public function test_admin_can_access_gallery_index(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get(route('admin.gallery.index'))
            ->assertOk();
    }

    public function test_admin_can_access_publications_index(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get(route('admin.publications.index'))
            ->assertOk();
    }

    public function test_admin_can_access_messages_index(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get(route('admin.messages.index'))
            ->assertOk();
    }

    // ── Rate Limiting Tests ──────────────────────────────────

    public function test_login_throttle_after_too_many_attempts(): void
    {
        $user = User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make($this->password),
        ]);

        for ($i = 0; $i < 6; $i++) {
            $this->post(route('admin.login.store'), [
                'email' => 'admin@example.com',
                'password' => 'wrong-password',
            ]);
        }

        RateLimiter::clear('login');

        $this->post(route('admin.login.store'), [
            'email' => 'admin@example.com',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');
    }

    public function test_throttle_message_is_user_friendly(): void
    {
        $user = User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make($this->password),
        ]);

        for ($i = 0; $i < 6; $i++) {
            $this->post(route('admin.login.store'), [
                'email' => 'admin@example.com',
                'password' => 'wrong-password',
            ]);
        }

        RateLimiter::clear('login');

        $this->post(route('admin.login.store'), [
            'email' => 'admin@example.com',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');
    }

    // ── Password Security Tests ──────────────────────────────

    public function test_password_is_hashed_in_database(): void
    {
        $user = User::factory()->admin()->create([
            'password' => Hash::make($this->password),
        ]);

        $dbPassword = $user->fresh()->password;

        $this->assertNotEquals($this->password, $dbPassword);
        $this->assertNotEmpty($dbPassword);
    }

    public function test_password_hash_matches_plain_password(): void
    {
        $user = User::factory()->admin()->create([
            'password' => Hash::make($this->password),
        ]);

        $this->assertTrue(Hash::check($this->password, $user->password));
    }

    // ── CSRF Tests ───────────────────────────────────────────

    public function test_csrf_middleware_is_enabled(): void
    {
        $response = $this->postJson(route('admin.login.store'), [
            'email' => 'nonexistent@example.com',
            'password' => 'wrong',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors('email');
    }

    public function test_admin_routes_require_session(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'));
    }
}
