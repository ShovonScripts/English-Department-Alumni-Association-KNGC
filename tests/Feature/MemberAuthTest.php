<?php

namespace Tests\Feature;

use App\Models\Alumni;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\MembershipType;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class MemberAuthTest extends TestCase
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
            'email_verified_at' => now(),
        ], $userOverrides ?? []));

        return compact('alumni', 'membership', 'user', 'type', 'tier');
    }

    /*
    |--------------------------------------------------------------------------
    | Registration
    |--------------------------------------------------------------------------
    */

    public function test_register_form_is_accessible(): void
    {
        $this->get(route('member.register'))
            ->assertOk()
            ->assertSee('Member Registration');
    }

    public function test_register_form_redirects_authenticated_user(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.register'))
            ->assertRedirect();
    }

    public function test_registration_requires_student_id(): void
    {
        $this->post(route('member.register.store'), [
            'student_id' => '',
            'full_name' => 'Test',
            'email' => 'a@b.com',
            'password' => 'Password1',
            'password_confirmation' => 'Password1',
        ])->assertSessionHasErrors('student_id');
    }

    public function test_registration_requires_full_name(): void
    {
        $this->post(route('member.register.store'), [
            'student_id' => 'KNGC-2024-001',
            'full_name' => '',
            'email' => 'a@b.com',
            'password' => 'Password1',
            'password_confirmation' => 'Password1',
        ])->assertSessionHasErrors('full_name');
    }

    public function test_registration_requires_valid_email(): void
    {
        $this->post(route('member.register.store'), [
            'student_id' => 'KNGC-2024-001',
            'full_name' => 'Test',
            'email' => 'not-an-email',
            'password' => 'Password1',
            'password_confirmation' => 'Password1',
        ])->assertSessionHasErrors('email');
    }

    public function test_registration_requires_unique_email(): void
    {
        User::factory()->create(['email' => 'taken@test.com']);

        $this->post(route('member.register.store'), [
            'student_id' => 'KNGC-2024-001',
            'full_name' => 'Test',
            'email' => 'taken@test.com',
            'password' => 'Password1',
            'password_confirmation' => 'Password1',
        ])->assertSessionHasErrors('email');
    }

    public function test_registration_requires_strong_password(): void
    {
        $this->post(route('member.register.store'), [
            'student_id' => 'KNGC-2024-001',
            'full_name' => 'Test',
            'email' => 'a@b.com',
            'password' => 'weak',
            'password_confirmation' => 'weak',
        ])->assertSessionHasErrors('password');
    }

    public function test_registration_requires_password_confirmation(): void
    {
        $this->post(route('member.register.store'), [
            'student_id' => 'KNGC-2024-001',
            'full_name' => 'Test',
            'email' => 'a@b.com',
            'password' => 'Password1',
            'password_confirmation' => 'mismatch',
        ])->assertSessionHasErrors('password');
    }

    public function test_registration_fails_when_no_matching_alumni(): void
    {
        $this->post(route('member.register.store'), [
            'student_id' => 'FAKE-000',
            'full_name' => 'No One',
            'email' => 'nobody@test.com',
            'password' => 'Password1',
            'password_confirmation' => 'Password1',
        ])->assertSessionHasErrors('student_id');
    }

    public function test_registration_fails_when_name_mismatch(): void
    {
        Alumni::factory()->create([
            'student_id' => 'KNGC-2024-001',
            'full_name' => 'Real Name',
        ]);

        $this->post(route('member.register.store'), [
            'student_id' => 'KNGC-2024-001',
            'full_name' => 'Wrong Name',
            'email' => 'a@b.com',
            'password' => 'Password1',
            'password_confirmation' => 'Password1',
        ])->assertSessionHasErrors('student_id');
    }

    public function test_registration_fails_when_alumni_already_has_user(): void
    {
        $type = MembershipType::factory()->create();
        $alumni = Alumni::factory()->create([
            'student_id' => 'KNGC-2024-001',
            'full_name' => 'Taken Alumni',
        ]);
        Membership::factory()->active()->create([
            'alumni_id' => $alumni->id,
            'membership_type_id' => $type->id,
        ]);
        User::factory()->create(['alumni_id' => $alumni->id]);

        $this->post(route('member.register.store'), [
            'student_id' => 'KNGC-2024-001',
            'full_name' => 'Taken Alumni',
            'email' => 'new@test.com',
            'password' => 'Password1',
            'password_confirmation' => 'Password1',
        ])->assertSessionHasErrors('student_id');
    }

    public function test_registration_fails_when_no_active_membership(): void
    {
        $type = MembershipType::factory()->create();
        $alumni = Alumni::factory()->create([
            'student_id' => 'KNGC-2024-001',
            'full_name' => 'No Membership',
        ]);
        Membership::factory()->create([
            'alumni_id' => $alumni->id,
            'membership_type_id' => $type->id,
            'status' => 'pending',
        ]);

        $this->post(route('member.register.store'), [
            'student_id' => 'KNGC-2024-001',
            'full_name' => 'No Membership',
            'email' => 'a@b.com',
            'password' => 'Password1',
            'password_confirmation' => 'Password1',
        ])->assertSessionHasErrors('student_id');
    }

    public function test_successful_registration(): void
    {
        $alumni2 = Alumni::factory()->create([
            'student_id' => 'KNGC-2024-002',
            'full_name' => 'New Member',
        ]);
        $type = MembershipType::factory()->create();
        Membership::factory()->active()->create([
            'alumni_id' => $alumni2->id,
            'membership_type_id' => $type->id,
        ]);

        $this->post(route('member.register.store'), [
            'student_id' => 'KNGC-2024-002',
            'full_name' => 'New Member',
            'email' => 'new@test.com',
            'password' => 'Password1',
            'password_confirmation' => 'Password1',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'new@test.com',
            'alumni_id' => $alumni2->id,
        ]);

        $this->assertAuthenticated();
    }

    public function test_successful_registration_redirects_to_dashboard(): void
    {
        $alumni = Alumni::factory()->create([
            'student_id' => 'KNGC-2024-003',
            'full_name' => 'Dashboard Member',
        ]);
        $type = MembershipType::factory()->create();
        Membership::factory()->active()->create([
            'alumni_id' => $alumni->id,
            'membership_type_id' => $type->id,
        ]);

        $this->post(route('member.register.store'), [
            'student_id' => 'KNGC-2024-003',
            'full_name' => 'Dashboard Member',
            'email' => 'dash@test.com',
            'password' => 'Password1',
            'password_confirmation' => 'Password1',
        ])->assertRedirect(route('member.dashboard'));
    }

    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    public function test_login_form_is_accessible(): void
    {
        $this->get(route('member.login'))
            ->assertOk()
            ->assertSee('Member Portal');
    }

    public function test_login_requires_email(): void
    {
        $this->post(route('member.login.store'), [
            'email' => '',
            'password' => 'Password1',
        ])->assertSessionHasErrors('email');
    }

    public function test_login_requires_password(): void
    {
        $this->post(route('member.login.store'), [
            'email' => 'a@b.com',
            'password' => '',
        ])->assertSessionHasErrors('password');
    }

    public function test_login_fails_with_wrong_credentials(): void
    {
        User::factory()->create(['email' => 'a@b.com', 'password' => Hash::make('Password1')]);

        $this->post(route('member.login.store'), [
            'email' => 'a@b.com',
            'password' => 'wrongpass',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_login_fails_when_no_alumni_link(): void
    {
        User::factory()->create([
            'email' => 'nolink@test.com',
            'password' => Hash::make('Password1'),
            'alumni_id' => null,
        ]);

        $this->post(route('member.login.store'), [
            'email' => 'nolink@test.com',
            'password' => 'Password1',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_login_fails_when_alumni_not_found(): void
    {
        $alumni = Alumni::factory()->create();
        User::factory()->create([
            'email' => 'orphan@test.com',
            'password' => Hash::make('Password1'),
            'alumni_id' => $alumni->id,
        ]);
        $alumni->delete();

        $this->post(route('member.login.store'), [
            'email' => 'orphan@test.com',
            'password' => 'Password1',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_login_fails_when_membership_inactive(): void
    {
        $type = MembershipType::factory()->create();
        $alumni = Alumni::factory()->create();
        Membership::factory()->create([
            'alumni_id' => $alumni->id,
            'membership_type_id' => $type->id,
            'status' => 'suspended',
        ]);
        User::factory()->create([
            'email' => 'suspended@test.com',
            'password' => Hash::make('Password1'),
            'alumni_id' => $alumni->id,
        ]);

        $this->post(route('member.login.store'), [
            'email' => 'suspended@test.com',
            'password' => 'Password1',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_login_fails_when_no_membership(): void
    {
        $alumni = Alumni::factory()->create();
        User::factory()->create([
            'email' => 'nomem@test.com',
            'password' => Hash::make('Password1'),
            'alumni_id' => $alumni->id,
        ]);

        $this->post(route('member.login.store'), [
            'email' => 'nomem@test.com',
            'password' => 'Password1',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_successful_login(): void
    {
        $data = $this->createActiveMemberWithUser();

        $this->post(route('member.login.store'), [
            'email' => 'member@test.com',
            'password' => 'Password1',
        ])->assertRedirect(route('member.dashboard'));

        $this->assertAuthenticatedAs($data['user']);
    }

    public function test_login_with_remember_me(): void
    {
        $data = $this->createActiveMemberWithUser();

        $this->post(route('member.login.store'), [
            'email' => 'member@test.com',
            'password' => 'Password1',
            'remember' => 'on',
        ]);

        $this->assertAuthenticatedAs($data['user']);
    }

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function test_logout_destroys_session(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->delete(route('member.logout'))
            ->assertRedirect(route('member.login'));

        $this->assertGuest();
    }

    /*
    |--------------------------------------------------------------------------
    | Password Change
    |--------------------------------------------------------------------------
    */

    public function test_password_form_requires_auth(): void
    {
        $this->get(route('member.security'))
            ->assertRedirect(route('member.login'));
    }

    public function test_password_form_is_accessible(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.security'))
            ->assertOk()
            ->assertSee('Security & Account');
    }

    public function test_password_update_requires_current_password(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->put(route('member.security.password.update'), [
            'current_password' => '',
            'password' => 'NewPass1',
            'password_confirmation' => 'NewPass1',
        ])->assertSessionHasErrors('current_password');
    }

    public function test_password_update_requires_correct_current_password(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->put(route('member.security.password.update'), [
            'current_password' => 'wrong',
            'password' => 'NewPass1',
            'password_confirmation' => 'NewPass1',
        ])->assertSessionHasErrors('current_password');
    }

    public function test_password_update_requires_strong_new_password(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->put(route('member.security.password.update'), [
            'current_password' => 'Password1',
            'password' => 'weak',
            'password_confirmation' => 'weak',
        ])->assertSessionHasErrors('password');
    }

    public function test_password_update_requires_confirmation_match(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->put(route('member.security.password.update'), [
            'current_password' => 'Password1',
            'password' => 'NewPass1',
            'password_confirmation' => 'mismatch',
        ])->assertSessionHasErrors('password');
    }

    public function test_successful_password_update(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->put(route('member.security.password.update'), [
            'current_password' => 'Password1',
            'password' => 'NewPass1',
            'password_confirmation' => 'NewPass1',
        ])->assertRedirect(route('member.security'))
            ->assertSessionHas('success');

        $this->assertTrue(Hash::check('NewPass1', $data['user']->fresh()->password));
    }

    /*
    |--------------------------------------------------------------------------
    | Member Middleware
    |--------------------------------------------------------------------------
    */

    public function test_guest_redirected_to_member_login(): void
    {
        $this->get(route('member.dashboard'))
            ->assertRedirect(route('member.login'));
    }

    public function test_admin_user_without_alumni_cannot_access_member_area(): void
    {
        $admin = User::factory()->admin()->create(['alumni_id' => null]);
        $this->actingAs($admin);

        $this->get(route('member.dashboard'))
            ->assertRedirect(route('member.login'));
    }

    public function test_user_with_inactive_membership_cannot_access_member_area(): void
    {
        $type = MembershipType::factory()->create();
        $alumni = Alumni::factory()->create();
        Membership::factory()->create([
            'alumni_id' => $alumni->id,
            'membership_type_id' => $type->id,
            'status' => 'suspended',
        ]);
        $user = User::factory()->create([
            'alumni_id' => $alumni->id,
            'email' => 'suspended@test.com',
        ]);

        $this->actingAs($user);

        $this->get(route('member.dashboard'))
            ->assertRedirect(route('member.account-status'));
    }

    public function test_active_member_can_access_dashboard(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.dashboard'))
            ->assertOk()
            ->assertSee('Member Dashboard');
    }

    public function test_active_member_can_access_profile(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.profile'))
            ->assertOk()
            ->assertSee('My Profile');
    }

    public function test_active_member_can_access_membership(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.membership'))
            ->assertOk()
            ->assertSee('Membership Details');
    }

    public function test_active_member_can_access_payments(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.payments'))
            ->assertOk()
            ->assertSee('Payment History');
    }

    public function test_active_member_can_access_applications(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.applications'))
            ->assertOk()
            ->assertSee('Applications');
    }

    public function test_active_member_can_access_password_form(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.security'))
            ->assertOk()
            ->assertSee('Security & Account');
    }

    /*
    |--------------------------------------------------------------------------
    | Profile View & Edit
    |--------------------------------------------------------------------------
    */

    public function test_profile_shows_alumni_info(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.profile'))
            ->assertOk()
            ->assertSee('Test Member')
            ->assertSee('KNGC-2024-001');
    }

    public function test_profile_edit_form_is_accessible(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.profile.edit'))
            ->assertOk()
            ->assertSee('Edit Profile');
    }

    public function test_profile_update_requires_valid_phone(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->put(route('member.profile.update'), [
            'phone' => str_repeat('1', 21),
        ])->assertSessionHasErrors('phone');
    }

    public function test_profile_update_succeeds(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->put(route('member.profile.update'), [
            'email' => $data['user']->email,
            'phone' => '1234567890',
            'city' => 'Dhaka',
            'country' => 'Bangladesh',
            'bio' => 'Hello world',
        ])->assertRedirect(route('member.profile'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('alumni', [
            'id' => $data['alumni']->id,
            'phone' => '1234567890',
            'city' => 'Dhaka',
            'country' => 'Bangladesh',
            'bio' => 'Hello world',
        ]);
    }

    public function test_profile_update_clears_photo(): void
    {
        $data = $this->createActiveMemberWithUser();
        $data['alumni']->update(['profile_photo' => 'profile-photos/test.jpg']);
        $this->actingAs($data['user']);

        $this->put(route('member.profile.update'), [
            'email' => $data['user']->email,
            'remove_photo' => '1',
        ])->assertRedirect(route('member.profile'));

        $this->assertNull($data['alumni']->fresh()->profile_photo);
    }

    /*
    |--------------------------------------------------------------------------
    | Membership Info
    |--------------------------------------------------------------------------
    */

    public function test_membership_shows_details(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.membership'))
            ->assertOk()
            ->assertSee('EDAA-000001')
            ->assertSee('Regular')
            ->assertSee('Silver');
    }

    public function test_membership_shows_active_status(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.membership'))
            ->assertOk()
            ->assertSee('Active');
    }

    /*
    |--------------------------------------------------------------------------
    | Payment History
    |--------------------------------------------------------------------------
    */

    public function test_payments_page_shows_empty_state(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.payments'))
            ->assertOk()
            ->assertSee('No payments have been recorded');
    }

    public function test_payments_page_shows_records(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        Payment::factory()->create([
            'membership_id' => $data['membership']->id,
            'amount' => 5000,
            'status' => 'paid',
            'paid_at' => now()->subDays(5),
        ]);

        $this->get(route('member.payments'))
            ->assertOk()
            ->assertSee('5,000')
            ->assertSee('Paid');
    }

    /*
    |--------------------------------------------------------------------------
    | Application History
    |--------------------------------------------------------------------------
    */

    public function test_applications_page_shows_empty_state(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.applications'))
            ->assertOk()
            ->assertSee('applications yet');
    }

    /*
    |--------------------------------------------------------------------------
    | Public Visibility Toggle
    |--------------------------------------------------------------------------
    */

    public function test_visibility_toggle_requires_auth(): void
    {
        $this->patch(route('member.visibility.toggle'))
            ->assertRedirect(route('member.login'));
    }

    public function test_visibility_toggle_flips_is_public(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->assertTrue($data['membership']->fresh()->is_public);

        $this->patch(route('member.visibility.toggle'))
            ->assertRedirect();

        $this->assertFalse($data['membership']->fresh()->is_public);

        $this->patch(route('member.visibility.toggle'))
            ->assertRedirect();

        $this->assertTrue($data['membership']->fresh()->is_public);
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard Content
    |--------------------------------------------------------------------------
    */

    public function test_dashboard_shows_stats(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.dashboard'))
            ->assertOk()
            ->assertSee('Welcome back')
            ->assertSee('Active');
    }

    public function test_dashboard_shows_quick_actions(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.dashboard'))
            ->assertOk()
            ->assertSee('My Profile')
            ->assertSee('Membership');
    }

    public function test_dashboard_shows_empty_payments(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.dashboard'))
            ->assertOk()
            ->assertSee('No recent activity yet');
    }

    /*
    |--------------------------------------------------------------------------
    | Sidebar Navigation
    |--------------------------------------------------------------------------
    */

    public function test_sidebar_links_are_present(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.dashboard'))
            ->assertOk()
            ->assertSee(route('member.dashboard'))
            ->assertSee(route('member.profile'))
            ->assertSee(route('member.membership'))
            ->assertSee(route('member.payments'))
            ->assertSee(route('member.applications'))
            ->assertSee(route('member.security'));
    }

    public function test_sidebar_has_sign_out_button(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('member.dashboard'))
            ->assertOk()
            ->assertSee('Sign Out');
    }

    /*
    |--------------------------------------------------------------------------
    | Public Pages Still Work
    |--------------------------------------------------------------------------
    */

    public function test_public_pages_still_work_with_member_routes(): void
    {
        $this->get(route('home'))->assertOk();
        $this->get(route('about'))->assertOk();
        $this->get(route('members.index'))->assertOk();
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Auth Still Works
    |--------------------------------------------------------------------------
    */

    public function test_admin_auth_unaffected(): void
    {
        $this->get(route('admin.login'))
            ->assertOk()
            ->assertSee('Admin Panel');
    }

    public function test_admin_login_still_works(): void
    {
        $admin = User::factory()->admin()->create([
            'email' => 'admin@test.com',
            'password' => Hash::make('Admin1'),
        ]);

        $this->post(route('admin.login.store'), [
            'email' => 'admin@test.com',
            'password' => 'Admin1',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);
    }

    /*
    |--------------------------------------------------------------------------
    | Guest Redirect Logic
    |--------------------------------------------------------------------------
    */

    public function test_guest_on_admin_route_redirected_to_admin_login(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_guest_on_member_route_redirected_to_member_login(): void
    {
        $this->get(route('member.dashboard'))
            ->assertRedirect(route('member.login'));
    }

    /*
    |--------------------------------------------------------------------------
    | Edge Cases
    |--------------------------------------------------------------------------
    */

    public function test_member_cannot_access_admin_routes(): void
    {
        $data = $this->createActiveMemberWithUser();
        $this->actingAs($data['user']);

        $this->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_cannot_access_member_routes_without_alumni(): void
    {
        $admin = User::factory()->admin()->create(['alumni_id' => null]);
        $this->actingAs($admin);

        $this->get(route('member.dashboard'))
            ->assertRedirect(route('member.login'));
    }

    public function test_csrf_token_present_on_member_forms(): void
    {
        $this->get(route('member.login'))->assertSee('_token');
        $this->get(route('member.register'))->assertSee('_token');
    }
}
