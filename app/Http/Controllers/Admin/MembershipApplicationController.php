<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ApplicationStatus;
use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Membership;
use App\Models\MembershipApplication;
use App\Models\MembershipTier;
use App\Models\MembershipType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MembershipApplicationController extends Controller
{
    /**
     * List all membership applications with filters.
     */
    public function index(Request $request)
    {
        $query = MembershipApplication::query()
            ->with(['membershipType', 'requestedTier', 'reviewedBy']);

        // Search.
        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('application_number', 'like', "%{$search}%")
                    ->orWhere('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        // Status filter.
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Membership type filter.
        if ($typeId = $request->input('membership_type_id')) {
            $query->where('membership_type_id', $typeId);
        }

        // Tier filter.
        if ($tierId = $request->input('requested_tier_id')) {
            $query->where('requested_tier_id', $tierId);
        }

        // Date range.
        if ($from = $request->input('date_from')) {
            $query->where('submitted_at', '>=', $from);
        }
        if ($to = $request->input('date_to')) {
            $query->where('submitted_at', '<=', $to.' 23:59:59');
        }

        $applications = $query->orderByDesc('submitted_at')->paginate(15)->withQueryString();

        return view('admin.membership-applications.index', [
            'applications' => $applications,
            'membershipTypes' => MembershipType::ordered()->get(),
            'membershipTiers' => MembershipTier::ordered()->get(),
            'statuses' => ApplicationStatus::cases(),
        ]);
    }

    /**
     * Show a single membership application.
     */
    public function show(MembershipApplication $application)
    {
        $application->load(['membershipType', 'requestedTier', 'reviewedBy', 'alumni']);

        return view('admin.membership-applications.show', [
            'application' => $application,
        ]);
    }

    /**
     * Change application status (under review, request changes, reject).
     */
    public function review(Request $request, MembershipApplication $application)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:under_review,changes_requested,rejected'],
            'admin_notes' => ['required_if:status,changes_requested', 'nullable', 'string', 'max:5000'],
            'rejection_reason' => ['required_if:status,rejected', 'nullable', 'string', 'max:5000'],
        ]);

        $newStatus = ApplicationStatus::from($validated['status']);

        // Validate allowed transitions.
        $allowed = match ($newStatus) {
            ApplicationStatus::UnderReview => [ApplicationStatus::Pending, ApplicationStatus::UnderReview, ApplicationStatus::ChangesRequested],
            ApplicationStatus::ChangesRequested => [ApplicationStatus::Pending, ApplicationStatus::UnderReview],
            ApplicationStatus::Rejected => [ApplicationStatus::Pending, ApplicationStatus::UnderReview],
            default => [],
        };

        if (! in_array($application->status, $allowed, true)) {
            return back()->withErrors(['status' => 'Cannot transition from '.$application->status->label().' to '.$newStatus->label().'.']);
        }

        $application->update([
            'status' => $newStatus,
            'admin_notes' => $validated['admin_notes'] ?? $application->admin_notes,
            'rejection_reason' => $validated['rejection_reason'] ?? $application->rejection_reason,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Application status updated to '.$newStatus->label().'.');
    }

    /**
     * Approve an application and create/link the membership.
     */
    public function approve(Request $request, MembershipApplication $application)
    {
        // Only pending or under-review applications can be approved.
        if (! in_array($application->status, [ApplicationStatus::Pending, ApplicationStatus::UnderReview], true)) {
            return back()->withErrors(['status' => 'Only pending or under-review applications can be approved.']);
        }

        // Validate membership type selection.
        $validated = $request->validate([
            'membership_type_id' => ['required', 'integer', 'exists:membership_types,id'],
        ]);

        // Block approval if applicant already has a membership.
        $existingAlumni = $this->findExistingAlumni($application);
        if ($existingAlumni && $existingAlumni->membership) {
            return back()->withErrors(['status' => 'This applicant already has a membership ( '.$existingAlumni->membership->membership_number.'). Cannot create a duplicate.']);
        }

        DB::beginTransaction();

        try {
            // Find or create Alumni record.
            $alumni = $existingAlumni ?? $this->createAlumniFromApplication($application);

            // Create the membership.
            $membershipNumber = Membership::generateMembershipNumber();

            $membership = Membership::create([
                'alumni_id' => $alumni->id,
                'membership_type_id' => $validated['membership_type_id'],
                'membership_tier_id' => $application->requested_tier_id,
                'membership_number' => $membershipNumber,
                'status' => Membership::STATUS_ACTIVE,
                'joined_at' => now()->toDateString(),
                'approved_at' => now()->toDateString(),
                'is_public' => true,
                'show_on_leaderboard' => true,
            ]);

            $membership->syncApprovalStamp();

            // Link alumni to application and mark approved.
            $application->update([
                'alumni_id' => $alumni->id,
                'status' => ApplicationStatus::Approved,
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);

            DB::commit();

            return back()->with('success', 'Application approved. Membership '.$membershipNumber.' has been created for '.$alumni->full_name.'.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['status' => 'Approval failed: '.$e->getMessage()]);
        }
    }

    /**
     * Find an existing alumni record matching the application.
     *
     * Matching priority:
     * 1. Existing alumni_id on the application
     * 2. Student ID match
     * 3. Email match (case-insensitive)
     */
    private function findExistingAlumni(MembershipApplication $application): ?Alumni
    {
        // 1. Direct alumni_id link.
        if ($application->alumni_id) {
            $alumni = Alumni::find($application->alumni_id);
            if ($alumni) {
                return $alumni;
            }
        }

        // 2. Student ID match.
        if ($application->student_id) {
            $alumni = Alumni::where('student_id', $application->student_id)->first();
            if ($alumni) {
                return $alumni;
            }
        }

        // 3. Email match.
        $alumni = Alumni::whereRaw('LOWER(email) = ?', [strtolower($application->email)])->first();

        return $alumni;
    }

    /**
     * Create a new Alumni record from the application data.
     */
    private function createAlumniFromApplication(MembershipApplication $application): Alumni
    {
        return Alumni::create([
            'full_name' => $application->full_name,
            'slug' => Alumni::uniqueSlug($application->full_name),
            'email' => $application->email,
            'phone' => $application->phone,
            'student_id' => $application->student_id,
            'batch' => $application->batch,
            'graduation_year' => $application->graduation_year,
            'profession' => $application->profession,
            'organization' => $application->current_organization,
            'designation' => $application->current_designation,
            'city' => $application->city,
            'country' => $application->country,
            'status' => Alumni::STATUS_ACTIVE,
        ]);
    }
}
