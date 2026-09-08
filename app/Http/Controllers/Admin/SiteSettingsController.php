<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            // Announcement
            'announcement_enabled' => 'nullable',
            'announcement_text' => 'nullable|string|max:500',

            // Branding
                        'favicon' => 'nullable|image|mimes:ico,png,svg,jpeg|max:8192',
            'logo_light' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:8192',
            'logo_dark' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:8192',
            'site_name' => 'nullable|string|max:255',
            'site_short_name' => 'nullable|string|max:50',
            'site_tagline' => 'nullable|string|max:255',
            'site_description' => 'nullable|string|max:1000',

            // Contact
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string|max:500',

            // Social
            'social_facebook' => 'nullable|url|max:500',
            'social_facebook_group' => 'nullable|url|max:500',
            'social_twitter' => 'nullable|url|max:500',
            'social_linkedin' => 'nullable|url|max:500',
            'social_youtube' => 'nullable|url|max:500',
            'social_instagram' => 'nullable|url|max:500',
        ]);

        // Announcement
        SiteSetting::set('announcement_enabled', isset($validated['announcement_enabled']) ? '1' : '0');
        SiteSetting::set('announcement_text', $validated['announcement_text'] ?? '');

        // Branding — file uploads
        if ($request->hasFile('favicon')) {
            $old = SiteSetting::get('favicon_path');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            SiteSetting::set('favicon_path', $request->file('favicon')->store('branding', 'public'));
        }

        if ($request->hasFile('logo_light')) {
            $old = SiteSetting::get('logo_light_path');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            SiteSetting::set('logo_light_path', $request->file('logo_light')->store('branding', 'public'));
        }

        if ($request->hasFile('logo_dark')) {
            $old = SiteSetting::get('logo_dark_path');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            SiteSetting::set('logo_dark_path', $request->file('logo_dark')->store('branding', 'public'));
        }

        // Branding — text
        SiteSetting::set('site_name', $validated['site_name'] ?? '');
        SiteSetting::set('site_short_name', $validated['site_short_name'] ?? '');
        SiteSetting::set('site_tagline', $validated['site_tagline'] ?? '');
        SiteSetting::set('site_description', $validated['site_description'] ?? '');

        // Contact info
        SiteSetting::set('contact_email', $validated['contact_email'] ?? '');
        SiteSetting::set('contact_phone', $validated['contact_phone'] ?? '');
        SiteSetting::set('contact_address', $validated['contact_address'] ?? '');

        // Social links
        $socialKeys = ['facebook', 'facebook_group', 'twitter', 'linkedin', 'youtube', 'instagram'];
        foreach ($socialKeys as $key) {
            $field = "social_{$key}";
            if (array_key_exists($field, $validated)) {
                SiteSetting::set("social_{$key}", $validated[$field] ?? '');
            }
        }

        return redirect()
            ->route('admin.settings.index')
            ->with('status', 'Site settings updated successfully.');
    }
}
