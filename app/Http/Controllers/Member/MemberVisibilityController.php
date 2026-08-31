<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MemberVisibilityController extends Controller
{
    public function toggle(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $alumni = $user->alumni;
        $membership = $alumni->membership;

        $membership->update([
            'is_public' => ! $membership->is_public,
        ]);

        return Redirect::back()->with('success', 'Profile visibility updated.');
    }
}
