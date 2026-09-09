<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\CommitteeType;

class CommitteePublicController extends Controller
{
    /**
     * Show committees page with floating sidebar.
     * Defaults to showing the current/latest committee.
     */
    public function index()
    {
        // All committees for sidebar (latest first)
        $allCommittees = Committee::query()
            ->with('type')
            ->orderByDesc('is_current')
            ->orderByDesc('start_year')
            ->orderByDesc('sort_order')
            ->get();

        // Find the current committee, or the latest one
        $selectedCommittee = $allCommittees->firstWhere('is_current', true)
            ?? $allCommittees->first();

        // Load selected committee with members grouped by role
        $groupedMembers = collect();
        if ($selectedCommittee) {
            $selectedCommittee->load('type');
            $members = $selectedCommittee->membersWithRoles();

            $groupedMembers = $members->groupBy('role_slug')->map(function ($roleMembers, $slug) {
                $first = $roleMembers->first();
                return [
                    'role' => (object) [
                        'id' => $first->pivot_committee_role_id,
                        'name' => $first->role_name,
                        'slug' => $slug,
                    ],
                    'members' => $roleMembers,
                ];
            })->values();
        }

        return view('pages.committees.index', [
            'allCommittees' => $allCommittees,
            'selectedCommittee' => $selectedCommittee,
            'groupedMembers' => $groupedMembers,
        ]);
    }

    /**
     * Show a specific committee (for sidebar click navigation).
     */
    public function show(CommitteeType $type, Committee $committee)
    {
        if ($committee->committee_type_id !== $type->id) {
            abort(404);
        }

        $committee->load('type');
        $members = $committee->membersWithRoles();

        $groupedMembers = $members->groupBy('role_slug')->map(function ($roleMembers, $slug) {
            $first = $roleMembers->first();
            return [
                'role' => (object) [
                    'id' => $first->pivot_committee_role_id,
                    'name' => $first->role_name,
                    'slug' => $slug,
                ],
                'members' => $roleMembers,
            ];
        })->values();

        // All committees for sidebar
        $allCommittees = Committee::query()
            ->with('type')
            ->orderByDesc('is_current')
            ->orderByDesc('start_year')
            ->orderByDesc('sort_order')
            ->get();

        return view('pages.committees.index', [
            'allCommittees' => $allCommittees,
            'selectedCommittee' => $committee,
            'groupedMembers' => $groupedMembers,
        ]);
    }

    /**
     * Legacy redirect — /committees/history/{type}
     */
    public function history(CommitteeType $type)
    {
        $committees = $type->committees()
            ->with('members')
            ->ordered()
            ->get();

        return view('pages.committees.history', [
            'type' => $type,
            'committees' => $committees,
        ]);
    }
}
