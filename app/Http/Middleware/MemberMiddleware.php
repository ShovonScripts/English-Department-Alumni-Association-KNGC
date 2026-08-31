<?php

namespace App\Http\Middleware;

use App\Models\Membership;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MemberMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('member.login')->with('error', 'Please sign in to access your member dashboard.');
        }

        /** @var User $user */
        $user = auth()->user();

        if (! $user->alumni_id || ! $user->alumni) {
            return redirect()->route('member.login')->with('error', 'Your account is not linked to a membership profile. Please contact administration.');
        }

        $membership = $user->alumni->membership;

        if (! $membership || $membership->status !== Membership::STATUS_ACTIVE) {
            return redirect()->route('member.login')->with('error', 'You do not have an active membership. Please contact administration.');
        }

        return $next($request);
    }
}
