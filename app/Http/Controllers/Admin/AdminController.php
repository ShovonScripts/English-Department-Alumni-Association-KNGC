<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * List all admin users.
     */
    public function index()
    {
        $admins = User::query()
            ->where('is_admin', true)
            ->withCount('activityLogs')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.admins.index', ['admins' => $admins]);
    }

    /**
     * Show create admin form.
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Store a new admin user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->forceFill([
            'is_admin' => true,
            'status' => 'active',
        ])->save();

        ActivityLog::log('admin_created', "Created admin user: {$user->name}", $user);

        return redirect()
            ->route('admin.admins.index')
            ->with('status', "Admin user \"{$user->name}\" created successfully.");
    }

    /**
     * Show admin details.
     */
    public function show(User $admin)
    {
        abort_unless($admin->is_admin, 404);

        $activityLogs = $admin->activityLogs()
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.admins.show', [
            'admin' => $admin,
            'activityLogs' => $activityLogs,
        ]);
    }

    /**
     * Show edit admin form.
     */
    public function edit(User $admin)
    {
        abort_unless($admin->is_admin, 404);

        return view('admin.admins.edit', ['admin' => $admin]);
    }

    /**
     * Update admin user.
     */
    public function update(Request $request, User $admin)
    {
        abort_unless($admin->is_admin, 404);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:active,disabled',
        ]);

        $admin->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $admin->password,
        ]);

        $admin->forceFill(['status' => $validated['status']])->save();

        ActivityLog::log('admin_updated', "Updated admin user: {$admin->name}", $admin);

        return redirect()
            ->route('admin.admins.index')
            ->with('status', "Admin user \"{$admin->name}\" updated successfully.");
    }

    /**
     * Delete an admin user.
     */
    public function destroy(User $admin)
    {
        abort_unless($admin->is_admin, 404);

        // Prevent self-deletion
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $name = $admin->name;
        $admin->delete();

        ActivityLog::log('admin_deleted', "Deleted admin user: {$name}");

        return redirect()
            ->route('admin.admins.index')
            ->with('status', "Admin user \"{$name}\" deleted successfully.");
    }

    /**
     * Toggle admin status (enable/disable).
     */
    public function toggleStatus(User $admin)
    {
        abort_unless($admin->is_admin, 404);

        if ($admin->id === auth()->id()) {
            return back()->with('error', 'You cannot disable your own account.');
        }

        $admin->status = $admin->status === 'active' ? 'disabled' : 'active';
        $admin->save();

        $statusText = $admin->status === 'active' ? 'enabled' : 'disabled';
        ActivityLog::log('admin_status_toggled', " {$statusText} admin user: {$admin->name}", $admin);

        return back()->with('status', "Admin user \"{$admin->name}\" {$statusText}.");
    }
}
