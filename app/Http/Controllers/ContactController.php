<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $key = 'contact:'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors([
                'message' => 'Too many submissions. Please try again later.',
            ])->withInput($request->only('name', 'email', 'subject'));
        }

        RateLimiter::hit($key, 600);

        if ($request->input('website')) {
            return back()->with('success', 'Thank you for your message.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'subject' => ['required', 'string', 'max:200'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::create([
            ...$validated,
            'status' => ContactMessage::STATUS_UNREAD,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Thank you, '.$validated['name'].'. Your message has been received. We will be in touch shortly.');
    }
}
