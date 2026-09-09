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
    | Email Verification — not implemented (no email verification)
    |--------------------------------------------------------------------------
    */

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
    | IDOR Prevention — verification not implemented
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Registration Flow — verification not implemented
    |--------------------------------------------------------------------------
    */
}
