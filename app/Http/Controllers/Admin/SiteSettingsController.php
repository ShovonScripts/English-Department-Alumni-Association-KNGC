<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    /**
     * Show the site settings form.
     */
    public function index(): View
    {
        return view('admin.settings.index', [
            'announcementEnabled' => SiteSetting::announcementEnabled(),
            'announcementText' => SiteSetting::announcementText(),
        ]);
    }

    /**
     * Update site settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'announcement_enabled' => 'nullable',
            'announcement_text' => 'nullable|string|max:500',
        ]);

        SiteSetting::set('announcement_enabled', isset($validated['announcement_enabled']) ? '1' : '0');
        SiteSetting::set('announcement_text', $validated['announcement_text'] ?? '');

        return redirect()
            ->route('admin.settings.index')
            ->with('status', 'Site settings updated successfully.');
    }
}
