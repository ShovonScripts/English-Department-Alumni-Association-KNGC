<?php

namespace Tests\Feature;

use App\Models\Alumni;
use App\Models\ContactMessage;
use App\Models\CorrectionRequest;
use App\Models\Event;
use App\Models\MembershipApplication;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUiUxTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_dashboard_loads_with_all_metrics_and_feeds(): void
    {
        // Create 1 pending application and 1 message to ensure attention banner is visible
        \App\Models\MembershipApplication::factory()->create(['status' => \App\Enums\ApplicationStatus::Pending]);

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertViewIs('admin.dashboard');
        $response->assertViewHasAll([
            'alumniCount',
            'committeeCount',
            'eventCount',
            'newsPublishedCount',
            'unreadMessageCount',
            'membershipActiveCount',
            'applicationPendingCount',
            'pendingCorrectionCount',
            'recentApplications',
            'recentMessages',
            'recentPayments',
            'upcomingEvents',
            'totalCollections',
            'totalExpenses',
            'currentBalance',
        ]);
        $response->assertSee('EDAA Executive Terminal');
        $response->assertSee('Requiring Administrative Attention');
    }

    public function test_correction_requests_index_loads_successfully(): void
    {
        $alumni = Alumni::factory()->create(['full_name' => 'John Doe']);
        CorrectionRequest::factory()->create([
            'alumni_id' => $alumni->id,
            'requested_field' => 'full_name',
            'requested_value' => 'Dr. John Doe',
            'reason' => 'Completed PhD',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.correction-requests.index'));

        $response->assertOk();
        $response->assertViewIs('admin.correction_requests.index');
        $response->assertSee('Alumni Correction Requests');
        $response->assertSee('John Doe');
        $response->assertSee('Dr. John Doe');
        $response->assertSee('Completed PhD');
    }

    public function test_correction_requests_show_loads_successfully(): void
    {
        $alumni = Alumni::factory()->create(['full_name' => 'Jane Smith']);
        $req = CorrectionRequest::factory()->create([
            'alumni_id' => $alumni->id,
            'requested_field' => 'student_id',
            'requested_value' => 'ENG-2024-999',
            'reason' => 'Typo on card',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.correction-requests.show', $req));

        $response->assertOk();
        $response->assertViewIs('admin.correction_requests.show');
        $response->assertSee('Correction Request #' . $req->id);
        $response->assertSee('ENG-2024-999');
        $response->assertSee('Typo on card');
        $response->assertSee('Update Profile');
    }

    public function test_admin_can_approve_correction_request(): void
    {
        $alumni = Alumni::factory()->create(['full_name' => 'Old Name']);
        $req = CorrectionRequest::factory()->create([
            'alumni_id' => $alumni->id,
            'requested_field' => 'full_name',
            'requested_value' => 'New Approved Name',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)
            ->from(route('admin.correction-requests.show', $req))
            ->post(route('admin.correction-requests.approve', $req));

        $response->assertRedirect(route('admin.correction-requests.show', $req));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('alumni', [
            'id' => $alumni->id,
            'full_name' => 'New Approved Name',
        ]);
        $this->assertDatabaseHas('correction_requests', [
            'id' => $req->id,
            'status' => 'approved',
            'reviewed_by' => $this->admin->id,
        ]);
    }

    public function test_admin_can_reject_correction_request(): void
    {
        $alumni = Alumni::factory()->create();
        $req = CorrectionRequest::factory()->create([
            'alumni_id' => $alumni->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)
            ->from(route('admin.correction-requests.show', $req))
            ->post(route('admin.correction-requests.reject', $req));

        $response->assertRedirect(route('admin.correction-requests.show', $req));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('correction_requests', [
            'id' => $req->id,
            'status' => 'rejected',
            'reviewed_by' => $this->admin->id,
        ]);
    }
}
