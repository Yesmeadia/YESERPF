@extends('layouts.app')

@section('title', $school->name . ' - YES INDIA SCHOOLS ERP Admin')

@section('styles')
    <style>
        body {
            background-color: #ffffff !important;
            color: #0f172a !important;
            font-family: 'Figtree', 'Inter', sans-serif;
            font-weight: 400;
        }

        .admin-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            transition: all 0.25s ease;
        }

        .admin-card:hover {
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.06);
            border-color: #cbd5e1;
        }

        .badge-on_going {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
        }

        .badge-registered {
            background: #fff1f2;
            color: #be123c;
            border: 1px solid #fecdd3;
        }

        .badge-trial_running {
            background: #faf5ff;
            color: #7e22ce;
            border: 1px solid #e9d5ff;
        }

        .badge-under_construction {
            background: #fffbeb;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        .info-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            font-size: 0.8125rem;
            font-weight: 400;
        }
    </style>
@endsection

@section('content')

    <!-- Sidebar Component -->
    <x-admin-sidebar active="schools" />

    <!-- Main Content Area -->
    <div class="lg:pl-64 min-h-screen flex flex-col justify-between bg-white">

        <!-- Page Content Container -->
        <div class="p-4 sm:p-6 lg:p-8 space-y-6 max-w-7xl w-full mx-auto">

            <!-- Back Navigation Bar -->
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.schools.index') }}"
                    class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold text-xs transition-all shadow-xs">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Back to School Directory</span>
                </a>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.schools.edit', $school->id) }}"
                        class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs transition-all shadow-xs inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Profile
                    </a>
                </div>
            </div>

            <!-- HERO PROFILE HEADER BANNER -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-6 sm:p-8 text-slate-900 relative overflow-hidden shadow-xs font-sans font-normal">
                <div class="relative z-10 space-y-6">

                    <!-- Top Meta Tags -->
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-mono text-xs font-semibold bg-slate-100 text-slate-800 px-3 py-1 rounded-xl border border-slate-200">
                                SUIC: {{ $school->suic_code ?? $school->code }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider badge-{{ $school->status }}">
                                {{ str_replace('_', ' ', $school->status) }}
                            </span>
                            <span class="text-xs font-semibold text-[#271e6d] bg-indigo-50 px-3 py-1 rounded-xl border border-indigo-200/60">
                                {{ $school->category->name ?? 'School Category' }}
                            </span>
                        </div>

                        <div class="text-xs text-slate-400 font-mono font-normal">
                            Registered: {{ $school->created_at->format('d M Y') }}
                        </div>
                    </div>

                    <!-- School Name & Location -->
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                            {{ $school->name }}
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500 font-normal flex items-center gap-2 mt-1">
                            <span><i class="fa-solid fa-location-dot text-emerald-600"></i>
                                {{ $school->state->name ?? 'N/A' }}</span>
                            <span>&bull;</span>
                            <span>{{ $school->zone->name ?? 'N/A' }} Zone</span>
                        </p>
                    </div>

                    <!-- KPI Metrics Summary Strip inside Hero -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-4 border-t border-slate-100">
                        <!-- Total Students -->
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/70">
                            <span class="text-[11px] text-slate-400 block uppercase font-bold tracking-wider">Total Students</span>
                            <span class="text-xl sm:text-2xl font-extrabold font-mono mt-0.5 block text-slate-900">
                                {{ number_format(($school->male_students ?? 0) + ($school->female_students ?? 0)) }}
                            </span>
                        </div>
                        <!-- Teaching Faculty -->
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/70">
                            <span class="text-[11px] text-slate-400 block uppercase font-bold tracking-wider">Teaching Staff</span>
                            <span class="text-xl sm:text-2xl font-extrabold font-mono mt-0.5 block text-slate-900">
                                {{ number_format(($school->teaching_male_staff ?? 0) + ($school->teaching_female_staff ?? 0)) }}
                            </span>
                        </div>
                        <!-- Non-Teaching Staff -->
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/70">
                            <span class="text-[11px] text-slate-400 block uppercase font-bold tracking-wider">Non-Teaching</span>
                            <span class="text-xl sm:text-2xl font-extrabold font-mono mt-0.5 block text-slate-900">
                                {{ number_format(($school->non_teaching_male_staff ?? 0) + ($school->non_teaching_female_staff ?? 0)) }}
                            </span>
                        </div>
                        <!-- Grand Total Staff -->
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/70">
                            <span class="text-[11px] text-slate-400 block uppercase font-bold tracking-wider">Total Staff</span>
                            <span class="text-xl sm:text-2xl font-extrabold font-mono mt-0.5 block text-slate-900">
                                {{ number_format(($school->teaching_male_staff ?? 0) + ($school->teaching_female_staff ?? 0) + ($school->non_teaching_male_staff ?? 0) + ($school->non_teaching_female_staff ?? 0)) }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- MAIN 2-COLUMN STRUCTURE GRID -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- LEFT COLUMN (7 Cols): Core Information & Details -->
                <div class="lg:col-span-7 space-y-6">

                    <!-- Campus Profile & Location Card -->
                    <div class="admin-card p-6 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-[#e2e1f0]">
                            <h3 class="text-xs font-extrabold text-[#271e6d] uppercase tracking-wider">
                                Campus Profile &amp; Location
                            </h3>
                            <span
                                class="font-mono text-xs font-bold text-[#271e6d] bg-[#f3f2fa] px-2.5 py-0.5 rounded-md border border-[#e2e1f0]">
                                SUIC: {{ $school->suic_code ?? 'N/A' }}
                            </span>
                        </div>

                        <div class="space-y-2.5">
                            <div class="info-row">
                                <span class="text-slate-500">Accreditation Category:</span>
                                <strong class="text-slate-900 font-semibold">{{ $school->category->name ?? 'N/A' }}</strong>
                            </div>
                            <div class="info-row">
                                <span class="text-slate-500">State:</span>
                                <strong class="text-slate-900 font-semibold">{{ $school->state->name ?? 'N/A' }}</strong>
                            </div>
                            <div class="info-row">
                                <span class="text-slate-500">Zone / Region:</span>
                                <strong class="text-slate-900 font-semibold">{{ $school->zone->name ?? 'N/A' }}</strong>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-slate-500 uppercase block mb-1.5">Official Postal
                                    Address:</span>
                                <div
                                    class="p-3.5 bg-[#f9f9fd] border border-[#e2e2ee] rounded-xl font-bold text-slate-800 text-xs uppercase leading-relaxed">
                                    {{ $school->address }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Principal & Contact Card -->
                    <div class="admin-card p-6 space-y-4">
                        <div class="pb-3 border-b border-[#e2e1f0]">
                            <h3 class="text-xs font-extrabold text-[#271e6d] uppercase tracking-wider">
                                Principal &amp; Contact Details
                            </h3>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <span class="text-xs font-bold text-slate-500 uppercase block mb-1.5">Name of
                                    Principal:</span>
                                <div
                                    class="p-3.5 bg-[#f9f9fd] border border-[#e2e2ee] rounded-xl font-bold text-[#271e6d] text-sm uppercase">
                                    {{ $school->principal_name ?? 'N/A' }}
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div class="info-row">
                                    <span class="text-slate-500">Phone:</span>
                                    <a href="tel:{{ $school->phone }}"
                                        class="font-mono font-bold text-slate-900 hover:text-[#271e6d]">{{ $school->phone }}</a>
                                </div>
                                <div class="info-row">
                                    <span class="text-slate-500">Email:</span>
                                    <a href="mailto:{{ $school->email }}"
                                        class="font-mono font-bold text-[#271e6d] hover:underline truncate">{{ $school->email }}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Web & Portal Configurations -->
                    @if($school->existing_domain || $school->desired_domain)
                        <div class="admin-card p-6 space-y-4">
                            <div class="pb-3 border-b border-[#e2e1f0]">
                                <h3 class="text-xs font-extrabold text-[#271e6d] uppercase tracking-wider">
                                    Web &amp; Domain Configurations
                                </h3>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @if($school->existing_domain)
                                    <div class="p-3 rounded-xl bg-[#f9f9fd] border border-[#e2e2ee] space-y-1">
                                        <span class="text-[11px] text-slate-500 block">Existing Website:</span>
                                        <a href="{{ $school->existing_domain }}" target="_blank"
                                            class="font-mono text-xs font-bold text-indigo-600 hover:underline truncate block">
                                            {{ $school->existing_domain }}
                                        </a>
                                    </div>
                                @endif

                                @if($school->desired_domain)
                                    <div class="p-3 rounded-xl bg-[#f9f9fd] border border-[#e2e2ee] space-y-1">
                                        <span class="text-[11px] text-slate-500 block">Desired ERP Subdomain:</span>
                                        <span class="font-mono text-xs font-bold text-purple-700 block">
                                            {{ $school->desired_domain }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>

                <!-- RIGHT COLUMN (5 Cols): Census Visual Breakdown & History -->
                <div class="lg:col-span-5 space-y-6">

                    <!-- Staff Census Breakdown Card -->
                    <div class="admin-card p-6 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-[#e2e1f0]">
                            <h3 class="text-xs font-extrabold text-[#271e6d] uppercase tracking-wider">
                                Staff Census Breakdown
                            </h3>
                            <span class="px-2.5 py-0.5 rounded-md bg-[#271e6d] text-white font-mono text-xs font-bold">
                                Total:
                                {{ ($school->teaching_male_staff ?? 0) + ($school->teaching_female_staff ?? 0) + ($school->non_teaching_male_staff ?? 0) + ($school->non_teaching_female_staff ?? 0) }}
                            </span>
                        </div>

                        <div class="space-y-3 text-xs">
                            <!-- Teaching Faculty -->
                            <div class="p-3.5 rounded-xl bg-[#f9f9fd] border border-[#e2e2ee] space-y-2">
                                <div class="flex items-center justify-between font-bold text-[#271e6d]">
                                    <span>Teaching Faculty</span>
                                    <span class="font-mono text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded">
                                        {{ ($school->teaching_male_staff ?? 0) + ($school->teaching_female_staff ?? 0) }}
                                    </span>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-slate-600 pt-1.5 border-t border-slate-200/70">
                                    <div>Male Teachers: <strong
                                            class="font-mono text-slate-900">{{ $school->teaching_male_staff ?? 0 }}</strong>
                                    </div>
                                    <div>Female Teachers: <strong
                                            class="font-mono text-slate-900">{{ $school->teaching_female_staff ?? 0 }}</strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Non-Teaching Faculty -->
                            <div class="p-3.5 rounded-xl bg-[#f9f9fd] border border-[#e2e2ee] space-y-2">
                                <div class="flex items-center justify-between font-bold text-[#271e6d]">
                                    <span>Non-Teaching Staff</span>
                                    <span class="font-mono text-purple-700 bg-purple-50 px-2 py-0.5 rounded">
                                        {{ ($school->non_teaching_male_staff ?? 0) + ($school->non_teaching_female_staff ?? 0) }}
                                    </span>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-slate-600 pt-1.5 border-t border-slate-200/70">
                                    <div>Male Non-Teaching: <strong
                                            class="font-mono text-slate-900">{{ $school->non_teaching_male_staff ?? 0 }}</strong>
                                    </div>
                                    <div>Female Non-Teaching: <strong
                                            class="font-mono text-slate-900">{{ $school->non_teaching_female_staff ?? 0 }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Student Census Breakdown Card -->
                    <div class="admin-card p-6 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-[#e2e1f0]">
                            <h3 class="text-xs font-extrabold text-[#271e6d] uppercase tracking-wider">
                                Student Census Breakdown
                            </h3>
                            <span class="px-2.5 py-0.5 rounded-md bg-indigo-100 text-[#271e6d] font-mono text-xs font-bold">
                                Enrolled:
                                {{ number_format(($school->male_students ?? 0) + ($school->female_students ?? 0)) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 text-center text-xs">
                            <div class="p-3.5 rounded-xl bg-[#f9f9fd] border border-[#e2e2ee]">
                                <span class="text-slate-500 block mb-1">Male Students</span>
                                <span
                                    class="text-xl font-bold font-mono text-[#271e6d]">{{ number_format($school->male_students ?? 0) }}</span>
                            </div>
                            <div class="p-3.5 rounded-xl bg-[#f9f9fd] border border-[#e2e2ee]">
                                <span class="text-slate-500 block mb-1">Female Students</span>
                                <span
                                    class="text-xl font-bold font-mono text-[#271e6d]">{{ number_format($school->female_students ?? 0) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Accreditation Status Audit History -->
                    <div class="admin-card p-6 space-y-4">
                        <div class="pb-3 border-b border-[#e2e1f0]">
                            <h3 class="text-xs font-extrabold text-[#271e6d] uppercase tracking-wider">
                                Accreditation History Log
                            </h3>
                        </div>

                        <div class="space-y-2.5 max-h-72 overflow-y-auto pr-1">
                            @forelse($school->statusHistories as $history)
                                <div class="p-3 rounded-xl bg-[#f9f9fd] border border-[#e2e2ee] text-xs space-y-1">
                                    <div class="flex items-center justify-between">
                                        <span
                                            class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider badge-{{ $history->status }}">
                                            {{ str_replace('_', ' ', $history->status) }}
                                        </span>
                                        <span class="font-mono text-[10px] text-slate-400">
                                            {{ $history->created_at->format('d M Y, h:i A') }}
                                        </span>
                                    </div>
                                    @if($history->notes)
                                        <p class="text-slate-700 italic pt-1 text-[11px]">"{{ $history->notes }}"</p>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-6 text-slate-400 text-xs">
                                    No status history recorded yet.
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- Admin Footer Component -->
        <x-admin-footer />

    </div>

@endsection