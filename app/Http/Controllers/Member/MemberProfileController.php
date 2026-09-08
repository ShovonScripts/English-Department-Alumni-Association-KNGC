<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $alumni = $user->alumni;

        return view('member.profile.show', [
            'alumni' => $alumni,
            'membership' => $alumni->membership,
        ]);
    }

    public function edit(Request $request)
    {
        $user = $request->user();
        $alumni = $user->alumni;

        return view('member.profile.edit', [
            'user' => $user,
            'alumni' => $alumni,
            'membership' => $alumni->membership,
        ]);
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $alumni = $user->alumni;

        $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'city' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_photo' => ['boolean'],
        ]);

        $user->update(['email' => $request->email]);

        $data = [
            'phone' => $request->phone,
            'city' => $request->city,
            'country' => $request->country,
            'bio' => $request->bio,
        ];

        if ($request->boolean('remove_photo') && $alumni->profile_photo) {
            Storage::disk('public')->delete($alumni->profile_photo);
            $data['profile_photo'] = null;
        }

        if ($request->hasFile('profile_photo')) {
            if ($alumni->profile_photo) {
                Storage::disk('public')->delete($alumni->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $alumni->update($data);

        return redirect()->route('member.profile')->with('success', 'Profile updated successfully.');
    }
}
