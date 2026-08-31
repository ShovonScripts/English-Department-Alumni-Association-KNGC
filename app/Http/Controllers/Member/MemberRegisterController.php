<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class MemberRegisterController extends Controller
{
    public function showForm()
    {
        if (Auth::check()) {
            return redirect()->route('member.dashboard');
        }

        return view('member.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'student_id' => ['required', 'string', 'max:50'],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', Password::min(8)->mixedCase()->numbers(), 'confirmed'],
        ]);

        $alumni = Alumni::where('student_id', $request->student_id)
            ->whereRaw('LOWER(full_name) = LOWER(?)', [$request->full_name])
            ->first();

        if (! $alumni) {
            return back()->withErrors([
                'student_id' => 'No alumni record found matching the provided student ID and full name.',
            ])->withInput($request->only(['student_id', 'full_name', 'email']));
        }

        if ($alumni->user) {
            return back()->withErrors([
                'student_id' => 'This alumni record is already linked to an existing account.',
            ])->withInput($request->only(['student_id', 'full_name', 'email']));
        }

        $membership = $alumni->membership;

        if (! $membership || $membership->status !== Membership::STATUS_ACTIVE) {
            return back()->withErrors([
                'student_id' => 'This alumni record does not have an active membership.',
            ])->withInput($request->only(['student_id', 'full_name', 'email']));
        }

        $user = User::create([
            'name' => $alumni->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
            'alumni_id' => $alumni->id,
        ]);

        Auth::login($user);

        return redirect()->route('member.dashboard')->with('success', 'Welcome to the EDAA Member Portal!');
    }
}
