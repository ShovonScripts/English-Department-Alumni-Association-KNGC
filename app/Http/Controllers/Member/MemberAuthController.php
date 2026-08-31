<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password as PasswordBroker;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class MemberAuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }

        return view('member.auth.login');
    }

    public function login(Request $request)
    {
        if (RateLimiter::tooManyAttempts('member-login-'.$request->ip(), 5)) {
            $seconds = RateLimiter::availableIn('member-login-'.$request->ip());

            return back()->withErrors([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ])->onlyInput('email');
        }

        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            RateLimiter::clear('member-login-'.$request->ip());

            /** @var User $user */
            $user = Auth::user();

            if (! $user->alumni_id || ! $user->alumni) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Your account is not linked to a membership profile.',
                ])->onlyInput('email');
            }

            $membership = $user->alumni->membership;

            if ($user->isDisabled()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Your account has been disabled. Please contact the administrator.',
                ])->onlyInput('email');
            }

            if (! $membership || $membership->status !== Membership::STATUS_ACTIVE) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'You do not have an active membership. Please contact administration.',
                ])->onlyInput('email');
            }

            return redirect()->intended(route('member.dashboard'));
        }

        RateLimiter::hit('member-login-'.$request->ip(), 120);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('member.login');
    }

    public function showLinkRequestForm()
    {
        return view('member.auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = PasswordBroker::broker()->sendResetLink(
            $request->only('email')
        );

        return $status === PasswordBroker::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('member.auth.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        $status = PasswordBroker::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === PasswordBroker::PASSWORD_RESET
                    ? redirect()->route('member.login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    private function redirectToDashboard()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('member.dashboard');
    }
}
