<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ApplicationStatus;
use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\AlumniStory;
use App\Models\CommitteeMember;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\FeePlan;
use App\Models\GalleryAlbum;
use App\Models\GalleryPhoto;
use App\Models\Membership;
use App\Models\MembershipApplication;
use App\Models\News;
use App\Models\Payment;
use App\Models\Publication;
use App\Services\FinanceService;

class DashboardController extends Controller
{
    public function index(FinanceService $finance)
    {
        return view('admin.dashboard', array_merge([
            'alumniCount' => Alumni::query()->where('status', Alumni::STATUS_ACTIVE)->count(),
            'committeeCount' => CommitteeMember::query()->where('is_active', true)->count(),
            'eventCount' => Event::query()->published()->count(),
            'newsPublishedCount' => News::query()->published()->count(),
            'newsDraftCount' => News::query()->draft()->count(),
            'storyPublishedCount' => AlumniStory::query()->published()->count(),
            'storyDraftCount' => AlumniStory::query()->draft()->count(),
            'albumPublishedCount' => GalleryAlbum::query()->published()->count(),
            'photoCount' => GalleryPhoto::query()->count(),
            'publicationPublishedCount' => Publication::query()->published()->count(),
            'publicationDraftCount' => Publication::query()->draft()->count(),
            'unreadMessageCount' => ContactMessage::unread()->count(),
            'membershipTotalCount' => Membership::query()->count(),
            'membershipActiveCount' => Membership::query()->where('status', Membership::STATUS_ACTIVE)->count(),
            'membershipPendingCount' => Membership::query()->where('status', Membership::STATUS_PENDING)->count(),
            'membershipLifetimeCount' => Membership::query()
                ->where('status', Membership::STATUS_ACTIVE)
                ->whereHas('type', fn ($q) => $q->where('slug', 'lifetime-member'))
                ->count(),
            'feePlanActiveCount' => FeePlan::query()->active()->count(),
            'feePlanCurrentCount' => FeePlan::query()->current()->count(),
            'applicationTotalCount' => MembershipApplication::query()->count(),
            'applicationPendingCount' => MembershipApplication::query()->where('status', ApplicationStatus::Pending)->count(),
            'applicationUnderReviewCount' => MembershipApplication::query()->where('status', ApplicationStatus::UnderReview)->count(),
            'applicationApprovedCount' => MembershipApplication::query()->where('status', ApplicationStatus::Approved)->count(),
            'applicationRejectedCount' => MembershipApplication::query()->where('status', ApplicationStatus::Rejected)->count(),
            'publicMemberCount' => Membership::query()->where('status', Membership::STATUS_ACTIVE)->where('is_public', true)->count(),
        ], $this->financeSummary($finance)));
    }

    /**
     * Financial collection summary (organizational dues, not website revenue)
     * plus association expense and balance figures (Feature 15).
     */
    private function financeSummary(FinanceService $finance): array
    {
        $totals = Payment::collectionTotals();
        $outstanding = Payment::outstandingAndPaidMembers();

        return [
            'totalCollections' => $totals['total'],
            'collectionsThisMonth' => $totals['month'],
            'validPaymentCount' => $totals['count'],
            'outstandingFees' => $outstanding['total'],
            'paidMembers' => $outstanding['paid_members'],
            'totalExpenses' => $finance->totalExpenses(),
            'expensesThisMonth' => $finance->monthlyExpenses(),
            'currentBalance' => $finance->currentBalance(),
        ];
    }
}
