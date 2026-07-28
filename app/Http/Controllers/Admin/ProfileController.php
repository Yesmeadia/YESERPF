<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $loginHistory = \App\Models\ActivityLog::where('user_id', $user->id)
                            ->where('description', 'Logged in successfully')
                            ->latest()
                            ->take(10)
                            ->get();

        return view('admin.profile.index', compact('user', 'loginHistory'));
    }

    public function update(Request $request)
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
}
