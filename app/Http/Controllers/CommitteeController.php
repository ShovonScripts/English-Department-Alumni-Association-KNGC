<?php

namespace App\Http\Controllers;

use App\Models\CommitteeMember;

class CommitteeController extends Controller
{
    public function index()
    {
        $members = CommitteeMember::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('pages.committee', [
            'members' => $members,
        ]);
    }

    public function show(CommitteeMember $committeeMember)
    {
        abort_unless($committeeMember->is_active, 404);

        return view('pages.committee-show', [
            'member' => $committeeMember,
        ]);
    }
}
