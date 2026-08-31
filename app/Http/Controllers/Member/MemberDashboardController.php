<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\FeePlan;
use App\Models\Payment;
use App\Models\User;
use App\Services\LeaderboardService;
use Illuminate\Http\Request;

class MemberDashboardController extends Controller
{
    public function index(Request $request, LeaderboardService $leaderboard)
    {
        /** @var User $user */
        $user = $request->user();
        $alumni = $user->alumni;
        $membership = $alumni->membership;

        $recentPayments = $membership->payments()
            ->with(['feePlan', 'recordedBy'])
            ->latest('paid_at')
            ->limit(5)
            ->get();

        // Use the centralized obligation calculation for accuracy.
        $currentFee = $membership->membership_type_id !== null
            ? FeePlan::currentForType($membership->membership_type_id)
            : null;

        if ($currentFee) {
            $obligation = Payment::obligationFor($membership->id, $currentFee);
            $totalPaid = (float) $obligation['collected'];
            $outstandingBalance = (float) $obligation['outstanding'];
        } else {
            $totalPaid = (float) $membership->payments()->valid()->sum('amount');
            $outstandingBalance = 0.0;
        }

        $rank = $leaderboard->rankFor($membership->id, $totalPaid);

        return view('member.dashboard', [
            'alumni' => $alumni,
            'membership' => $membership,
            'recentPayments' => $recentPayments,
            'outstandingBalance' => $outstandingBalance,
            'totalPaid' => $totalPaid,
            'rank' => $rank,
        ]);
    }
}
