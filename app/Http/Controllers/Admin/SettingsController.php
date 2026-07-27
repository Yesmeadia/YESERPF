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

        return view('admin.settings.index', compact('user', 'registration_enabled', 'registration_disabled_notice'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'required|string',
            'new_password'     => 'nullable|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided current password does not match our records.'])->withInput();
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        ActivityLog::create([
            'user_id'     => $user->id,
            'description' => "Admin profile updated for user: {$user->email}",
            'ip_address'  => $request->ip(),
        ]);

        return back()->with('success', 'Profile and account credentials updated successfully.');
    }

    public function toggleRegistration(Request $request)
    {
        $request->validate([
            'registration_enabled'         => 'required|in:0,1',
            'registration_disabled_notice' => 'nullable|string|max:500',
        ]);

        $enabled = (string) $request->registration_enabled;
        $notice = $request->registration_disabled_notice ?: 'Campus registrations are currently paused for institutional census audit.';

        Setting::set('registration_enabled', $enabled);
        Setting::set('registration_disabled_notice', $notice);

        $statusText = $enabled === '1' ? 'Enabled' : 'Disabled / Paused';

        ActivityLog::create([
            'user_id'     => auth()->id(),
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
