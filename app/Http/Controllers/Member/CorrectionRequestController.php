<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\CorrectionRequest;
use Illuminate\Http\Request;

class CorrectionRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'requested_field' => 'required|string|in:full_name,student_id,batch,graduation_year',
            'requested_value' => 'required|string|max:255',
            'reason' => 'required|string|max:1000',
        ]);

        $alumni = $request->user()->alumni;

        $exists = $alumni->correctionRequests()
            ->where('requested_field', $request->requested_field)
            ->where('status', CorrectionRequest::STATUS_PENDING)
            ->exists();

        if ($exists) {
            return back()->withErrors(['requested_field' => 'You already have a pending correction request for this field.']);
        }

        $alumni->correctionRequests()->create([
            'requested_field' => $request->requested_field,
            'requested_value' => $request->requested_value,
            'reason' => $request->reason,
            'status' => CorrectionRequest::STATUS_PENDING,
        ]);

        return back()->with('success', 'Correction request submitted successfully and is pending review.');
    }
}
