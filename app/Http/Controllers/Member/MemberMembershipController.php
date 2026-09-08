<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\FeePlan;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class MemberMembershipController extends Controller
{
    public function show(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $alumni = $user->alumni;
        $membership = $alumni->membership;

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

        return view('member.membership.show', [
            'alumni' => $alumni,
            'membership' => $membership,
            'outstandingBalance' => $outstandingBalance,
            'totalPaid' => $totalPaid,
        ]);
    }

    public function card(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $alumni = $user->alumni;
        $membership = $alumni->membership;

        return view('member.membership.card', [
            'alumni' => $alumni,
            'membership' => $membership,
        ]);
    }
}
