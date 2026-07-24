@extends('layouts.app')

@section('title', 'School Full Record - YES INDIA SCHOOLS ERP Admin')

@section('styles')
    <style>
        body {
            background-color: #f8fafc !important;
            color: #1e1b4b !important;
            font-family: 'Inter', sans-serif;
        }

        .admin-card-light {
            background: #ffffff;
            border: 1px solid #e2e1f0;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(39, 30, 109, 0.04);
        }

        .badge-on_going {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .badge-registered {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .badge-trial_running {
            background: #f3e8ff;
            color: #6b21a8;
            border: 1px solid #e9d5ff;
        }

        .badge-under_construction {
            background: #fef9c3;
            color: #854d0e;
            border: 1px solid #fef08a;
        }
    </style>
@endsection

@section('content')

    <!-- Sidebar Component -->
    <x-admin-sidebar active="schools" />

    <!-- Main Content Area -->
    <div class="lg:pl-64 min-h-screen flex flex-col justify-between">

        <!-- Page Content Container -->
        <div class="p-4 sm:p-6 lg:p-8 space-y-6 max-w-6xl w-full mx-auto">

            <!-- Back Button & Page Header -->
            <div class="flex items-center justify-between pb-4 border-b border-[#e2e1f0]">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.schools.index') }}"
                        class="w-9 h-9 rounded-xl bg-[#f3f2fa] border border-[#e2e1f0] text-[#271e6d] hover:bg-[#e8e6f5] flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-arrow-left text-sm"></i>
                    </a>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-mono text-xs font-bold text-[#271e6d]">SUIC:
                                {{ $school->suic_code ?? $school->code }}</span>
                            <span
                                class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider badge-{{ $school->status }}">
                                {{ str_replace('_', ' ', $school->status) }}
                            </span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-black text-[#271e6d] tracking-tight mt-0.5">
                            {{ $school->name }}
                        </h1>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.schools.index') }}" class="btn-purple-action text-xs px-4 py-2">
                        <i class="fa-solid fa-list-check mr-1.5"></i> All Schools
                    </a>
                </div>
            </div>

            <!-- Full Record Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- 1. School Information Card -->
                <div class="admin-card-light p-6 space-y-4">
                    <div class="flex items-center gap-2 text-sm font-bold text-[#271e6d] pb-3 border-b border-[#e2e1f0]">
                        <i class="fa-solid fa-school text-indigo-500"></i>
                        <span>School Profile &amp; Accreditation</span>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">SUIC Code:</span>
                            <span
                                class="font-mono font-bold text-[#271e6d] bg-[#f3f2fa] px-2.5 py-1 rounded-lg border border-[#e2e1f0]">{{ $school->suic_code ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Category:</span>
                            <span class="font-semibold text-slate-900">{{ $school->category->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">State:</span>
                            <span class="font-semibold text-slate-900">{{ $school->state->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Zone:</span>
                            <span class="font-semibold text-slate-900">{{ $school->zone->name ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-500 block mb-1">Official Address:</span>
                            <div
                                class="p-3 bg-[#f9f9fd] border border-[#e2e2ee] rounded-xl font-semibold text-slate-800 uppercase">
                                {{ $school->address }}
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-between text-[11px] text-slate-400 pt-2 border-t border-slate-100">
                            <span>Registered On:</span>
                            <span>{{ $school->created_at->format('d M Y, h:i A') }}</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Contact & Principal Data Card -->
                <div class="admin-card-light p-6 space-y-4">
                    <div class="flex items-center gap-2 text-sm font-bold text-[#271e6d] pb-3 border-b border-[#e2e1f0]">
                        <i class="fa-solid fa-user-tie text-indigo-500"></i>
                        <span>Principal &amp; Contact Details</span>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div>
                            <span class="text-slate-500 block mb-1">Name of Principal:</span>
                            <div
                                class="p-3 bg-[#f9f9fd] border border-[#e2e2ee] rounded-xl font-bold text-[#271e6d] text-sm uppercase">
                                {{ $school->principal_name ?? 'N/A' }}
                            </div>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-[#f9f9fd] border border-[#e2e2ee] rounded-xl">
                            <span class="text-slate-500 flex items-center gap-1.5"><i
                                    class="fa-solid fa-phone text-indigo-500"></i> Phone:</span>
                            <span class="font-mono font-bold text-slate-900">{{ $school->phone }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-[#f9f9fd] border border-[#e2e2ee] rounded-xl">
                            <span class="text-slate-500 flex items-center gap-1.5"><i
                                    class="fa-solid fa-envelope text-indigo-500"></i> Email:</span>
                            <span class="font-mono font-bold text-[#271e6d]">{{ $school->email }}</span>
                        </div>
                    </div>
                </div>

                <!-- 3. Staff Breakdown Card -->
                <div class="admin-card-light p-6 space-y-4">
                    <div class="flex items-center gap-2 text-sm font-bold text-[#271e6d] pb-3 border-b border-[#e2e1f0]">
                        <i class="fa-solid fa-users-gear text-indigo-500"></i>
                        <span>Staff Census Breakdown</span>
                    </div>

                    <div class="space-y-3 text-xs">
                        <!-- Teaching Staff -->
                        <div class="p-3 rounded-xl bg-[#f9f9fd] border border-[#e2e2ee] space-y-1.5">
                            <div class="font-bold text-[#271e6d] flex items-center justify-between">
                                <span>Teaching Staff</span>
                                <span class="text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md font-mono text-xs">
                                    Sub-Total:
                                    {{ ($school->teaching_male_staff ?? 0) + ($school->teaching_female_staff ?? 0) }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-[11px] text-slate-600 pt-1 border-t border-slate-200">
                                <div>Male: <strong>{{ $school->teaching_male_staff ?? 0 }}</strong></div>
                                <div>Female: <strong>{{ $school->teaching_female_staff ?? 0 }}</strong></div>
                            </div>
                        </div>

                        <!-- Non-Teaching Staff -->
                        <div class="p-3 rounded-xl bg-[#f9f9fd] border border-[#e2e2ee] space-y-1.5">
                            <div class="font-bold text-[#271e6d] flex items-center justify-between">
                                <span>Non-Teaching Staff</span>
                                <span class="text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md font-mono text-xs">
                                    Sub-Total:
                                    {{ ($school->non_teaching_male_staff ?? 0) + ($school->non_teaching_female_staff ?? 0) }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-[11px] text-slate-600 pt-1 border-t border-slate-200">
                                <div>Male: <strong>{{ $school->non_teaching_male_staff ?? 0 }}</strong></div>
                                <div>Female: <strong>{{ $school->non_teaching_female_staff ?? 0 }}</strong></div>
                            </div>
                        </div>

                        <!-- Grand Total Staff -->
                        <div class="flex items-center justify-between p-3 rounded-xl bg-[#271e6d] text-white font-bold">
                            <span>Grand Total Staff (All)</span>
                            <span
                                class="font-mono text-base">{{ ($school->teaching_male_staff ?? 0) + ($school->teaching_female_staff ?? 0) + ($school->non_teaching_male_staff ?? 0) + ($school->non_teaching_female_staff ?? 0) }}</span>
                        </div>
                    </div>
                </div>

                <!-- 4. Students Breakdown Card -->
                <div class="admin-card-light p-6 space-y-4">
                    <div class="flex items-center gap-2 text-sm font-bold text-[#271e6d] pb-3 border-b border-[#e2e1f0]">
                        <i class="fa-solid fa-graduation-cap text-indigo-500"></i>
                        <span>Students Census Breakdown</span>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-3 rounded-xl bg-[#f9f9fd] border border-[#e2e2ee] text-center">
                                <span class="text-slate-500 text-[11px] block">Male Students</span>
                                <span
                                    class="text-lg font-black text-[#271e6d] font-mono">{{ $school->male_students ?? 0 }}</span>
                            </div>
                            <div class="p-3 rounded-xl bg-[#f9f9fd] border border-[#e2e2ee] text-center">
                                <span class="text-slate-500 text-[11px] block">Female Students</span>
                                <span
                                    class="text-lg font-black text-[#271e6d] font-mono">{{ $school->female_students ?? 0 }}</span>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between p-3 rounded-xl bg-indigo-50 border border-indigo-200 text-[#271e6d] font-bold">
                            <span>Total Enrolled Students</span>
                            <span
                                class="font-mono text-base">{{ ($school->male_students ?? 0) + ($school->female_students ?? 0) }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- 5. Accreditation Timeline Audit History -->
            <div class="admin-card-light p-6 space-y-4">
                <div class="flex items-center gap-2 text-sm font-bold text-[#271e6d] pb-3 border-b border-[#e2e1f0]">
                    <i class="fa-solid fa-timeline text-indigo-500"></i>
                    <span>Accreditation Status History Log</span>
                </div>

                <div class="space-y-3">
                    @forelse($school->statusHistories as $history)
                        <div
                            class="p-3.5 rounded-xl bg-[#f9f9fd] border border-[#e2e2ee] text-xs flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div class="space-y-0.5">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider badge-{{ $history->status }}">
                                        {{ str_replace('_', ' ', $history->status) }}
                                    </span>
                                    @if($history->user)
                                        <span class="text-[11px] text-slate-500">Updated by
                                            <strong>{{ $history->user->name }}</strong></span>
                                    @endif
                                </div>
                                @if($history->notes)
                                    <p class="text-slate-700 italic pt-1">"{{ $history->notes }}"</p>
                                @endif
                            </div>
                            <span class="font-mono text-[10px] text-slate-400 shrink-0">
                                {{ $history->created_at->format('d M Y, h:i A') }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 text-xs">
                            No status modifications recorded yet.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Admin Footer Component -->
        <x-admin-footer />

    </div>

@endsection