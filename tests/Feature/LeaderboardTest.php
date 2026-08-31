<?php

namespace Tests\Feature;

use App\Enums\PaymentStatus;
use App\Models\Alumni;
use App\Models\FeePlan;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\MembershipType;
use App\Models\Payment;
use App\Models\SiteSetting;
use App\Models\User;
use App\Services\LeaderboardService;
use Database\Seeders\AlumniSeeder;
use Database\Seeders\FeePlanSeeder;
use Database\Seeders\MembershipSeeder;
use Database\Seeders\MembershipTierSeeder;
use Database\Seeders\MembershipTypeSeeder;
use Database\Seeders\PaymentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Feature 14 — Member Leaderboard & Verified Contribution Ranking.
 *
 * Verified contributions are derived exclusively from Payment::valid()
 * records (paid + partial); void and waived payments never count. The public
 * leaderboard only exposes eligible, opted-in members with a positive total,
 * and privacy is enforced at the query level.
 */
class LeaderboardTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create(['password' => Hash::make('password')]);
    }

    private function leaderboard(): LeaderboardService
    {
        return app(LeaderboardService::class);
    }

    /**
     * Create an alumni + membership + type + tier fixture.
     *
     * @param  array<string, mixed>  $overrides  membership overrides
     * @param  array<string, mixed>  $alumniOverrides  alumni overrides
     */
    private function member(string $name, array $overrides = [], array $alumniOverrides = []): Membership
    {
        $type = MembershipType::factory()->create();
        $tier = MembershipTier::factory()->create();

        $alumni = Alumni::factory()->create(array_merge([
            'full_name' => $name,
            'status' => Alumni::STATUS_ACTIVE,
            // Keep leaderboard fixtures out of the featured-alumni section on
            // the homepage, which renders independently of the leaderboard switch.
            'is_featured' => false,
        ], $alumniOverrides));

        return Membership::factory()->create(array_merge([
            'alumni_id' => $alumni->id,
            'membership_type_id' => $type->id,
            'membership_tier_id' => $tier->id,
            'status' => Membership::STATUS_ACTIVE,
            'is_public' => true,
            'show_on_leaderboard' => true,
        ], $overrides));
    }

    /**
     * Record a manual collection for a member with a deterministic plan.
     *
     * @param  array<string, mixed>  $overrides
     */
    private function contribute(Membership $membership, float $amount, string $status = PaymentStatus::Paid->value, array $overrides = []): Payment
    {
        $plan = FeePlan::factory()->inactive()->create(['membership_type_id' => $membership->membership_type_id]);

        return Payment::query()->create(array_merge([
            'membership_id' => $membership->id,
            'fee_plan_id' => $plan->id,
            'payment_number' => Payment::generatePaymentNumber(),
            'amount' => $amount,
            'currency' => 'BDT',
            'status' => $status,
            'paid_at' => now()->toDateString(),
            'reference' => 'Receipt-'.fake()->unique()->numberBetween(1000, 9999),
            'notes' => null,
            'recorded_by' => $this->admin->id,
        ], $overrides));
    }

    /** @param  array<string, string>  $query */
    private function publicResponse(array $query = [])
    {
        return $this->get(route('leaderboard.index', $query));
    }

    /*
    |--------------------------------------------------------------------------
    | Public access
    |--------------------------------------------------------------------------
    */

    public function test_public_leaderboard_returns_200_when_enabled(): void
    {
        $chidi = $this->member('Chidi Test');
        $this->contribute($chidi, 100);

        $this->publicResponse()
            ->assertOk()
            ->assertSee('Chidi Test')
            ->assertSee('Verified Contribution')
            ->assertSee('৳100');
    }

    public function test_public_leaderboard_uses_the_expected_page_title(): void
    {
        $this->publicResponse()
            ->assertOk()
            ->assertSee('Member Leaderboard | EDAA-KNGC');
    }

    public function test_public_navigation_shows_leaderboard_when_enabled(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('/leaderboard', escape: false);
    }

    public function test_disabled_leaderboard_hides_public_page_and_navigation(): void
    {
        $chidi = $this->member('Chidi Hidden Test');
        $this->contribute($chidi, 100);

        SiteSetting::set('leaderboard_public_enabled', false);

        $this->publicResponse()
            ->assertNotFound()
            ->assertDontSee('Chidi Hidden Test');

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('/leaderboard', escape: false)
            ->assertDontSee('Recognizing our contributors');
    }

    public function test_homepage_leaderboard_section_hidden_when_disabled(): void
    {
        $chidi = $this->member('Chidi Home Test');
        $this->contribute($chidi, 100);

        SiteSetting::set('leaderboard_public_enabled', false);

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('Recognizing our contributors');
    }

    public function test_homepage_leaderboard_section_shows_top_contributors_when_enabled(): void
    {
        $top = $this->member('Ada Top', alumniOverrides: ['batch' => '1990']);
        $second = $this->member('Bob Second', alumniOverrides: ['batch' => '1991']);
        $third = $this->member('Cam Third', alumniOverrides: ['batch' => '1992']);

        $this->contribute($top, 250);
        $this->contribute($second, 150);
        $this->contribute($third, 50);

        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertSee('Recognizing our contributors')
            ->assertSee('Ada Top')
            ->assertSee('Bob Second')
            ->assertSee('Cam Third')
            ->assertSee('View Full Leaderboard');

        $contributors = collect($response->viewData('topContributors'));
        $this->assertSame(['Ada Top', 'Bob Second', 'Cam Third'], $contributors->pluck('alumni_name')->all());
        $this->assertSame([1, 2, 3], $contributors->pluck('leaderboard_rank')->all());
        $this->assertSame(['৳250', '৳150', '৳50'], $contributors->pluck('formatted_contribution')->all());
    }

    /*
    |--------------------------------------------------------------------------
    | Eligibility
    |--------------------------------------------------------------------------
    */

    public function test_active_public_member_appears(): void
    {
        $member = $this->member('Active Public Member');
        $this->contribute($member, 50);

        $this->publicResponse()->assertOk()->assertSee('Active Public Member');
    }

    public function test_pending_member_excluded(): void
    {
        $member = $this->member('Pending Member', ['status' => Membership::STATUS_PENDING, 'approved_at' => null]);
        $this->contribute($member, 50);

        $this->publicResponse()->assertOk()->assertDontSee('Pending Member');
    }

    public function test_suspended_member_excluded(): void
    {
        $member = $this->member('Suspended Member', ['status' => Membership::STATUS_SUSPENDED]);
        $this->contribute($member, 50);

        $this->publicResponse()->assertOk()->assertDontSee('Suspended Member');
    }

    public function test_cancelled_member_excluded(): void
    {
        $member = $this->member('Cancelled Member', ['status' => Membership::STATUS_CANCELLED]);
        $this->contribute($member, 50);

        $this->publicResponse()->assertOk()->assertDontSee('Cancelled Member');
    }

    public function test_expired_member_excluded(): void
    {
        $member = $this->member('Expired Member', ['status' => Membership::STATUS_EXPIRED]);
        $this->contribute($member, 50);

        $this->publicResponse()->assertOk()->assertDontSee('Expired Member');
    }

    public function test_private_membership_excluded(): void
    {
        $member = $this->member('Private Member', ['is_public' => false]);
        $this->contribute($member, 50);

        $this->publicResponse()->assertOk()->assertDontSee('Private Member');
    }

    public function test_leaderboard_hidden_member_excluded(): void
    {
        $member = $this->member('Leaderboard Hidden Member', ['show_on_leaderboard' => false]);
        $this->contribute($member, 50);

        $this->publicResponse()->assertOk()->assertDontSee('Leaderboard Hidden Member');
    }

    public function test_zero_contribution_member_excluded_publicly(): void
    {
        $this->member('Zero Contribution Member');

        $this->publicResponse()->assertOk()->assertDontSee('Zero Contribution Member');
    }

    public function test_alumni_without_membership_excluded(): void
    {
        Alumni::factory()->create(['full_name' => 'Alumni Without Membership', 'status' => Alumni::STATUS_ACTIVE]);

        $this->publicResponse()->assertOk()->assertDontSee('Alumni Without Membership');
    }

    /*
    |--------------------------------------------------------------------------
    | Contribution calculation
    |--------------------------------------------------------------------------
    */

    public function test_paid_payment_counts(): void
    {
        $member = $this->member('Paid Member');
        $this->contribute($member, 50);

        $this->assertSame(50.0, $member->fresh()->verifiedContributionTotal());
        $this->publicResponse()->assertSee('Paid Member')->assertSee('৳50');
    }

    public function test_partial_payment_counts(): void
    {
        $member = $this->member('Partial Member');
        $this->contribute($member, 30, PaymentStatus::Partial->value);

        $this->assertSame(30.0, $member->fresh()->verifiedContributionTotal());
        $this->publicResponse()->assertSee('৳30');
    }

    public function test_multiple_payments_aggregate(): void
    {
        $member = $this->member('Multi Payment Member');
        $this->contribute($member, 30, PaymentStatus::Partial->value);
        $this->contribute($member, 20, PaymentStatus::Partial->value);

        $this->assertSame(50.0, $member->fresh()->verifiedContributionTotal());
        $this->assertSame(2, $member->fresh()->verifiedPaymentCount());

        $response = $this->publicResponse();
        $response->assertSee('Multi Payment Member')->assertSee('৳50');
        $response->assertDontSee('৳80');
    }

    public function test_void_payment_excluded(): void
    {
        $member = $this->member('Void Member');
        $this->contribute($member, 50);
        $this->contribute($member, 400, PaymentStatus::Void->value, [
            'payment_number' => 'EDAA-PAY-999999',
            'reference' => 'VOID-REF-001',
            'voided_at' => now(),
            'voided_by' => $this->admin->id,
            'void_reason' => 'Duplicate test record.',
        ]);

        $this->assertSame(50.0, $member->fresh()->verifiedContributionTotal());

        $this->publicResponse()
            ->assertSee('৳50')
            ->assertDontSee('৳450')
            ->assertDontSee('EDAA-PAY-999999')
            ->assertDontSee('VOID-REF-001');
    }

    public function test_waived_payment_excluded(): void
    {
        $member = $this->member('Waived Member');
        $this->contribute($member, 0, PaymentStatus::Waived->value, ['payment_number' => 'EDAA-PAY-888888']);

        $this->assertSame(0.0, $member->fresh()->verifiedContributionTotal());

        $this->publicResponse()
            ->assertDontSee('Waived Member')
            ->assertDontSee('EDAA-PAY-888888');
    }

    public function test_payments_from_another_member_are_not_included(): void
    {
        $first = $this->member('First Member');
        $second = $this->member('Second Member');

        $this->contribute($first, 100);
        $this->contribute($second, 50);

        $this->assertSame(100.0, $first->fresh()->verifiedContributionTotal());
        $this->assertSame(50.0, $second->fresh()->verifiedContributionTotal());

        $this->publicResponse()
            ->assertSee('First Member')
            ->assertSee('Second Member')
            ->assertDontSee('৳150');
    }

    /*
    |--------------------------------------------------------------------------
    | Ranking
    |--------------------------------------------------------------------------
    */

    public function test_highest_contribution_is_rank_one(): void
    {
        $low = $this->member('Low Member');
        $high = $this->member('High Member');

        $this->contribute($low, 10);
        $this->contribute($high, 500);

        $rows = $this->leaderboard()->publicPaginate()->getCollection();
        $this->assertSame('High Member', $rows->first()->alumni_name);
        $this->assertSame(1, $rows->first()->leaderboard_rank);
        $this->assertSame(500.0, $rows->first()->verified_total_float);
    }

    public function test_second_and_third_contributions_get_ranks_two_and_three(): void
    {
        $first = $this->member('Rank First');
        $second = $this->member('Rank Second');
        $third = $this->member('Rank Third');

        $this->contribute($first, 300);
        $this->contribute($second, 200);
        $this->contribute($third, 100);

        $ranks = $this->leaderboard()->publicPaginate()->getCollection()->pluck('leaderboard_rank', 'alumni_name');

        $this->assertSame(1, $ranks['Rank First']);
        $this->assertSame(2, $ranks['Rank Second']);
        $this->assertSame(3, $ranks['Rank Third']);
    }

    public function test_leaderboard_orders_by_total_descending(): void
    {
        $low = $this->member('Zulu Lower');
        $high = $this->member('Alpha Higher');

        $this->contribute($low, 5);
        $this->contribute($high, 95);
        $this->contribute($this->member('Middle Member'), 30);

        $rows = $this->publicResponse()->viewData('entries')->getCollection();

        $this->assertSame(['Alpha Higher', 'Middle Member', 'Zulu Lower'], $rows->pluck('alumni_name')->all());
        $this->assertSame([95.0, 30.0, 5.0], $rows->map(fn ($row) => $row->verified_total_float)->all());
    }

    public function test_equal_totals_are_ordered_deterministically_by_name(): void
    {
        $adam = $this->member('Adam Anders');
        $bob = $this->member('Bob Beater');

        $this->contribute($adam, 50);
        $this->contribute($bob, 50);

        $rows = $this->leaderboard()->publicPaginate()->getCollection();

        $this->assertSame('Adam Anders', $rows[0]->alumni_name);
        $this->assertSame('Bob Beater', $rows[1]->alumni_name);
        $this->assertSame($rows[0]->leaderboard_rank, $rows[1]->leaderboard_rank);
    }

    public function test_competition_ranking_shares_ties_and_skips_ranks(): void
    {
        $a = $this->member('A Member');
        $b = $this->member('B Member');
        $c = $this->member('C Member');
        $d = $this->member('D Member');

        $this->contribute($a, 10000);
        $this->contribute($b, 8000);
        $this->contribute($c, 8000);
        $this->contribute($d, 5000);

        $ranks = $this->leaderboard()->publicPaginate()->getCollection()->pluck('leaderboard_rank', 'alumni_name');

        $this->assertSame(1, $ranks['A Member']);
        $this->assertSame(2, $ranks['B Member']);
        $this->assertSame(2, $ranks['C Member']);
        $this->assertSame(4, $ranks['D Member']);
    }

    public function test_contribution_total_displayed_with_thousand_separators(): void
    {
        $member = $this->member('Thousand Member');
        $this->contribute($member, 25000);

        $this->publicResponse()->assertSee('৳25,000');
    }

    /*
    |--------------------------------------------------------------------------
    | Public privacy
    |--------------------------------------------------------------------------
    */

    public function test_public_leaderboard_never_exposes_payment_details(): void
    {
        $hidden = $this->member('Privacy Member');
        $payment = $this->contribute($hidden, 100, PaymentStatus::Paid->value, [
            'payment_number' => 'EDAA-PAY-000777',
            'reference' => 'CASH-RECEIPT-777',
            'notes' => 'INTERNAL-ADMIN-NOTE-SECRET',
            'paid_at' => '2019-07-15',
        ]);

        $response = $this->publicResponse();

        $response->assertOk()
            ->assertSee('Privacy Member')
            ->assertSee('৳100');

        $response->assertDontSee('EDAA-PAY-000777')
            ->assertDontSee('CASH-RECEIPT-777')
            ->assertDontSee('INTERNAL-ADMIN-NOTE-SECRET')
            ->assertDontSee('2019-07-15')
            ->assertDontSee($payment->payment_number, escape: false);
    }

    public function test_public_leaderboard_never_exposes_internal_membership_identifiers(): void
    {
        $member = $this->member('Id Privacy Member');
        $this->contribute($member, 50);

        $this->publicResponse()
            ->assertOk()
            ->assertSee('Id Privacy Member')
            ->assertDontSee($member->membership_number, escape: false);
    }

    public function test_public_leaderboard_hides_private_member_contributions(): void
    {
        $visible = $this->member('Visible Member');
        $private = $this->member('Private Member X', ['is_public' => false, 'show_on_leaderboard' => true]);

        $this->contribute($visible, 50);
        $this->contribute($private, 900);

        $response = $this->publicResponse();

        $response->assertOk()
            ->assertSee('Visible Member')
            ->assertDontSee('Private Member X');

        // The visible #1 must not leak a rank gap caused by the hidden record.
        $rows = $response->viewData('entries')->getCollection();
        $this->assertSame(1, $rows->first()->leaderboard_rank);
        $this->assertSame('Visible Member', $rows->first()->alumni_name);
    }

    public function test_public_alumni_profile_keeps_payment_history_private(): void
    {
        $member = $this->member('Profile Privacy Member');
        $this->contribute($member, 100, PaymentStatus::Paid->value, [
            'payment_number' => 'EDAA-PAY-000888',
            'reference' => 'SECRET-REF-888',
            'notes' => 'SECRET-NOTE-888',
        ]);

        $response = $this->get(route('alumni.show', $member->alumni->slug));

        $response->assertOk()
            ->assertSee('Profile Privacy Member')
            ->assertSee('Verified Contribution')
            ->assertDontSee('EDAA-PAY-000888')
            ->assertDontSee('SECRET-REF-888')
            ->assertDontSee('SECRET-NOTE-888');
    }

    /*
    |--------------------------------------------------------------------------
    | Filters & search (public)
    |--------------------------------------------------------------------------
    */

    public function test_membership_type_filter_works(): void
    {
        $general = $this->member('General Filtered Member');
        $honorary = $this->member('Honorary Filtered Member');

        $this->contribute($general, 50);
        $this->contribute($honorary, 50);

        $typeSlug = $general->type->slug;

        $this->publicResponse(['type' => $typeSlug])
            ->assertOk()
            ->assertSee('General Filtered Member')
            ->assertDontSee('Honorary Filtered Member');
    }

    public function test_tier_filter_works(): void
    {
        $gold = $this->member('Gold Filtered Member');
        $silver = $this->member('Silver Filtered Member');

        $this->contribute($gold, 50);
        $this->contribute($silver, 50);

        $tierSlug = $gold->tier->slug;

        $this->publicResponse(['tier' => $tierSlug])
            ->assertOk()
            ->assertSee('Gold Filtered Member')
            ->assertDontSee('Silver Filtered Member');
    }

    public function test_batch_filter_works(): void
    {
        $old = $this->member('Old Batch Member', [], ['batch' => '1990']);
        $new = $this->member('New Batch Member', [], ['batch' => '2010']);

        $this->contribute($old, 50);
        $this->contribute($new, 50);

        $this->publicResponse(['batch' => '1990'])
            ->assertOk()
            ->assertSee('Old Batch Member')
            ->assertDontSee('New Batch Member');
    }

    public function test_graduation_year_filter_works(): void
    {
        $old = $this->member('Old Grad Member', [], ['graduation_year' => 1995]);
        $new = $this->member('New Grad Member', [], ['graduation_year' => 2015]);

        $this->contribute($old, 50);
        $this->contribute($new, 50);

        $this->publicResponse(['graduation_year' => '2015'])
            ->assertOk()
            ->assertSee('New Grad Member')
            ->assertDontSee('Old Grad Member');
    }

    public function test_combined_filters_work_together(): void
    {
        $hit = $this->member('Combined Hit Member', [], ['batch' => '1990', 'graduation_year' => 1995]);
        $miss = $this->member('Combined Miss Member', [], ['batch' => '2000', 'graduation_year' => 2005]);

        $this->contribute($hit, 50);
        $this->contribute($miss, 50);

        $type = $hit->type->slug;
        $tier = $hit->tier->slug;

        $this->publicResponse(['type' => $type, 'tier' => $tier, 'batch' => '1990', 'graduation_year' => '1995'])
            ->assertOk()
            ->assertSee('Combined Hit Member')
            ->assertDontSee('Combined Miss Member');
    }

    public function test_public_search_by_name_works(): void
    {
        $target = $this->member('Zebulon Searchable Name');
        $other = $this->member('Irrelevant Other Name');

        $this->contribute($target, 50);
        $this->contribute($other, 50);

        $this->publicResponse(['q' => 'Zebulon'])
            ->assertOk()
            ->assertSee('Zebulon Searchable Name')
            ->assertDontSee('Irrelevant Other Name');
    }

    public function test_public_search_by_student_id_works(): void
    {
        $target = $this->member('Student Id Member', [], ['student_id' => 'EN-4400001']);
        $other = $this->member('Student Id Other', [], ['student_id' => 'EN-4400002']);

        $this->contribute($target, 50);
        $this->contribute($other, 50);

        $this->publicResponse(['q' => 'EN-4400001'])
            ->assertOk()
            ->assertSee('Student Id Member')
            ->assertDontSee('Student Id Other');
    }

    public function test_public_pagination_preserves_filters(): void
    {
        $batch = '1985';

        for ($i = 1; $i <= 12; $i++) {
            $member = $this->member('Paged Member '.str_pad((string) $i, 2, '0', STR_PAD_LEFT), [], ['batch' => $batch]);
            $this->contribute($member, 10);
        }

        $pageOne = $this->publicResponse(['batch' => $batch, 'page' => 1]);
        $pageOne->assertOk()->assertSee('Paged Member 01')->assertSee('Paged Member 10');

        $pageTwo = $this->publicResponse(['batch' => $batch, 'page' => 2]);
        $pageTwo->assertOk()
            ->assertSee('batch='.$batch, escape: false);

        $this->assertSame(2, $pageTwo->viewData('entries')->lastPage());
    }

    public function test_public_empty_state_shows_graceful_message(): void
    {
        $this->contribute($this->member('No Match Member'), 50);

        $this->publicResponse(['q' => 'zzzz-nothing-matches'])
            ->assertOk()
            ->assertSee('No contributors found');
    }

    /*
    |--------------------------------------------------------------------------
    | Membership profile acknowledgment
    |--------------------------------------------------------------------------
    */

    public function test_profile_shows_rank_and_contribution_only_when_allowed(): void
    {
        $visible = $this->member('Profile Rank Member');
        $this->contribute($visible, 500);
        $this->contribute($this->member('Rank Competitor'), 200);

        $this->get(route('alumni.show', $visible->alumni->slug))
            ->assertOk()
            ->assertSee('#1', escape: false)
            ->assertSee('on Member Leaderboard')
            ->assertSee('Verified Contribution')
            ->assertSee('৳500');
    }

    public function test_profile_hides_contribution_for_private_member(): void
    {
        $private = $this->member('Profile Private Member', ['is_public' => false]);
        $this->contribute($private, 500);

        $this->get(route('alumni.show', $private->alumni->slug))
            ->assertOk()
            ->assertDontSee('on Member Leaderboard')
            ->assertDontSee('৳500');
    }

    public function test_profile_hides_contribution_for_leaderboard_opted_out_member(): void
    {
        $optedOut = $this->member('Profile Opted Out Member', ['show_on_leaderboard' => false]);
        $this->contribute($optedOut, 500);

        $this->get(route('alumni.show', $optedOut->alumni->slug))
            ->assertOk()
            ->assertDontSee('on Member Leaderboard')
            ->assertDontSee('৳500');
    }

    public function test_profile_hides_contribution_for_zero_contribution_member(): void
    {
        $zero = $this->member('Profile Zero Member');

        $this->get(route('alumni.show', $zero->alumni->slug))
            ->assertOk()
            ->assertDontSee('on Member Leaderboard');
    }

    public function test_profile_hides_contribution_when_leaderboard_globally_disabled(): void
    {
        $visible = $this->member('Profile Disabled Member');
        $this->contribute($visible, 500);

        SiteSetting::set('leaderboard_public_enabled', false);

        $this->get(route('alumni.show', $visible->alumni->slug))
            ->assertOk()
            ->assertDontSee('on Member Leaderboard');
    }

    public function test_membership_badge_still_renders_on_public_profile(): void
    {
        $member = $this->member('Badge Check Member');
        $this->contribute($member, 50);

        $this->get(route('alumni.show', $member->alumni->slug))
            ->assertOk()
            ->assertSee($member->tier->badge_label.' Member');
    }

    /*
    |--------------------------------------------------------------------------
    | Admin access
    |--------------------------------------------------------------------------
    */

    public function test_guest_is_redirected_from_admin_leaderboard(): void
    {
        $this->get(route('admin.leaderboard.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_non_admin_is_forbidden_from_admin_leaderboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.leaderboard.index'))
            ->assertForbidden();
    }

    public function test_admin_leaderboard_is_accessible(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.leaderboard.index'))
            ->assertOk()
            ->assertSee('Leaderboard Management');
    }

    public function test_admin_leaderboard_includes_hidden_and_zero_contribution_members(): void
    {
        $visible = $this->member('Admin Visible Member');
        $hidden = $this->member('Admin Hidden Member', ['show_on_leaderboard' => false]);
        $private = $this->member('Admin Private Member', ['is_public' => false]);
        $zero = $this->member('Admin Zero Member');

        $this->contribute($visible, 100);
        $this->contribute($hidden, 200);
        $this->contribute($private, 300);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.leaderboard.index'))
            ->assertOk()
            ->assertSee('Admin Visible Member')
            ->assertSee('Admin Hidden Member')
            ->assertSee('Admin Private Member')
            ->assertSee('Admin Zero Member');

        $rows = collect($response->viewData('entries')['data'] ?? $response->viewData('entries')->items());
        $this->assertTrue($rows->contains(fn ($row) => $row->verified_total_float === 0.0 && $row->alumni_name === 'Admin Zero Member'));
        $this->assertTrue($rows->contains(fn ($row) => ! $row->is_public && $row->alumni_name === 'Admin Private Member'));
    }

    public function test_admin_search_by_name_student_id_and_membership_number(): void
    {
        $member = $this->member('Admin Search Member', [], ['student_id' => 'EN-6600001']);
        $this->contribute($member, 100);

        $this->actingAs($this->admin);

        $this->get(route('admin.leaderboard.index', ['q' => 'Admin Search']))
            ->assertOk()->assertSee('Admin Search Member');

        $this->get(route('admin.leaderboard.index', ['q' => 'EN-6600001']))
            ->assertOk()->assertSee('Admin Search Member');

        $this->get(route('admin.leaderboard.index', ['q' => $member->membership_number]))
            ->assertOk()->assertSee('Admin Search Member');
    }

    public function test_admin_filters_work(): void
    {
        $pending = $this->member('Admin Pending Member', ['status' => Membership::STATUS_PENDING, 'approved_at' => null]);
        $active = $this->member('Admin Active Member');
        $hidden = $this->member('Admin Hidden For Filter', ['show_on_leaderboard' => false]);

        $this->contribute($pending, 50);
        $this->contribute($active, 150);
        $this->contribute($hidden, 200);

        $this->actingAs($this->admin);

        $this->get(route('admin.leaderboard.index', ['status' => Membership::STATUS_PENDING]))
            ->assertOk()
            ->assertSee('Admin Pending Member')
            ->assertDontSee('Admin Active Member')
            ->assertDontSee('Admin Hidden For Filter');

        $this->get(route('admin.leaderboard.index', ['visibility' => 'hidden']))
            ->assertOk()
            ->assertSee('Admin Hidden For Filter')
            ->assertDontSee('Admin Active Member')
            ->assertDontSee('Admin Pending Member');

        $this->get(route('admin.leaderboard.index', ['visibility' => 'public']))
            ->assertOk()
            ->assertSee('Admin Active Member')
            ->assertSee('Admin Pending Member')
            ->assertDontSee('Admin Hidden For Filter');

        $this->get(route('admin.leaderboard.index', ['min_contribution' => 100]))
            ->assertOk()
            ->assertSee('Admin Active Member')
            ->assertSee('Admin Hidden For Filter')
            ->assertDontSee('Admin Pending Member');
    }

    public function test_visibility_toggle_works_and_affects_public_page(): void
    {
        $member = $this->member('Toggle Me Member');
        $this->contribute($member, 100);

        $this->publicResponse()->assertSee('Toggle Me Member');

        $this->actingAs($this->admin)
            ->post(route('admin.leaderboard.visibility', $member))
            ->assertRedirect(route('admin.leaderboard.index'));

        $this->assertFalse($member->fresh()->show_on_leaderboard);
        $this->publicResponse()->assertDontSee('Toggle Me Member');

        $this->actingAs($this->admin)
            ->post(route('admin.leaderboard.visibility', $member))
            ->assertRedirect(route('admin.leaderboard.index'));

        $this->assertTrue($member->fresh()->show_on_leaderboard);
        $this->publicResponse()->assertSee('Toggle Me Member');
    }

    public function test_public_toggle_switches_the_site_setting(): void
    {
        $member = $this->member('Global Toggle Member');
        $this->contribute($member, 100);

        $this->assertTrue(SiteSetting::leaderboardEnabled());

        $this->actingAs($this->admin)
            ->post(route('admin.leaderboard.togglePublic'))
            ->assertRedirect(route('admin.leaderboard.index'));

        $this->assertFalse(SiteSetting::leaderboardEnabled());
        $this->publicResponse()->assertNotFound();
        $this->get(route('home'))->assertDontSee('/leaderboard', escape: false);

        // The admin leaderboard stays available while the public page is off.
        $this->actingAs($this->admin)
            ->get(route('admin.leaderboard.index'))
            ->assertOk()
            ->assertSee('Global Toggle Member');

        $this->actingAs($this->admin)
            ->post(route('admin.leaderboard.togglePublic'))
            ->assertRedirect(route('admin.leaderboard.index'));

        $this->assertTrue(SiteSetting::leaderboardEnabled());
        $this->publicResponse()->assertOk()->assertSee('Global Toggle Member');
    }

    public function test_contribution_total_is_derived_and_cannot_be_manually_edited(): void
    {
        $member = $this->member('Derived Member');
        $this->contribute($member, 100);
        $this->contribute($member, 50, PaymentStatus::Void->value, ['payment_number' => 'EDAA-PAY-000999']);

        // No stored contribution columns exist anywhere near the memberships table.
        $this->assertFalse(Schema::hasColumn('memberships', 'leaderboard_amount'));
        $this->assertFalse(Schema::hasColumn('memberships', 'contribution_total'));

        // The figure is recomputed on every read from valid payments.
        $this->assertSame(100.0, $member->fresh()->verifiedContributionTotal());
        $this->assertSame(1, $member->fresh()->verifiedPaymentCount());

        // Submitting a fabricated amount through the membership form is ignored.
        $this->actingAs($this->admin)
            ->put(route('admin.members.update', $member), [
                'membership_type_id' => $member->membership_type_id,
                'status' => $member->status,
                'leaderboard_amount' => 999999,
                'total_contribution' => 999999,
            ])
            ->assertRedirect();

        $this->assertSame(100.0, $member->fresh()->verifiedContributionTotal());
    }

    /*
    |--------------------------------------------------------------------------
    | Rankings update live with payments
    |--------------------------------------------------------------------------
    */

    public function test_voiding_a_payment_updates_rankings_automatically(): void
    {
        $memberA = $this->member('Void Rank A');
        $memberB = $this->member('Void Rank B');

        $voidable = $this->contribute($memberA, 500);
        $this->contribute($memberB, 200);

        $rows = $this->leaderboard()->publicPaginate()->getCollection();
        $this->assertSame('Void Rank A', $rows->first()->alumni_name);
        $this->assertSame(500.0, $rows->first()->verified_total_float);

        $voidable->update(['status' => PaymentStatus::Void->value, 'voided_at' => now(), 'voided_by' => $this->admin->id]);

        $rows = $this->leaderboard()->publicPaginate()->getCollection();
        $this->assertSame('Void Rank B', $rows->first()->alumni_name);
        $this->assertSame(200.0, $rows->first()->verified_total_float);
        $this->assertSame(0.0, $memberA->fresh()->verifiedContributionTotal());
    }

    public function test_hidden_member_disappears_publicly_but_stays_in_admin(): void
    {
        $member = $this->member('Hide And Seek Member');
        $this->contribute($member, 150);

        $this->publicResponse()->assertSee('Hide And Seek Member');
        $this->actingAs($this->admin)->get(route('admin.leaderboard.index'))->assertOk()->assertSee('Hide And Seek Member');

        $member->update(['show_on_leaderboard' => false]);

        $this->publicResponse()->assertDontSee('Hide And Seek Member');

        $this->actingAs($this->admin)
            ->get(route('admin.leaderboard.index'))
            ->assertOk()
            ->assertSee('Hide And Seek Member');
    }

    public function test_public_leaderboard_requests_never_modify_payment_records(): void
    {
        $member = $this->member('Read Only Member');
        $this->contribute($member, 50);

        $before = Payment::query()->pluck('status', 'id')->all();
        $totalsBefore = Payment::collectionTotals();

        $this->publicResponse()->assertOk();
        $this->get(route('home'))->assertOk();

        $this->assertSame($before, Payment::query()->pluck('status', 'id')->all());
        $this->assertSame($totalsBefore, Payment::collectionTotals());
    }

    /*
    |--------------------------------------------------------------------------
    | Model helpers
    |--------------------------------------------------------------------------
    */

    public function test_membership_leaderboard_helpers(): void
    {
        $eligible = $this->member('Eligible Helper Member');
        $this->contribute($eligible, 50);
        $this->assertTrue($eligible->fresh()->canAppearOnLeaderboard());

        $hidden = $this->member('Hidden Helper Member', ['show_on_leaderboard' => false]);
        $this->assertFalse($hidden->fresh()->canAppearOnLeaderboard());

        $private = $this->member('Private Helper Member', ['is_public' => false]);
        $this->assertFalse($private->fresh()->canAppearOnLeaderboard());

        $suspended = $this->member('Suspended Helper Member', ['status' => Membership::STATUS_SUSPENDED]);
        $this->assertFalse($suspended->fresh()->canAppearOnLeaderboard());

        $zero = $this->member('Zero Helper Member');
        $this->assertTrue($zero->fresh()->canAppearOnLeaderboard());
        $this->assertNull($this->leaderboard()->rankFor($zero->id, 0.0));
    }

    public function test_membership_factory_has_leaderboard_states(): void
    {
        $this->assertTrue(Membership::factory()->create()->show_on_leaderboard);
        $this->assertFalse(Membership::factory()->leaderboardHidden()->create()->show_on_leaderboard);
        $this->assertTrue(Membership::factory()->leaderboardVisible()->create()->show_on_leaderboard);
    }

    /*
    |--------------------------------------------------------------------------
    | Seeded data
    |--------------------------------------------------------------------------
    */

    public function test_seeded_payments_drive_realistic_leaderboard_scenarios(): void
    {
        $this->seed([
            MembershipTypeSeeder::class,
            MembershipTierSeeder::class,
            AlumniSeeder::class,
            MembershipSeeder::class,
            FeePlanSeeder::class,
            PaymentSeeder::class,
        ]);

        $this->assertGreaterThanOrEqual(5, Payment::count());

        $rows = $this->leaderboard()->publicPaginate()->getCollection();
        $ranked = $rows->keyBy('alumni_name');

        // Top contributor — Chidi Eze (৳100 paid executive contribution).
        $this->assertSame(1, $ranked['Chidi Eze']->leaderboard_rank);
        $this->assertSame(100.0, $ranked['Chidi Eze']->verified_total_float);

        // Adaeze (৳50 paid) and Halima (৳30 + ৳20 partial) tie for rank 2.
        $this->assertSame(2, $ranked['Adaeze Okafor']->leaderboard_rank);
        $this->assertSame(2, $ranked['Halima Balogun']->leaderboard_rank);
        $this->assertSame(50.0, $ranked['Adaeze Okafor']->verified_total_float);
        $this->assertSame(50.0, $ranked['Halima Balogun']->verified_total_float);

        // Zero-contribution members (Kwame) never appear publicly.
        $this->assertArrayNotHasKey('Kwame Mensah', $ranked);

        // Voided & waived money is excluded from the association totals.
        $this->assertSame(200.0, Payment::collectionTotals()['total']);
    }

    public function test_seeders_are_idempotent_without_duplicates_and_privacy_field_flows_through(): void
    {
        $this->seed([
            MembershipTypeSeeder::class,
            MembershipTierSeeder::class,
            AlumniSeeder::class,
            MembershipSeeder::class,
            FeePlanSeeder::class,
            PaymentSeeder::class,
        ]);

        $payments = Payment::count();
        $memberships = Membership::count();

        $this->seed([PaymentSeeder::class, MembershipSeeder::class]);

        $this->assertSame($payments, Payment::count());
        $this->assertSame($memberships, Membership::count());

        $this->assertSame(
            Payment::count(),
            Payment::query()->distinct('payment_number')->count('payment_number')
        );

        $this->assertSame(
            Membership::count(),
            Membership::query()->distinct('membership_number')->count('membership_number')
        );

        // The seeder explicitly opts the private demo record out of the
        // leaderboard so the admin view demonstrates the "Hidden" label.
        $this->assertTrue(
            Membership::query()
                ->where('is_public', false)
                ->where('show_on_leaderboard', false)
                ->where('status', Membership::STATUS_ACTIVE)
                ->exists()
        );

        // Public visible members all remain opted in.
        $this->assertFalse(
            Membership::query()->where('is_public', true)->where('show_on_leaderboard', false)->exists()
        );

        // The admin board still sees hidden/zero records after seeding.
        $adminRows = $this->leaderboard()->adminPaginate()->getCollection();
        $this->assertTrue($adminRows->contains(fn ($row) => $row->verified_total_float === 0.0));
    }

    /*
    |--------------------------------------------------------------------------
    | Regression — leaderboard must not change Feature 13 payment behavior
    |--------------------------------------------------------------------------
    */

    public function test_payment_statuses_and_calculations_remain_unchanged(): void
    {
        $member = $this->member('Regression Member');
        $this->contribute($member, 50, PaymentStatus::Paid->value, ['payment_number' => 'EDAA-PAY-001001']);
        $this->contribute($member, 20, PaymentStatus::Partial->value, ['payment_number' => 'EDAA-PAY-001002']);
        $this->contribute($member, 10, PaymentStatus::Waived->value, ['payment_number' => 'EDAA-PAY-001003']);

        // Feature 13 valid-total semantics are untouched.
        $this->assertSame(70.0, (float) Payment::query()->valid()->sum('amount'));
        $this->assertSame(2, Payment::query()->valid()->count());

        // Leaderboard calculations share the same valid() semantics.
        $this->assertSame(70.0, $member->verifiedContributionTotal());
        $this->assertSame(70.0, $this->leaderboard()->publicPaginate()->getCollection()->first()->verified_total_float);

        // Outstanding-obligation logic remains intact (Feature 13 financials).
        $this->assertNotNull(Payment::obligationFor($member->id, FeePlan::query()->firstOrFail()));
    }
}
