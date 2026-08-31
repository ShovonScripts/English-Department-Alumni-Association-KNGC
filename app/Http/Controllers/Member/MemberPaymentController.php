<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MemberPaymentController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $alumni = $user->alumni;
        $membership = $alumni->membership;

        $payments = $membership->payments()
            ->with('feePlan')
            ->latest('paid_at')
            ->paginate(15);

        return view('member.payments.index', [
            'alumni' => $alumni,
            'membership' => $membership,
            'payments' => $payments,
        ]);
    }
}
