@extends('layouts.app')

@section('title', 'Admin Profile — YES INDIA SCHOOLS ERP')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9ff !important;
            font-family: 'Figtree', sans-serif;
            color: #111c2d;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        .premium-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }
        .premium-card:hover {
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }

        .dash-table th {
            padding: 10px 12px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #505f76;
            border-bottom: 1px solid #e7eeff;
        }
        .dash-table td {
            padding: 14px 12px;
            font-size: 14px;
            vertical-align: middle;
            border-bottom: 1px solid #e7eeff;
        }
        .dash-table tbody tr:last-child td { border-bottom: none; }
        .dash-table tbody tr:hover { background: #f0f3ff; transition: background 0.15s; }

        .form-field label {
            display: block;
            font-size: 0.725rem;
            font-weight: 700;
            color: #505f76;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.375rem;
        }

        .form-field input {
            width: 100%;
            border: 1px solid #e7eeff;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            background: #f9f9ff;
            color: #111c2d;
            transition: all 0.2s;
            outline: none;
        }

        .form-field input:focus {
            border-color: #4f46e5;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
    </style>
@endsection

@section('content')

    <x-admin-sidebar active="profile" />

    <div class="lg:pl-64 min-h-screen">
        <div class="p-6 lg:p-8 max-w-6xl mx-auto space-y-6">

            <div class="flex items-center justify-between mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-[#111c2d]">Admin Profile</h1>
                    <p class="text-sm text-[#505f76] mt-1">Manage your account credentials and view login history.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Profile Settings Card -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="premium-card rounded-2xl overflow-hidden">
                        <div class="p-6 bg-[#f0f3ff] border-b border-[#e7eeff] flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-[#00030d] text-white flex items-center justify-center text-xl font-bold flex-shrink-0 shadow-md">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-xs text-[#505f76] uppercase tracking-wider font-bold">Administrator</p>
                                <h2 class="text-lg font-bold text-[#111c2d] leading-tight">{{ $user->name }}</h2>
                                <p class="text-xs text-[#505f76] font-normal mt-0.5">{{ $user->email }}</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.profile.update') }}" method="POST" class="p-6 space-y-5">
                            @csrf

                            <div class="form-field">
                                <label>Full Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Admin display name" required>
                            </div>

                            <div class="form-field">
                                <label>Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="admin@example.com" required>
                            </div>

                            <div class="border-t border-[#e7eeff] pt-5 space-y-4">
                                <h3 class="text-sm font-bold text-[#111c2d]">Change Password</h3>

                                <div class="form-field">
                                    <label>Current Password <span class="text-rose-500">*</span></label>
                                    <input type="password" name="current_password" placeholder="Enter current password" required>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="form-field">
                                        <label>New Password <span class="text-[#505f76] font-normal lowercase">(optional)</span></label>
                                        <input type="password" name="new_password" placeholder="Leave blank to keep current">
                                    </div>
    
                                    <div class="form-field">
                                        <label>Confirm New Password</label>
                                        <input type="password" name="new_password_confirmation" placeholder="Re-enter new password">
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 flex justify-end">
                                <button type="submit"
                                        class="px-6 py-2.5 rounded-xl bg-[#00030d] hover:bg-slate-800 text-white font-bold text-sm transition-all shadow-md flex items-center justify-center gap-2">
                                    <i class="fa-regular fa-floppy-disk"></i>
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Login History Card -->
                <div class="lg:col-span-1">
                    <div class="premium-card rounded-2xl flex flex-col h-full">
                        <div class="p-5 border-b border-[#e7eeff] flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#f0f3ff] text-[#4f46e5] flex items-center justify-center">
                                <span class="material-symbols-outlined text-[18px]">history</span>
                            </div>
                            <h3 class="text-base font-bold text-[#111c2d]">Login History</h3>
                        </div>
                        <div class="p-0 flex-1 overflow-y-auto max-h-[500px]">
                            @if($loginHistory->count() > 0)
                                <table class="w-full text-left dash-table">
                                    <thead>
                                        <tr>
                                            <th>Date & Time</th>
                                            <th>IP Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($loginHistory as $log)
                                            <tr>
                                                <td>
                                                    <div class="text-[#111c2d] font-medium">{{ $log->created_at->format('M d, Y') }}</div>
                                                    <div class="text-xs text-[#505f76]">{{ $log->created_at->format('h:i A') }}</div>
                                                </td>
                                                <td class="font-mono text-xs text-[#505f76]">{{ $log->ip_address ?? 'Unknown' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="p-8 text-center text-[#505f76] text-sm">
                                    No recent logins found.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
