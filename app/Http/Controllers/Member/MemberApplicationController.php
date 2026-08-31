<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MemberApplicationController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $alumni = $user->alumni;

        $applications = $alumni->applications()
            ->with('membershipType')
            ->latest()
            ->paginate(10);

        return view('member.applications.index', [
            'alumni' => $alumni,
            'applications' => $applications,
        ]);
    }
}
