<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CorrectionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CorrectionRequestController extends Controller
{
    public function index(Request $request)
    {
        $requests = CorrectionRequest::with('alumni')
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->latest()
            ->paginate(15);

        return view('admin.correction_requests.index', compact('requests'));
    }

    public function show(CorrectionRequest $correctionRequest)
    {
        return view('admin.correction_requests.show', compact('correctionRequest'));
    }

    private const ALLOWED_FIELDS = ['full_name', 'student_id', 'batch', 'graduation_year'];

    public function approve(CorrectionRequest $correctionRequest)
    {
        if ($correctionRequest->status !== CorrectionRequest::STATUS_PENDING) {
            return back()->withErrors(['status' => 'Only pending requests can be approved.']);
        }

        // Enforce strict allowlist — only approved fields may be written.
        if (! in_array($correctionRequest->requested_field, self::ALLOWED_FIELDS, true)) {
            return back()->withErrors(['status' => 'This field cannot be corrected.']);
        }

        // Type-specific validation on the requested value.
        $this->validateValue($correctionRequest->requested_field, $correctionRequest->requested_value);

        $correctionRequest->alumni->update([
            $correctionRequest->requested_field => $correctionRequest->requested_value,
        ]);

        $correctionRequest->update([
            'status' => CorrectionRequest::STATUS_APPROVED,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Correction request approved and alumni profile updated.');
    }

    public function reject(CorrectionRequest $correctionRequest)
    {
        if ($correctionRequest->status !== CorrectionRequest::STATUS_PENDING) {
            return back()->withErrors(['status' => 'Only pending requests can be rejected.']);
        }

        $correctionRequest->update([
            'status' => CorrectionRequest::STATUS_REJECTED,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Correction request rejected.');
    }

    /**
     * Validate the requested value is appropriate for the field type.
     */
    private function validateValue(string $field, mixed $value): void
    {
        $rules = match ($field) {
            'graduation_year' => ['integer', 'min:1960', 'max:'.((int) date('Y') + 1)],
            'student_id' => ['string', 'max:50'],
            'batch' => ['string', 'max:30'],
            'full_name' => ['string', 'max:150'],
            default => ['string', 'max:255'],
        };

        Validator::make(
            ['value' => $value],
            ['value' => $rules]
        )->validate();
    }
}
