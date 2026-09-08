<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display global activity log.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::query()
            ->with('user')
            ->orderByDesc('created_at');

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->input('action'));
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        $logs = $query->paginate(30)->withQueryString();

        // Get all admins for filter dropdown
        $admins = \App\Models\User::where('is_admin', true)
            ->orderBy('name')
            ->get();

        // Get unique actions for filter
        $actions = ActivityLog::distinct()->pluck('action')->sort()->values();

        return view('admin.activity-log.index', [
            'logs' => $logs,
            'admins' => $admins,
            'actions' => $actions,
        ]);
    }
}
