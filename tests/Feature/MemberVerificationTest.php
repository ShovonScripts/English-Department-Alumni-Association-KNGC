<?php

namespace Tests\Feature;

use App\Models\Alumni;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\MembershipType;
use App\Models\User;
use App\Notifications\MemberVerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class MemberVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('member-login-127.0.0.1');
    }

    private function createActiveMemberWithUser(?array $userOverrides = null): array
    {
        $type = MembershipType::factory()->create(['name' => 'Regular', 'slug' => 'regular']);
        $tier = MembershipTier::factory()->create(['name' => 'Silver', 'slug' => 'silver']);
        $alumni = Alumni::factory()->create([
            'full_name' => 'Test Member',
            'student_id' => 'KNGC-2024-001',
            'email' => 'member@test.com',
        ]);
        $membership = Membership::factory()->active()->create([
            'alumni_id' => $alumni->id,
            'membership_type_id' => $type->id,
            'membership_tier_id' => $tier->id,
            'membership_number' => 'EDAA-000001',
            'is_public' => true,
        ]);
        $user = User::factory()->create(array_merge([
            'name' => $alumni->full_name,
            'email' => 'member@test.com',
            'alumni_id' => $alumni->id,
            'password' => Hash::make('Password1'),
            'email_verified_at' => null,
        ], $userOverrides ?? []));

        return compact('alumni', 'membership', 'user', 'type', 'tier');
    }

    /*
    |--------------------------------------------------------------------------
    | Email Verification
    |--------------------------------------------------------------------------
    */

    public function test_verification_notice_requires_auth(): void
    {
        $this->get(route('member.verification.notice'))
            ->assertRedirect(route('member.login'));
    }

    public function test_verification_notice_is_accessible(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.verification.notice'))
            ->assertOk()
            ->assertSee('Verify Your Email');
    }

    public function test_verified_member_redirected_from_notice(): void
    {
        $data = $this->createActiveMemberWithUser(['email_verified_at' => now()]);
        $this->actingAs($data['user']);

        $this->get(route('member.verification.notice'))
            ->assertRedirect(route('member.dashboard'));
    }

    public function test_unverified_member_cannot_access_dashboard(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.dashboard'))
            ->assertRedirect(route('member.verification.notice'));
    }

    public function test_resend_verification_requires_auth(): void
    {
        $this->post(route('member.verification.send'))
            ->assertRedirect(route('member.login'));
    }

    public function test_resend_verification_sends_notification(): void
    {
        Notification::fake();
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->post(route('member.verification.send'))
            ->assertRedirect();

        Notification::assertSentTo(
            $data['user'],
            MemberVerifyEmail::class
        );
    }

    public function test_resend_verification_throttled(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        // Hit the throttle limit
        for ($i = 0; $i < 6; $i++) {
            $this->post(route('member.verification.send'));
        }

        $this->post(route('member.verification.send'))
            ->assertStatus(429);
    }

    public function test_email_verification_link_verifies_user(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $url = URL::temporarySignedRoute(
            'member.verification.verify',
            now()->addMinutes(60),
            ['id' => $data['user']->id, 'hash' => sha1($data['user']->email)]
        );

        $this->get($url)
            ->assertRedirect(route('member.dashboard'));

        $this->assertNotNull($data['user']->fresh()->email_verified_at);
    }

    public function test_expired_verification_link_fails(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $url = URL::temporarySignedRoute(
            'member.verification.verify',
            now()->subMinutes(60),
            ['id' => $data['user']->id, 'hash' => sha1($data['user']->email)]
        );

        $this->get($url)
            ->assertStatus(403);
    }

    public function test_wrong_user_verification_link_fails(): void
    {
        $data = $this->createActiveMemberWithUser();
        $otherUser = User::factory()->create(['email_verified_at' => null]);
        $this->actingAs($data['user']);

        $url = URL::temporarySignedRoute(
            'member.verification.verify',
            now()->addMinutes(60),
            ['id' => $otherUser->id, 'hash' => sha1($data['user']->email)]
        );

        $this->get($url)
            ->assertForbidden();
    }

    public function test_invalid_hash_verification_link_fails(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $url = URL::temporarySignedRoute(
            'member.verification.verify',
            now()->addMinutes(60),
            ['id' => $data['user']->id, 'hash' => 'invalid-hash']
        );

        $this->get($url)
            ->assertForbidden();
    }

    /*
    |--------------------------------------------------------------------------
    | Password Reset
    |--------------------------------------------------------------------------
    */

    public function test_forgot_password_form_is_accessible(): void
    {
        $this->get(route('member.password.request'))
            ->assertOk()
            ->assertSee('Forgot Password');
    }

    public function test_forgot_password_requires_email(): void
    {
        $this->post(route('member.password.email'), [
            'email' => '',
        ])->assertSessionHasErrors('email');
    }

    public function test_forgot_password_generic_response(): void
    {
        Notification::fake();

        $this->post(route('member.password.email'), [
            'email' => 'nonexistent@test.com',
        ])->assertSessionHas('status')
            ->assertSessionHas('status', 'If an account with that email address exists, a password reset link has been sent.');

        // Should not reveal whether email exists
        Notification::assertNothingSent();
    }

    public function test_forgot_password_sends_reset_link(): void
    {
        Notification::fake();
        $data = $this->createActiveMemberWithUser();

        $this->post(route('member.password.email'), [
            'email' => 'member@test.com',
        ])->assertSessionHas('status');

        Notification::assertSentTo(
            $data['user'],
            ResetPassword::class
        );
    }

    public function test_reset_password_form_is_accessible(): void
    {
        $this->get(route('member.password.reset', ['token' => 'test-token']))
            ->assertOk()
            ->assertSee('Reset Password');
    }

    public function test_password_reset_requires_token(): void
    {
        $this->post(route('member.password.update'), [
            'token' => '',
            'email' => 'member@test.com',
            'password' => 'NewPass1',
            'password_confirmation' => 'NewPass1',
        ])->assertSessionHasErrors('token');
    }

    public function test_password_reset_requires_email(): void
    {
        $this->post(route('member.password.update'), [
            'token' => 'test-token',
            'email' => '',
            'password' => 'NewPass1',
            'password_confirmation' => 'NewPass1',
        ])->assertSessionHasErrors('email');
    }

    public function test_password_reset_requires_password(): void
    {
        $this->post(route('member.password.update'), [
            'token' => 'test-token',
            'email' => 'member@test.com',
            'password' => '',
            'password_confirmation' => '',
        ])->assertSessionHasErrors('password');
    }

    public function test_password_reset_requires_strong_password(): void
    {
        $this->post(route('member.password.update'), [
            'token' => 'test-token',
            'email' => 'member@test.com',
            'password' => 'weak',
            'password_confirmation' => 'weak',
        ])->assertSessionHasErrors('password');
    }

    public function test_password_reset_requires_confirmation_match(): void
    {
        $this->post(route('member.password.update'), [
            'token' => 'test-token',
            'email' => 'member@test.com',
            'password' => 'NewPass1',
            'password_confirmation' => 'mismatch',
        ])->assertSessionHasErrors('password');
    }

    /*
    |--------------------------------------------------------------------------
    | Account Status
    |--------------------------------------------------------------------------
    */

    public function test_account_status_page_is_accessible(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.account-status'))
            ->assertOk()
            ->assertSee('Account Status');
    }

    public function test_suspended_member_sees_suspended_status(): void
    {
        $type = MembershipType::factory()->create();
        $alumni = Alumni::factory()->create();
        $membership = Membership::factory()->create([
            'alumni_id' => $alumni->id,
            'membership_type_id' => $type->id,
            'status' => 'suspended',
        ]);
        $user = User::factory()->create([
            'alumni_id' => $alumni->id,
        ]);

        $this->actingAs($user);

        $this->get(route('member.account-status'))
            ->assertOk()
            ->assertSee('Account Suspended');
    }

    public function test_cancelled_member_sees_cancelled_status(): void
    {
        $type = MembershipType::factory()->create();
        $alumni = Alumni::factory()->create();
        $membership = Membership::factory()->create([
            'alumni_id' => $alumni->id,
            'membership_type_id' => $type->id,
            'status' => 'cancelled',
        ]);
        $user = User::factory()->create([
            'alumni_id' => $alumni->id,
        ]);

        $this->actingAs($user);

        $this->get(route('member.account-status'))
            ->assertOk()
            ->assertSee('Membership Cancelled');
    }

    /*
    |--------------------------------------------------------------------------
    | Membership Card
    |--------------------------------------------------------------------------
    */

    public function test_membership_card_requires_auth(): void
    {
        $this->get(route('member.membership.card'))
            ->assertRedirect(route('member.login'));
    }

    public function test_membership_card_is_accessible(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.membership.card'))
            ->assertOk()
            ->assertSee('Membership Card')
            ->assertSee('EDAA-000001')
            ->assertSee('Test Member');
    }

    public function test_membership_card_shows_safe_info_only(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.membership.card'))
            ->assertOk()
            ->assertSee('Test Member')
            ->assertSee('EDAA-000001')
            ->assertSee('Regular')
            ->assertSee('Silver')
            ->assertDontSee('password')
            ->assertDontSee('admin');
    }

    /*
    |--------------------------------------------------------------------------
    | Privacy Settings
    |--------------------------------------------------------------------------
    */

    public function test_privacy_page_requires_auth(): void
    {
        $this->get(route('member.privacy'))
            ->assertRedirect(route('member.login'));
    }

    public function test_privacy_page_is_accessible(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.privacy'))
            ->assertOk()
            ->assertSee('Privacy Settings');
    }

    public function test_privacy_page_shows_current_status(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.privacy'))
            ->assertOk()
            ->assertSee('Your profile is public');
    }

    /*
    |--------------------------------------------------------------------------
    | IDOR Prevention
    |--------------------------------------------------------------------------
    */

    public function test_member_cannot_verify_another_users_email(): void
    {
        $data = $this->createActiveMemberWithUser();
        $otherUser = User::factory()->create(['email_verified_at' => null]);
        $this->actingAs($data['user']);

        $url = URL::temporarySignedRoute(
            'member.verification.verify',
            now()->addMinutes(60),
            ['id' => $otherUser->id, 'hash' => sha1($data['user']->email)]
        );

        $this->get($url)
            ->assertForbidden();
    }

    /*
    |--------------------------------------------------------------------------
    | Registration Flow
    |--------------------------------------------------------------------------
    */

    public function test_registration_does_not_auto_verify_email(): void
    {
        $alumni = Alumni::factory()->create([
            'student_id' => 'KNGC-2024-010',
            'full_name' => 'New Member',
        ]);
        $type = MembershipType::factory()->create();
        Membership::factory()->active()->create([
            'alumni_id' => $alumni->id,
            'membership_type_id' => $type->id,
        ]);

        $this->post(route('member.register.store'), [
            'student_id' => 'KNGC-2024-010',
            'full_name' => 'New Member',
            'email' => 'new@test.com',
            'password' => 'Password1',
            'password_confirmation' => 'Password1',
        ]);

        $user = User::where('email', 'new@test.com')->first();
        $this->assertNull($user->email_verified_at);
    }

    public function test_registration_redirects_to_verification_notice(): void
    {
        $alumni = Alumni::factory()->create([
            'student_id' => 'KNGC-2024-011',
            'full_name' => 'Another Member',
        ]);
        $type = MembershipType::factory()->create();
        Membership::factory()->active()->create([
            'alumni_id' => $alumni->id,
            'membership_type_id' => $type->id,
        ]);

        $this->post(route('member.register.store'), [
            'student_id' => 'KNGC-2024-011',
            'full_name' => 'Another Member',
            'email' => 'another@test.com',
            'password' => 'Password1',
            'password_confirmation' => 'Password1',
        ])->assertRedirect(route('member.verification.notice'));
    }

    /*
    |--------------------------------------------------------------------------
    | Login Verification Gate
    |--------------------------------------------------------------------------
    */

    public function test_unverified_member_redirected_to_verification_on_login(): void
    {
        $data = $this->createActiveMemberWithUser();

        $this->post(route('member.login.store'), [
            'email' => 'member@test.com',
            'password' => 'Password1',
        ])->assertRedirect(route('member.verification.notice'));
    }

    public function test_verified_member_can_login_normally(): void
    {
        $data = $this->createActiveMemberWithUser(['email_verified_at' => now()]);

        $this->post(route('member.login.store'), [
            'email' => 'member@test.com',
            'password' => 'Password1',
        ])->assertRedirect(route('member.dashboard'));
    }
}
