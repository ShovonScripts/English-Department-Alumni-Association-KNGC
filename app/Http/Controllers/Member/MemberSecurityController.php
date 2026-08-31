<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class MemberSecurityController extends Controller
{
    public function index(Request $request)
    {
        return view('member.security', [
            'user' => $request->user(),
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', Password::min(8)->mixedCase()->numbers(), 'confirmed'],
        ]);

        /** @var User $user */
        $user = $request->user();
        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        return redirect()->route('member.security')->with('success', 'Password updated successfully.');
    }

    public function showVerifyEmail(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->route('member.dashboard')
                    : view('member.auth.verify-email');
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('member.dashboard')->with('success', 'Email verified successfully.');
    }

    public function resendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('member.dashboard');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
