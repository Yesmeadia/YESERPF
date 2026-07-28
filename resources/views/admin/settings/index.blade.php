@extends('layouts.app')

@section('title', 'System Settings — YES INDIA SCHOOLS ERP Admin')

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

        .form-field input, .form-field textarea {
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

        .form-field input:focus, .form-field textarea:focus {
            border-color: #4f46e5;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
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
    </style>
@endsection

@section('content')

    <x-admin-sidebar active="settings" />

    <div class="lg:pl-64 min-h-screen">
        <div class="p-6 lg:p-8 max-w-6xl mx-auto space-y-6">

            <div class="flex items-center justify-between mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-[#111c2d]">System Settings</h1>
                    <p class="text-sm text-[#505f76] mt-1">Manage system-wide configurations, states, and zones.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Left Column: Locations -->
                <div class="space-y-6">
                    <!-- States Management -->
                    <div class="premium-card rounded-2xl overflow-hidden">
                        <div class="p-5 bg-[#f0f3ff] border-b border-[#e7eeff] flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-white text-[#4f46e5] flex items-center justify-center shadow-sm">
                                <span class="material-symbols-outlined text-[18px]">map</span>
                            </div>
                            <h2 class="text-base font-bold text-[#111c2d]">Manage States</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <form action="{{ route('admin.states.store') }}" method="POST" class="flex gap-3">
                                @csrf
                                <input type="text" name="name" placeholder="New State Name" required class="flex-1 border border-[#e7eeff] rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-[#4f46e5] bg-[#f9f9ff]">
                                <button type="submit" class="px-4 py-2 bg-[#00030d] hover:bg-slate-800 text-white text-sm font-bold rounded-xl whitespace-nowrap shadow-sm"><i class="fa-solid fa-plus mr-1"></i> Add</button>
                            </form>
                            
                            <div class="max-h-[250px] overflow-y-auto border border-[#e7eeff] rounded-xl divide-y divide-[#e7eeff]">
                                @foreach($states as $state)
                                    <div class="flex items-center justify-between px-4 py-3 text-sm">
                                        <div class="font-semibold text-[#111c2d]">
                                            {{ $state->name }}
                                            <span class="ml-2 text-[10px] bg-[#f0f3ff] text-[#505f76] px-2 py-0.5 rounded-full font-bold">{{ $state->schools_count }} schools</span>
                                        </div>
                                        <form action="{{ route('admin.states.destroy', $state->id) }}" method="POST" onsubmit="return confirm('Delete this state?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-700 disabled:opacity-50" {{ $state->schools_count > 0 ? 'disabled title="Cannot delete state with schools"' : '' }}>
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Zones Management -->
                    <div class="premium-card rounded-2xl overflow-hidden">
                        <div class="p-5 bg-[#f0f3ff] border-b border-[#e7eeff] flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-white text-[#4f46e5] flex items-center justify-center shadow-sm">
                                <span class="material-symbols-outlined text-[18px]">location_on</span>
                            </div>
                            <h2 class="text-base font-bold text-[#111c2d]">Manage Zones</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <form action="{{ route('admin.zones.store') }}" method="POST" class="flex gap-3">
                                @csrf
                                <input type="text" name="name" placeholder="New Zone Name" required class="flex-1 border border-[#e7eeff] rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-[#4f46e5] bg-[#f9f9ff]">
                                <button type="submit" class="px-4 py-2 bg-[#00030d] hover:bg-slate-800 text-white text-sm font-bold rounded-xl whitespace-nowrap shadow-sm"><i class="fa-solid fa-plus mr-1"></i> Add</button>
                            </form>
                            
                            <div class="max-h-[250px] overflow-y-auto border border-[#e7eeff] rounded-xl divide-y divide-[#e7eeff]">
                                @foreach($zones as $zone)
                                    <div class="flex items-center justify-between px-4 py-3 text-sm">
                                        <div class="font-semibold text-[#111c2d]">
                                            {{ $zone->name }}
                                            <span class="ml-2 text-[10px] bg-[#f0f3ff] text-[#505f76] px-2 py-0.5 rounded-full font-bold">{{ $zone->schools_count }} schools</span>
                                        </div>
                                        <form action="{{ route('admin.zones.destroy', $zone->id) }}" method="POST" onsubmit="return confirm('Delete this zone?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-700 disabled:opacity-50" {{ $zone->schools_count > 0 ? 'disabled title="Cannot delete zone with schools"' : '' }}>
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Registration Control & System Info -->
                <div class="space-y-6">
                    <!-- Registration Toggle Card -->
                    <div class="premium-card rounded-2xl overflow-hidden" x-data="{
                        enabled: {{ $registration_enabled === '1' ? 'true' : 'false' }},
                        notice: @js($registration_disabled_notice),
                        saving: false,
                        toast: '',
                        async save() {
                            this.saving = true;
                            try {
                                const r = await fetch('{{ route('admin.settings.registration') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                    },
                                    body: JSON.stringify({
                                        registration_enabled: this.enabled ? '1' : '0',
                                        registration_disabled_notice: this.notice
                                    })
                                });
                                const data = await r.json();
                                if (data.success) {
                                    this.toast = 'success';
                                } else {
                                    this.toast = 'error';
                                }
                            } catch(e) {
                                this.toast = 'error';
                            }
                            this.saving = false;
                            setTimeout(() => this.toast = '', 4000);
                        }
                    }">
                        <div class="p-5 bg-[#f0f3ff] border-b border-[#e7eeff] flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white text-[#4f46e5] flex items-center justify-center shadow-sm">
                                    <span class="material-symbols-outlined text-[18px]">settings_power</span>
                                </div>
                                <h2 class="text-base font-bold text-[#111c2d]">Public Registration Form</h2>
                            </div>
                        </div>

                        <div class="p-6 space-y-5">
                            <div x-show="toast === 'success'" x-transition class="flex items-center gap-2.5 px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold">
                                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                Registration settings saved successfully.
                            </div>
                            <div x-show="toast === 'error'" x-transition class="flex items-center gap-2.5 px-4 py-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold">
                                <i class="fa-solid fa-triangle-exclamation text-rose-500"></i>
                                Something went wrong. Please try again.
                            </div>

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
                                <div class="toggle-track" @click="enabled = !enabled"
                                     :style="enabled ? 'background: #10b981' : 'background: #e11d48'">
                                    <div class="toggle-thumb" :style="enabled ? 'transform: translateX(24px)' : 'transform: translateX(0)'"></div>
                                </div>
                            </div>

                            <div x-show="!enabled" x-transition class="space-y-2 form-field">
                                <label class="text-xs font-bold text-[#505f76] uppercase tracking-wider block">
                                    Disabled Notice Message <span class="text-rose-500">*</span>
                                </label>
                                <textarea x-model="notice" rows="3" placeholder="Message shown to applicants when registration is paused..."></textarea>
                                <p class="text-[11px] text-[#505f76] font-normal">This message appears on the public registration page when the form is disabled.</p>
                            </div>

                            <button @click="save()"
                                    :disabled="saving"
                                    class="w-full py-3 rounded-xl font-bold text-sm transition-all shadow-sm flex items-center justify-center gap-2 text-white"
                                    :class="enabled ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-rose-600 hover:bg-rose-700'">
                                <i class="fa-solid" :class="saving ? 'fa-spinner animate-spin' : (enabled ? 'fa-check' : 'fa-ban')"></i>
                                <span x-text="saving ? 'Saving...' : (enabled ? 'Enable Registration' : 'Disable Registration')"></span>
                            </button>
                        </div>
                    </div>

                    <!-- System Info Card -->
                    <div class="premium-card rounded-2xl overflow-hidden">
                        <div class="p-5 bg-[#f0f3ff] border-b border-[#e7eeff] flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-white text-[#4f46e5] flex items-center justify-center shadow-sm">
                                <span class="material-symbols-outlined text-[18px]">info</span>
                            </div>
                            <h2 class="text-base font-bold text-[#111c2d]">System Information</h2>
                        </div>
                        <div class="p-6 space-y-3 text-xs font-normal">
                            <div class="flex justify-between items-center py-2.5 border-b border-[#e7eeff]">
                                <span class="text-[#505f76] font-bold uppercase tracking-wider">Role</span>
                                <span class="font-mono font-bold text-[#111c2d] bg-[#f0f3ff] px-2 py-0.5 rounded-lg border border-[#e7eeff]">
                                    {{ ucfirst(str_replace('_', ' ', auth()->user()->role ?? 'admin')) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2.5 border-b border-[#e7eeff]">
                                <span class="text-[#505f76] font-bold uppercase tracking-wider">Registration</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                    {{ $registration_enabled === '1' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                    {{ $registration_enabled === '1' ? 'ENABLED' : 'DISABLED' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2.5">
                                <span class="text-[#505f76] font-bold uppercase tracking-wider">ERP Version</span>
                                <span class="font-mono text-[#505f76] font-normal">v2.4.0</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
