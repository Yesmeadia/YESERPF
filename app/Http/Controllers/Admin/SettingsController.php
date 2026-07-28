<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $registration_enabled = Setting::get('registration_enabled', '1');
        $registration_disabled_notice = Setting::get('registration_disabled_notice', 'Campus registrations are currently paused for institutional census audit.');
        
        $states = \App\Models\State::withCount('schools')->get();
        $zones = \App\Models\Zone::withCount('schools')->get();

        return view('admin.settings.index', compact('user', 'registration_enabled', 'registration_disabled_notice', 'states', 'zones'));
    }



    public function toggleRegistration(Request $request)
    {
        $request->validate([
            'registration_enabled'         => 'required|in:0,1',
            'registration_disabled_notice' => 'nullable|string|max:500',
        ]);

        $enabled = (string) $request->input('registration_enabled');
        $notice = $request->input('registration_disabled_notice') ?: 'Campus registrations are currently paused for institutional census audit.';

        Setting::set('registration_enabled', $enabled);
        Setting::set('registration_disabled_notice', $notice);

        $statusText = $enabled === '1' ? 'Enabled' : 'Disabled / Paused';

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'settings_updated',
            'description' => "Admin {$statusText} public campus registration form.",
            'ip_address'  => $request->ip(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Public campus registration form has been {$statusText}.",
                'enabled' => $enabled === '1',
            ]);
        }

        return back()->with('success', "Public campus registration form has been {$statusText}.");
    }
}
