@extends('layouts.app')

@section('title', 'Settings & Profile — YES INDIA SCHOOLS ERP Admin')

@section('styles')
    <style>
        body {
            background-color: #ffffff !important;
            font-family: 'Figtree', 'Inter', sans-serif;
            font-weight: 400;
            color: #0f172a;
        }

        .settings-panel {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }

        .settings-panel-header {
            background: #f8fafc;
            padding: 1.25rem 1.75rem;
            border-bottom: 1px solid #e2e8f0;
            color: #0f172a;
        }

        .form-field label {
            display: block;
            font-size: 0.725rem;
            font-weight: 700;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.375rem;
        }

        .form-field input,
        .form-field textarea {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.625rem 0.875rem;
            font-size: 0.875rem;
            font-family: 'Figtree', sans-serif;
            font-weight: 400;
            background: #f8fafc;
            color: #0f172a;
            transition: all 0.2s;
            outline: none;
        }

        .form-field input:focus,
        .form-field textarea:focus {
            border-color: #271e6d;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(39, 30, 109, 0.1);
        }

        .toggle-track {
            position: relative;
            width: 52px;
            height: 28px;
            border-radius: 999px;
            transition: background 0.25s;
            cursor: pointer;
            flex-shrink: 0;
        }

        .toggle-thumb {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            transition: transform 0.25s;
        }

        /* Status Pills */
        .badge-on_going    { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
        .badge-registered  { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
        .badge-trial_running { background: #faf5ff; color: #7e22ce; border: 1px solid #e9d5ff; }
        .badge-under_construction { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    </style>
@endsection

@section('content')

    <x-admin-sidebar active="settings" />

    <div class="lg:pl-64 min-h-screen bg-white">

        {{-- Toast Banner --}}
        @if(session('success'))
        <div id="successToast"
             class="fixed top-5 right-5 z-50 flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-xl text-white font-semibold text-sm border border-emerald-700 bg-emerald-600 max-w-md">
            <i class="fa-solid fa-circle-check text-lg"></i>
            <div class="flex-1">{{ session('success') }}</div>
            <button onclick="document.getElementById('successToast').remove()" class="text-white/80 hover:text-white ml-2">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        @endif

        @if($errors->any())
        <div id="errorToast"
             class="fixed top-5 right-5 z-50 flex items-start gap-3 px-5 py-3.5 rounded-2xl shadow-xl text-white font-semibold text-sm border border-red-700 bg-red-600 max-w-md">
            <i class="fa-solid fa-triangle-exclamation text-lg mt-0.5"></i>
            <div class="flex-1 space-y-0.5">
                @foreach($errors->all() as $err)<p class="font-normal text-xs leading-snug">{{ $err }}</p>@endforeach
            </div>
            <button onclick="document.getElementById('errorToast').remove()" class="text-white/80 hover:text-white ml-2 mt-0.5">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        @endif

        <div class="p-4 sm:p-6 lg:p-8 max-w-6xl w-full mx-auto space-y-6 font-sans font-normal">

            {{-- Page Title --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Settings &amp; Profile</h1>
                    <p class="text-xs text-slate-500 mt-1 font-normal">Manage your admin account credentials and system-wide configurations.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}"
                   class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold text-xs transition-all shadow-xs">
                    <i class="fa-solid fa-arrow-left"></i> Dashboard
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- ══════════════════════════════════════ --}}
                {{-- PANEL 1: Admin Profile                 --}}
                {{-- ══════════════════════════════════════ --}}
                <div class="settings-panel">
                    <div class="settings-panel-header">
                        <div class="flex items-center gap-4">
                            {{-- Avatar --}}
                            <div class="w-14 h-14 rounded-2xl bg-[#271e6d] text-white flex items-center justify-center text-xl font-bold flex-shrink-0 shadow-xs">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 uppercase tracking-wider font-bold">Admin Profile</p>
                                <h2 class="text-lg font-bold text-slate-900 leading-tight">{{ $user->name }}</h2>
                                <p class="text-xs text-slate-500 font-normal mt-0.5">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.settings.profile') }}" method="POST" class="p-6 space-y-5">
                        @csrf

                        <div class="form-field">
                            <label>Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Admin display name" required>
                        </div>

                        <div class="form-field">
                            <label>Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="admin@example.com" required>
                        </div>

                        <div class="border-t border-slate-100 pt-5 space-y-4">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Change Password</p>

                            <div class="form-field">
                                <label>Current Password <span class="text-rose-500">*</span></label>
                                <input type="password" name="current_password" placeholder="Enter current password" required>
                            </div>

                            <div class="form-field">
                                <label>New Password <span class="text-slate-400 font-normal">(optional)</span></label>
                                <input type="password" name="new_password" placeholder="Leave blank to keep current">
                            </div>

                            <div class="form-field">
                                <label>Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" placeholder="Re-enter new password">
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit"
                                    class="w-full py-3 rounded-xl bg-[#271e6d] hover:bg-[#1f1659] text-white font-bold text-sm transition-all shadow-xs flex items-center justify-center gap-2">
                                <i class="fa-solid fa-floppy-disk"></i>
                                Save Profile Changes
                            </button>
                        </div>
                    </form>
                </div>

                {{-- ══════════════════════════════════════════ --}}
                {{-- PANEL 2: System Controls                   --}}
                {{-- ══════════════════════════════════════════ --}}
                <div class="space-y-5">

                    {{-- Registration Toggle Card --}}
                    <div class="settings-panel" x-data="{
                        enabled: {{ $registration_enabled === '1' ? 'true' : 'false' }},
                        notice: '{{ addslashes($registration_disabled_notice) }}',
                        saving: false,
                        async save() {
                            this.saving = true;
                            const fd = new FormData();
                            fd.append('registration_enabled', this.enabled ? '1' : '0');
                            fd.append('registration_disabled_notice', this.notice);
                            fd.append('_token', document.querySelector('meta[name=csrf-token]').content);
                            const r = await fetch('{{ route('admin.settings.registration') }}', { method: 'POST', body: fd, headers: { 'Accept': 'application/json' } });
                            const data = await r.json();
                            this.saving = false;
                            if (data.success) {
                                const t = document.getElementById('regToast');
                                t.classList.remove('hidden');
                                setTimeout(() => t.classList.add('hidden'), 4000);
                            }
                        }
                    }">
                        <div class="settings-panel-header flex items-center justify-between">
                            <div>
                                <p class="text-xs text-slate-400 uppercase tracking-wider font-bold">System Control</p>
                                <h2 class="text-base font-bold text-slate-900 mt-0.5">Public Registration Form</h2>
                            </div>
                            <i class="fa-solid fa-toggle-on text-2xl text-emerald-500"></i>
                        </div>

                        <div class="p-6 space-y-5">
                            {{-- Toast for AJAX save --}}
                            <div id="regToast" class="hidden flex items-center gap-2.5 px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold">
                                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                Registration settings saved successfully.
                            </div>

                            {{-- Status Indicator --}}
                            <div class="flex items-center justify-between p-4 rounded-2xl border transition-all"
                                 :class="enabled ? 'bg-emerald-50/70 border-emerald-200/80' : 'bg-rose-50/70 border-rose-200/80'">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider" :class="enabled ? 'text-emerald-700' : 'text-rose-700'">
                                        Registration Form
                                    </p>
                                    <p class="text-sm font-bold mt-0.5" :class="enabled ? 'text-emerald-800' : 'text-rose-800'">
                                        <span x-show="enabled">✓ Live &amp; Accepting Registrations</span>
                                        <span x-show="!enabled">✗ Paused — Public Form Hidden</span>
                                    </p>
                                </div>
                                {{-- Toggle Switch --}}
                                <div class="toggle-track" @click="enabled = !enabled"
                                     :style="enabled ? 'background: #10b981' : 'background: #e11d48'">
                                    <div class="toggle-thumb" :style="enabled ? 'transform: translateX(24px)' : 'transform: translateX(0)'"></div>
                                </div>
                            </div>

                            {{-- Disabled Notice Message --}}
                            <div x-show="!enabled" x-transition class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                    Disabled Notice Message
                                    <span class="text-rose-500">*</span>
                                </label>
                                <textarea x-model="notice" rows="3"
                                          class="w-full border border-slate-200 rounded-xl p-3 text-sm font-normal text-slate-700 bg-slate-50 focus:outline-none focus:border-[#271e6d] focus:ring-2 focus:ring-[#271e6d]/10 resize-none transition-all"
                                          placeholder="Message shown to applicants when registration is paused..."></textarea>
                                <p class="text-[11px] text-slate-400 font-normal">This message appears on the public registration page when the form is disabled.</p>
                            </div>

                            {{-- Save Button --}}
                            <button @click="save()"
                                    :disabled="saving"
                                    class="w-full py-3 rounded-xl font-bold text-sm transition-all shadow-xs flex items-center justify-center gap-2 text-white"
                                    :class="enabled ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-rose-600 hover:bg-rose-700'">
                                <i class="fa-solid" :class="saving ? 'fa-spinner animate-spin' : (enabled ? 'fa-check' : 'fa-ban')"></i>
                                <span x-text="saving ? 'Saving...' : (enabled ? 'Enable Registration' : 'Disable Registration')"></span>
                            </button>

                        </div>
                    </div>

                    {{-- System Info Card --}}
                    <div class="settings-panel">
                        <div class="settings-panel-header">
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-bold">System Information</p>
                            <h2 class="text-base font-bold text-slate-900 mt-0.5">Platform Details</h2>
                        </div>
                        <div class="p-6 space-y-3 text-xs font-normal">
                            <div class="flex justify-between items-center py-2.5 border-b border-slate-100">
                                <span class="text-slate-400 font-bold uppercase tracking-wider">Role</span>
                                <span class="font-mono font-bold text-slate-800 bg-slate-100 px-2 py-0.5 rounded-lg border border-slate-200">
                                    {{ ucfirst(str_replace('_', ' ', $user->role ?? 'admin')) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2.5 border-b border-slate-100">
                                <span class="text-slate-400 font-bold uppercase tracking-wider">Joined</span>
                                <span class="font-mono text-slate-700 font-normal">{{ $user->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2.5 border-b border-slate-100">
                                <span class="text-slate-400 font-bold uppercase tracking-wider">Registration</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                    {{ $registration_enabled === '1' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                    {{ $registration_enabled === '1' ? 'ENABLED' : 'DISABLED' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2.5">
                                <span class="text-slate-400 font-bold uppercase tracking-wider">ERP Version</span>
                                <span class="font-mono text-slate-700 font-normal">v2.4.0</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <x-admin-footer />

    </div>

@endsection
