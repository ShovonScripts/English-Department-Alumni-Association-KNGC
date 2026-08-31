<?php

namespace Tests\Feature;

use App\Enums\ApplicationStatus;
use App\Models\Alumni;
use App\Models\FeePlan;
use App\Models\Membership;
use App\Models\MembershipApplication;
use App\Models\MembershipTier;
use App\Models\MembershipType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MembershipApplicationTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
    }

    // ──────────────────────────────────────────────────────────────
    // HELPERS
    // ──────────────────────────────────────────────────────────────

    protected function validApplicationData(array $overrides = []): array
    {
        return array_merge([
            'full_name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+8801712345678',
            'student_id' => null,
            'batch' => null,
            'graduation_year' => null,
            'current_organization' => null,
            'profession' => null,
            'current_designation' => null,
            'address' => null,
            'city' => null,
            'country' => null,
            'date_of_birth' => null,
            'application_message' => null,
        ], $overrides);
    }

    protected function createMembershipType(array $overrides = []): MembershipType
    {
        return MembershipType::create(array_merge([
            'name' => 'General Member',
            'slug' => 'general-member',
            'is_active' => true,
            'sort_order' => 1,
        ], $overrides));
    }

    protected function createMembershipTier(array $overrides = []): MembershipTier
    {
        return MembershipTier::create(array_merge([
            'name' => 'Bronze',
            'slug' => 'bronze',
            'badge_label' => 'Bronze',
            'is_active' => true,
            'sort_order' => 1,
        ], $overrides));
    }

    protected function submitApplication(array $overrides = [])
    {
        return $this->post(route('membership.apply.store'), $this->validApplicationData($overrides));
    }

    protected function getStatusToken(MembershipApplication $application): string
    {
        return MembershipApplication::generateStatusToken();
    }

    // ──────────────────────────────────────────────────────────────
    // PUBLIC MEMBERSHIP PAGE
    // ──────────────────────────────────────────────────────────────

    public function test_membership_page_returns_200(): void
    {
        $this->get(route('membership'))->assertOk();
    }

    public function test_membership_page_shows_active_types(): void
    {
        $active = $this->createMembershipType(['name' => 'Active Type', 'is_active' => true, 'sort_order' => 1]);
        $inactive = $this->createMembershipType(['name' => 'Inactive Type', 'is_active' => false, 'sort_order' => 2, 'slug' => 'inactive-type']);

        $response = $this->get(route('membership'));
        $response->assertSee('Active Type');
        $response->assertDontSee('Inactive Type');
    }

    public function test_membership_page_shows_active_tiers(): void
    {
        $active = $this->createMembershipTier(['name' => 'Gold Tier', 'is_active' => true]);
        $inactive = MembershipTier::create([
            'name' => 'Hidden Tier',
            'slug' => 'hidden-tier',
            'badge_label' => 'Hidden Tier',
            'is_active' => false,
            'sort_order' => 99,
        ]);

        $response = $this->get(route('membership'));
        $response->assertSee('Gold Tier');
        $response->assertDontSee('Hidden Tier');
    }

    public function test_membership_page_shows_current_fee_plans(): void
    {
        $type = $this->createMembershipType();
        $plan = FeePlan::factory()->current()->create([
            'membership_type_id' => $type->id,
            'name' => 'Annual Fee',
            'amount' => 5000,
        ]);

        $response = $this->get(route('membership'));
        $response->assertSee('Annual Fee');
        $response->assertSee('৳5,000');
    }

    public function test_membership_page_excludes_expired_fee_plans(): void
    {
        $type = $this->createMembershipType();
        FeePlan::factory()->expired()->create([
            'membership_type_id' => $type->id,
            'name' => 'Old Expired Plan',
        ]);

        $response = $this->get(route('membership'));
        $response->assertDontSee('Old Expired Plan');
    }

    public function test_membership_page_has_apply_link(): void
    {
        $response = $this->get(route('membership'));
        $response->assertSee(route('membership.apply'));
    }

    // ──────────────────────────────────────────────────────────────
    // PUBLIC APPLICATION FORM
    // ──────────────────────────────────────────────────────────────

    public function test_apply_page_returns_200(): void
    {
        $this->get(route('membership.apply'))->assertOk();
    }

    public function test_apply_page_shows_membership_info(): void
    {
        $response = $this->get(route('membership.apply'));
        $response->assertSee('Apply for Membership');
        $response->assertSee('Before you begin');
    }

    public function test_apply_page_has_noindex(): void
    {
        $response = $this->get(route('membership.apply'));
        $response->assertSee('noindex, nofollow');
    }

    // ──────────────────────────────────────────────────────────────
    // VALIDATION
    // ──────────────────────────────────────────────────────────────

    public function test_apply_requires_full_name(): void
    {
        $this->from(route('membership.apply'))
            ->post(route('membership.apply.store'), $this->validApplicationData(['full_name' => '']))
            ->assertSessionHasErrors('full_name');
        $this->assertDatabaseCount('membership_applications', 0);
    }

    public function test_apply_requires_valid_email(): void
    {
        $this->from(route('membership.apply'))
            ->post(route('membership.apply.store'), $this->validApplicationData(['email' => 'not-an-email']))
            ->assertSessionHasErrors('email');
        $this->assertDatabaseCount('membership_applications', 0);
    }

    public function test_apply_requires_phone(): void
    {
        $this->from(route('membership.apply'))
            ->post(route('membership.apply.store'), $this->validApplicationData(['phone' => '']))
            ->assertSessionHasErrors('phone');
        $this->assertDatabaseCount('membership_applications', 0);
    }

    public function test_apply_does_not_accept_membership_type(): void
    {
        // membership_type_id is no longer part of the public form.
        // Sending it should be silently ignored (not validated, not stored).
        $type = $this->createMembershipType();

        $this->post(route('membership.apply.store'), $this->validApplicationData([
            'membership_type_id' => $type->id,
        ]))->assertRedirect();

        $app = MembershipApplication::first();
        $this->assertNull($app->membership_type_id);
    }

    public function test_apply_does_not_accept_requested_tier(): void
    {
        // requested_tier_id is no longer part of the public form.
        $tier = $this->createMembershipTier();

        $this->post(route('membership.apply.store'), $this->validApplicationData([
            'requested_tier_id' => $tier->id,
        ]))->assertRedirect();

        $app = MembershipApplication::first();
        $this->assertNull($app->requested_tier_id);
    }

    public function test_apply_validates_graduation_year_range(): void
    {
        $this->from(route('membership.apply'))
            ->post(route('membership.apply.store'), $this->validApplicationData(['graduation_year' => 1950]))
            ->assertSessionHasErrors('graduation_year');

        $this->from(route('membership.apply'))
            ->post(route('membership.apply.store'), $this->validApplicationData(['graduation_year' => (int) date('Y') + 5]))
            ->assertSessionHasErrors('graduation_year');
    }

    public function test_apply_validates_date_of_birth_not_future(): void
    {
        $this->from(route('membership.apply'))
            ->post(route('membership.apply.store'), $this->validApplicationData([
                'date_of_birth' => now()->addYear()->toDateString(),
            ]))->assertSessionHasErrors('date_of_birth');
    }

    public function test_apply_preserves_old_input_on_failure(): void
    {
        $response = $this->from(route('membership.apply'))
            ->post(route('membership.apply.store'), $this->validApplicationData(['full_name' => '', 'email' => 'bad']));
        $response->assertSessionHasInput('email', 'bad');
        $response->assertSessionHasInput('phone', '+8801712345678');
    }

    public function test_apply_has_csrf_protection(): void
    {
        // Laravel disables VerifyCsrfToken in testing by default.
        // Verify the form has a CSRF token field in the page source.
        $response = $this->get(route('membership.apply'));
        $response->assertSee('csrf-token');
    }

    // ──────────────────────────────────────────────────────────────
    // HONEYPOT
    // ──────────────────────────────────────────────────────────────

    public function test_honeypot_blocks_bots(): void
    {
        $this->post(route('membership.apply.store'), $this->validApplicationData([
            'website' => 'http://bot.example.com',
        ]))->assertRedirect(route('membership.apply'));

        $this->assertDatabaseCount('membership_applications', 0);
    }

    // ──────────────────────────────────────────────────────────────
    // SUCCESSFUL SUBMISSION
    // ──────────────────────────────────────────────────────────────

    public function test_successful_application_submission(): void
    {
        $this->post(route('membership.apply.store'), $this->validApplicationData())
            ->assertRedirect();

        $this->assertDatabaseHas('membership_applications', [
            'full_name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+8801712345678',
            'status' => ApplicationStatus::Pending->value,
        ]);
    }

    public function test_application_number_is_generated(): void
    {
        $this->submitApplication();

        $app = MembershipApplication::first();
        $this->assertNotNull($app);
        $this->assertStringStartsWith('EDAA-APP-', $app->application_number);
        $this->assertNotNull($app->submitted_at);
        $this->assertNull($app->reviewed_by);
    }

    public function test_application_number_is_unique(): void
    {
        // Create an existing application to set the sequence.
        MembershipApplication::factory()->create(['application_number' => 'EDAA-APP-000005']);

        $num = MembershipApplication::generateApplicationNumber();
        $this->assertNotSame('EDAA-APP-000005', $num);
        $this->assertStringStartsWith('EDAA-APP-', $num);
    }

    public function test_status_token_is_hashed(): void
    {
        $this->submitApplication();

        $app = MembershipApplication::first();
        $this->assertNotNull($app->status_token_hash);
        $this->assertMatchesRegularExpression('/^[a-f0-9]{64}$/', $app->status_token_hash);
    }

    public function test_redirect_contains_status_token(): void
    {
        $response = $this->submitApplication();
        $response->assertRedirect();
        $response->assertRedirectContains('/membership/application/');
    }

    // ──────────────────────────────────────────────────────────────
    // STATUS PAGE
    // ──────────────────────────────────────────────────────────────

    public function test_status_page_requires_valid_token(): void
    {
        $app = MembershipApplication::factory()->create([
            'status_token_hash' => MembershipApplication::hashStatusToken('correct-token'),
        ]);

        $this->get(route('membership.application.status', [$app->application_number, 'wrong-token']))
            ->assertNotFound();
    }

    public function test_status_page_shows_application_info(): void
    {
        $token = 'my-valid-status-token-12345';
        $type = MembershipType::factory()->create();
        $app = MembershipApplication::factory()->create([
            'full_name' => 'Jane Smith',
            'membership_type_id' => $type->id,
            'status_token_hash' => MembershipApplication::hashStatusToken($token),
        ]);

        $response = $this->get(route('membership.application.status', [$app->application_number, $token]));
        $response->assertOk();
        $response->assertSee($app->application_number);
        $response->assertSee($app->membershipType->name);
    }

    public function test_status_page_has_noindex(): void
    {
        $token = 'status-noindex-token';
        $app = MembershipApplication::factory()->create([
            'status_token_hash' => MembershipApplication::hashStatusToken($token),
        ]);

        $response = $this->get(route('membership.application.status', [$app->application_number, $token]));
        $response->assertSee('noindex, nofollow');
    }

    public function test_status_page_does_not_expose_admin_notes(): void
    {
        $token = 'status-secure-token';
        $app = MembershipApplication::factory()->create([
            'admin_notes' => 'SECRET-ADMIN-NOTE-XYZ',
            'status_token_hash' => MembershipApplication::hashStatusToken($token),
        ]);

        $this->get(route('membership.application.status', [$app->application_number, $token]))
            ->assertDontSee('SECRET-ADMIN-NOTE-XYZ');
    }

    public function test_status_page_does_not_expose_rejection_reason_by_default(): void
    {
        $token = 'status-reject-token';
        $app = MembershipApplication::factory()->create([
            'rejection_reason' => 'CONFIDENTIAL-REJECTION-REASON',
            'status_token_hash' => MembershipApplication::hashStatusToken($token),
        ]);

        $this->get(route('membership.application.status', [$app->application_number, $token]))
            ->assertDontSee('CONFIDENTIAL-REJECTION-REASON');
    }

    // ──────────────────────────────────────────────────────────────
    // DUPLICATE PROTECTION
    // ──────────────────────────────────────────────────────────────

    public function test_pending_application_blocks_duplicate(): void
    {
        MembershipApplication::factory()->pending()->create([
            'email' => 'dup@example.com',
        ]);

        $this->post(route('membership.apply.store'), $this->validApplicationData([
            'email' => 'dup@example.com',
        ]))->assertSessionHasErrors('email');

        $this->assertDatabaseCount('membership_applications', 1);
    }

    public function test_under_review_application_blocks_duplicate(): void
    {
        MembershipApplication::factory()->underReview()->create([
            'email' => 'review@example.com',
        ]);

        $this->post(route('membership.apply.store'), $this->validApplicationData([
            'email' => 'review@example.com',
        ]))->assertSessionHasErrors('email');

        $this->assertDatabaseCount('membership_applications', 1);
    }

    public function test_rejected_application_allows_reapply(): void
    {
        MembershipApplication::factory()->rejected()->create([
            'email' => 'rejected@example.com',
        ]);

        $this->post(route('membership.apply.store'), $this->validApplicationData([
            'email' => 'rejected@example.com',
        ]))->assertRedirect();

        $this->assertDatabaseCount('membership_applications', 2);
    }

    public function test_cancelled_application_allows_reapply(): void
    {
        MembershipApplication::factory()->create([
            'email' => 'cancelled@example.com',
            'status' => ApplicationStatus::Cancelled,
        ]);

        $this->post(route('membership.apply.store'), $this->validApplicationData([
            'email' => 'cancelled@example.com',
        ]))->assertRedirect();

        $this->assertDatabaseCount('membership_applications', 2);
    }

    public function test_active_membership_blocks_application(): void
    {
        $alumni = Alumni::factory()->create(['email' => 'member@example.com']);
        Membership::factory()->active()->create(['alumni_id' => $alumni->id]);

        $this->post(route('membership.apply.store'), $this->validApplicationData([
            'email' => 'member@example.com',
        ]))->assertSessionHasErrors('email');

        $this->assertDatabaseCount('membership_applications', 0);
    }

    // ──────────────────────────────────────────────────────────────
    // RATE LIMITING
    // ──────────────────────────────────────────────────────────────

    public function test_rate_limiting_after_multiple_submissions(): void
    {
        // Rate limiter is per IP+email. Submit 3 times with the same email.
        // 1st succeeds, 2nd+3rd fail with duplicate protection but still hit the rate limiter.
        for ($i = 0; $i < 3; $i++) {
            $this->post(route('membership.apply.store'), $this->validApplicationData([
                'email' => 'ratelimit@example.com',
            ]));
        }

        // 4th attempt should be rate-limited.
        $response = $this->post(route('membership.apply.store'), $this->validApplicationData([
            'email' => 'ratelimit@example.com',
        ]));

        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString('Too many', $response->getSession()->get('errors')->first('email'));
    }

    // ──────────────────────────────────────────────────────────────
    // ADMIN AUTH
    // ──────────────────────────────────────────────────────────────

    public function test_admin_index_requires_login(): void
    {
        $this->get(route('admin.membership-applications.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_admin_index_requires_admin(): void
    {
        $nonAdmin = User::factory()->create();
        $this->actingAs($nonAdmin)
            ->get(route('admin.membership-applications.index'))
            ->assertForbidden();
    }

    public function test_admin_show_requires_login(): void
    {
        $app = MembershipApplication::factory()->create();
        $this->get(route('admin.membership-applications.show', $app))
            ->assertRedirect(route('admin.login'));
    }

    public function test_admin_review_requires_admin(): void
    {
        $app = MembershipApplication::factory()->create();
        $nonAdmin = User::factory()->create();
        $this->actingAs($nonAdmin)
            ->post(route('admin.membership-applications.review', $app), ['status' => 'under_review'])
            ->assertForbidden();
    }

    public function test_admin_approve_requires_admin(): void
    {
        $app = MembershipApplication::factory()->create();
        $nonAdmin = User::factory()->create();
        $this->actingAs($nonAdmin)
            ->post(route('admin.membership-applications.approve', $app))
            ->assertForbidden();
    }

    // ──────────────────────────────────────────────────────────────
    // ADMIN INDEX
    // ──────────────────────────────────────────────────────────────

    public function test_admin_index_returns_200(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.membership-applications.index'))
            ->assertOk();
    }

    public function test_admin_index_shows_applications(): void
    {
        $app = MembershipApplication::factory()->create([
            'full_name' => 'Index Visible Applicant',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.membership-applications.index'));
        $response->assertOk();
        $response->assertSee('Index Visible Applicant');
    }

    public function test_admin_index_search(): void
    {
        $match = MembershipApplication::factory()->create(['full_name' => 'Alice Searchable']);
        $other = MembershipApplication::factory()->create(['full_name' => 'Bob Hidden']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.membership-applications.index', ['q' => 'Alice']));
        $response->assertSee('Alice Searchable');
        $response->assertDontSee('Bob Hidden');
    }

    public function test_admin_index_filter_by_status(): void
    {
        $pending = MembershipApplication::factory()->pending()->create(['full_name' => 'Pending One']);
        $rejected = MembershipApplication::factory()->rejected()->create(['full_name' => 'Rejected One']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.membership-applications.index', ['status' => 'pending']));
        $response->assertSee('Pending One');
        $response->assertDontSee('Rejected One');
    }

    public function test_admin_index_empty_state(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.membership-applications.index'));
        $response->assertOk();
        $response->assertSee('No applications found');
    }

    // ──────────────────────────────────────────────────────────────
    // ADMIN SHOW
    // ──────────────────────────────────────────────────────────────

    public function test_admin_show_returns_200(): void
    {
        $app = MembershipApplication::factory()->create();
        $this->actingAs($this->admin)
            ->get(route('admin.membership-applications.show', $app))
            ->assertOk();
    }

    public function test_admin_show_displays_applicant_info(): void
    {
        $app = MembershipApplication::factory()->create([
            'full_name' => 'Show Test Applicant',
            'email' => 'show-test@example.com',
            'phone' => '+8801999999999',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.membership-applications.show', $app));
        $response->assertSee('Show Test Applicant');
        $response->assertSee('show-test@example.com');
        $response->assertSee('+8801999999999');
    }

    // ──────────────────────────────────────────────────────────────
    // ADMIN REVIEW WORKFLOW
    // ──────────────────────────────────────────────────────────────

    public function test_mark_under_review(): void
    {
        $app = MembershipApplication::factory()->pending()->create();

        $this->actingAs($this->admin)
            ->post(route('admin.membership-applications.review', $app), [
                'status' => 'under_review',
            ])->assertRedirect();

        $app->refresh();
        $this->assertSame(ApplicationStatus::UnderReview, $app->status);
    }

    public function test_request_changes(): void
    {
        $app = MembershipApplication::factory()->pending()->create();

        $this->actingAs($this->admin)
            ->post(route('admin.membership-applications.review', $app), [
                'status' => 'changes_requested',
                'admin_notes' => 'Please update your graduation year.',
            ])->assertRedirect();

        $app->refresh();
        $this->assertSame(ApplicationStatus::ChangesRequested, $app->status);
        $this->assertSame('Please update your graduation year.', $app->admin_notes);
    }

    public function test_request_changes_requires_notes(): void
    {
        $app = MembershipApplication::factory()->pending()->create();

        $this->actingAs($this->admin)
            ->post(route('admin.membership-applications.review', $app), [
                'status' => 'changes_requested',
            ])->assertSessionHasErrors('admin_notes');
    }

    public function test_reject_application(): void
    {
        $app = MembershipApplication::factory()->pending()->create();

        $this->actingAs($this->admin)
            ->post(route('admin.membership-applications.review', $app), [
                'status' => 'rejected',
                'rejection_reason' => 'Incomplete documentation.',
            ])->assertRedirect();

        $app->refresh();
        $this->assertSame(ApplicationStatus::Rejected, $app->status);
        $this->assertSame('Incomplete documentation.', $app->rejection_reason);
    }

    public function test_reject_requires_reason(): void
    {
        $app = MembershipApplication::factory()->pending()->create();

        $this->actingAs($this->admin)
            ->post(route('admin.membership-applications.review', $app), [
                'status' => 'rejected',
            ])->assertSessionHasErrors('rejection_reason');
    }

    public function test_cannot_transition_from_approved(): void
    {
        $app = MembershipApplication::factory()->approved()->create();

        $this->actingAs($this->admin)
            ->post(route('admin.membership-applications.review', $app), [
                'status' => 'rejected',
                'rejection_reason' => 'Trying to reject an approved app.',
            ])->assertSessionHasErrors('status');

        $app->refresh();
        $this->assertSame(ApplicationStatus::Approved, $app->status);
    }

    public function test_review_sets_reviewed_by_and_reviewed_at(): void
    {
        $app = MembershipApplication::factory()->pending()->create();

        $this->actingAs($this->admin)
            ->post(route('admin.membership-applications.review', $app), [
                'status' => 'under_review',
            ]);

        $app->refresh();
        $this->assertSame($this->admin->id, $app->reviewed_by);
        $this->assertNotNull($app->reviewed_at);
    }

    // ──────────────────────────────────────────────────────────────
    // ADMIN APPROVAL
    // ──────────────────────────────────────────────────────────────

    public function test_approve_creates_membership(): void
    {
        $type = $this->createMembershipType();
        $tier = $this->createMembershipTier();
        $app = MembershipApplication::factory()->pending()->create([
            'requested_tier_id' => $tier->id,
        ]);

        $this->actingAs($this->admin)
            ->post(route('admin.membership-applications.approve', $app), [
                'membership_type_id' => $type->id,
            ])->assertRedirect();

        $this->assertDatabaseHas('memberships', [
            'membership_type_id' => $type->id,
            'membership_tier_id' => $tier->id,
            'status' => Membership::STATUS_ACTIVE,
        ]);
    }

    public function test_approve_generates_membership_number(): void
    {
        $type = $this->createMembershipType();
        $app = MembershipApplication::factory()->pending()->create();

        $this->actingAs($this->admin)
            ->post(route('admin.membership-applications.approve', $app), [
                'membership_type_id' => $type->id,
            ]);

        $membership = Membership::first();
        $this->assertNotNull($membership);
        $this->assertMatchesRegularExpression('/^EDAA-\d{6}$/', $membership->membership_number);
    }

    public function test_approve_creates_alumni_if_not_exists(): void
    {
        $type = $this->createMembershipType();
        $app = MembershipApplication::factory()->pending()->create([
            'email' => 'newalumni@example.com',
        ]);

        $this->actingAs($this->admin)
            ->post(route('admin.membership-applications.approve', $app), [
                'membership_type_id' => $type->id,
            ]);

        $alumni = Alumni::whereRaw('LOWER(email) = ?', ['newalumni@example.com'])->first();
        $this->assertNotNull($alumni);
        $this->assertSame($app->full_name, $alumni->full_name);
    }

    public function test_approve_links_existing_alumni_by_email(): void
    {
        $type = $this->createMembershipType();
        $alumni = Alumni::factory()->create(['email' => 'existing@example.com']);
        $app = MembershipApplication::factory()->pending()->create([
            'email' => 'existing@example.com',
        ]);

        $this->actingAs($this->admin)
            ->post(route('admin.membership-applications.approve', $app), [
                'membership_type_id' => $type->id,
            ]);

        $alumni->refresh();
        $this->assertNotNull($alumni->membership);
    }

    public function test_approve_links_existing_alumni_by_student_id(): void
    {
        $type = $this->createMembershipType();
        $alumni = Alumni::factory()->create(['student_id' => 'STU-9876543210', 'email' => 'different@example.com']);
        $app = MembershipApplication::factory()->pending()->create([
            'student_id' => 'STU-9876543210',
            'email' => 'differentemail@example.com',
        ]);

        $this->actingAs($this->admin)
            ->post(route('admin.membership-applications.approve', $app), [
                'membership_type_id' => $type->id,
            ]);

        $membership = Membership::where('alumni_id', $alumni->id)->first();
        $this->assertNotNull($membership);
    }

    public function test_approve_sets_approved_at_and_joined_at(): void
    {
        $type = $this->createMembershipType();
        $app = MembershipApplication::factory()->pending()->create();

        $this->actingAs($this->admin)
            ->post(route('admin.membership-applications.approve', $app), [
                'membership_type_id' => $type->id,
            ]);

        $membership = Membership::first();
        $this->assertNotNull($membership);
        $this->assertNotNull($membership->approved_at);
        $this->assertNotNull($membership->joined_at);
    }

    public function test_approve_sets_status_active(): void
    {
        $type = $this->createMembershipType();
        $app = MembershipApplication::factory()->pending()->create();

        $this->actingAs($this->admin)
            ->post(route('admin.membership-applications.approve', $app), [
                'membership_type_id' => $type->id,
            ]);

        $membership = Membership::first();
        $this->assertSame(Membership::STATUS_ACTIVE, $membership->status);
    }

    public function test_approve_cannot_be_repeated(): void
    {
        $type = $this->createMembershipType();
        $app = MembershipApplication::factory()->approved()->create();

        $this->actingAs($this->admin)
            ->post(route('admin.membership-applications.approve', $app), [
                'membership_type_id' => $type->id,
            ])->assertSessionHasErrors('status');
    }

    public function test_approve_blocks_duplicate_membership(): void
    {
        $type = $this->createMembershipType();
        $alumni = Alumni::factory()->create(['email' => 'already-member@example.com']);
        Membership::factory()->active()->create(['alumni_id' => $alumni->id]);

        $app = MembershipApplication::factory()->pending()->create([
            'email' => 'already-member@example.com',
        ]);

        $this->actingAs($this->admin)
            ->post(route('admin.membership-applications.approve', $app), [
                'membership_type_id' => $type->id,
            ])->assertSessionHasErrors('status');

        $this->assertDatabaseCount('memberships', 1);
    }

    public function test_approve_sets_reviewed_by(): void
    {
        $type = $this->createMembershipType();
        $app = MembershipApplication::factory()->pending()->create();

        $this->actingAs($this->admin)
            ->post(route('admin.membership-applications.approve', $app), [
                'membership_type_id' => $type->id,
            ]);

        $app->refresh();
        $this->assertSame($this->admin->id, $app->reviewed_by);
    }

    public function test_approve_blocks_rejected_application(): void
    {
        $type = $this->createMembershipType();
        $app = MembershipApplication::factory()->rejected()->create();

        $this->actingAs($this->admin)
            ->post(route('admin.membership-applications.approve', $app), [
                'membership_type_id' => $type->id,
            ])->assertSessionHasErrors('status');

        $this->assertDatabaseCount('memberships', 0);
    }

    // ──────────────────────────────────────────────────────────────
    // FINANCE
    // ──────────────────────────────────────────────────────────────

    public function test_approval_does_not_create_payment(): void
    {
        $type = $this->createMembershipType();
        $app = MembershipApplication::factory()->pending()->create();

        $this->actingAs($this->admin)
            ->post(route('admin.membership-applications.approve', $app), [
                'membership_type_id' => $type->id,
            ]);

        $this->assertDatabaseCount('payments', 0);
    }

    public function test_public_pages_expose_no_financial_info(): void
    {
        $response = $this->get(route('membership'));
        $response->assertDontSee('৳');
        $response->assertDontSee('amount');
    }

    // ──────────────────────────────────────────────────────────────
    // REGRESSION
    // ──────────────────────────────────────────────────────────────

    public function test_public_application_does_not_expose_email(): void
    {
        $token = 'regression-email-token';
        $app = MembershipApplication::factory()->create([
            'email' => 'secret-email@test.com',
            'status_token_hash' => MembershipApplication::hashStatusToken($token),
        ]);

        $response = $this->get(route('membership.application.status', [
            $app->application_number,
            $token,
        ]));
        $response->assertDontSee('secret-email@test.com');
    }

    public function test_public_application_does_not_expose_phone(): void
    {
        $token = 'regression-phone-token';
        $app = MembershipApplication::factory()->create([
            'phone' => '+8801999999999',
            'status_token_hash' => MembershipApplication::hashStatusToken($token),
        ]);

        $response = $this->get(route('membership.application.status', [
            $app->application_number,
            $token,
        ]));
        $response->assertDontSee('+8801999999999');
    }
}
