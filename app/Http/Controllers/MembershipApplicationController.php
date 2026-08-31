<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationStatus;
use App\Models\MembershipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class MembershipApplicationController extends Controller
{
    /**
     * Show the public application form.
     */
    public function create()
    {
        return view('pages.membership-apply');
    }

    /**
     * Store a new membership application.
     */
    public function store(Request $request)
    {
        // Honeypot check — silently discard bot submissions.
        if ($request->input('website')) {
            return redirect()
                ->route('membership.apply')
                ->with('success', 'Your application has been submitted successfully.');
        }

        // Rate limiting: max 3 applications per 30 minutes per IP + email combination.
        $rateLimitKey = 'membership-application:'.($request->ip()).':'.($request->input('email', ''));
        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);

            return redirect()
                ->route('membership.apply')
                ->withErrors(['email' => 'Too many applications. Please try again in '.$seconds.' seconds.']);
        }

        RateLimiter::hit($rateLimitKey, 1800);

        $validated = $request->validate($this->rules());

        // Duplicate protection: check for existing active membership.
        if (MembershipApplication::hasActiveMembership($validated['email'], $validated['student_id'] ?? null)) {
            return back()
                ->withErrors(['email' => 'An active membership already exists for this applicant.'])
                ->withInput();
        }

        // Duplicate protection: check for existing active application.
        if (MembershipApplication::hasActiveApplication(
            $validated['email'],
            $validated['phone'],
            $validated['student_id'] ?? null
        )) {
            return back()
                ->withErrors(['email' => 'Your membership application is already under review.'])
                ->withInput();
        }

        // Create application within a transaction.
        $application = \DB::transaction(function () use ($validated, $request) {
            $plainToken = MembershipApplication::generateStatusToken();

            // Handle alumni document upload.
            if ($request->hasFile('alumni_document')) {
                $file = $request->file('alumni_document');
                $filename = uniqid('alumni_doc_').'.'.$file->getClientOriginalExtension();
                $validated['alumni_document_path'] = $file->storeAs('applications/documents', $filename, 'public');
                $validated['alumni_document_original_name'] = $file->getClientOriginalName();
                $validated['alumni_document_size'] = $file->getSize();
                $validated['alumni_document_mime_type'] = $file->getMimeType();
            }

            $application = MembershipApplication::create([
                ...$validated,
                'country' => $validated['country'] ?? 'Bangladesh',
                'application_number' => MembershipApplication::generateApplicationNumber(),
                'status' => ApplicationStatus::Pending,
                'status_token_hash' => MembershipApplication::hashStatusToken($plainToken),
                'submitted_at' => now(),
            ]);

            // Store the plain token on the model temporarily for the redirect.
            $application->plain_status_token = $plainToken;

            return $application;
        });

        return redirect()
            ->route('membership.application.status', [
                $application->application_number,
                $application->plain_status_token,
            ])
            ->with('application_submitted', true);
    }

    /**
     * Show the application status page (requires secure token).
     */
    public function status(string $applicationNumber, string $token)
    {
        $tokenHash = MembershipApplication::hashStatusToken($token);

        $application = MembershipApplication::query()
            ->where('application_number', $applicationNumber)
            ->where('status_token_hash', $tokenHash)
            ->firstOrFail();

        return view('pages.membership-application-status', [
            'application' => $application,
        ]);
    }

    /**
     * Validation rules for the application form.
     */
    private function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'student_id' => ['nullable', 'string', 'max:50'],
            'batch' => ['nullable', 'string', 'max:30'],
            'graduation_year' => ['nullable', 'integer', 'min:1960', 'max:'.((int) date('Y') + 1)],
            'current_organization' => ['nullable', 'string', 'max:150'],
            'profession' => ['nullable', 'string', 'max:100'],
            'current_designation' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'application_message' => ['nullable', 'string', 'max:5000'],
            'alumni_document' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ];
    }
}
