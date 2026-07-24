@extends('layouts.app')

@section('title', 'YES INDIA SCHOOLS ERP - School ERP Registration & Status Management System')

@section('content')

    <div class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-16">

        <!-- ==================== HEADER & BRAND SECTION ==================== -->
        <div class="text-center space-y-6">
            <!-- YES INDIA FOUNDATION Logo -->
            <div class="flex items-center justify-center">
                <img src="{{ asset('logo.png') }}" alt="YES INDIA FOUNDATION" class="h-16 sm:h-20 w-auto object-contain">
            </div>

            <!-- Main ERP Title -->
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black title-brand uppercase tracking-wider">
                YES INDIA SCHOOLS ERP
            </h1>

            <!-- Status Management Pill Badge -->
            <div>
                <div class="badge-status-top shadow-md">
                    <span class="dot-indicator-green dot-blink"></span>
                    <span>School ERP Registration &amp; Status Management System</span>
                </div>
            </div>
        </div>

        <!-- ==================== ZONE GROUPS & STATUS CARDS SECTION ==================== -->
        <div class="max-w-7xl mx-auto pt-4 space-y-10">
            @if($zoneGroups->isEmpty())
                <div class="text-center py-8 text-gray-500 text-sm">
                    No school zone records available.
                </div>
            @else
                @foreach($zoneGroups as $zoneGroup)
                    <div class="space-y-4">
                        {{-- Zone Pill Header (one per row) --}}
                        <div>
                            <span class="zone-pill-btn">
                                Zone : {{ $zoneGroup->name }}
                            </span>
                        </div>

                        {{-- Schools in a responsive horizontal grid for this zone --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($zoneGroup->schools as $school)
                                @php
                                    $dotColor = match ($school->status) {
                                        'on_going' => 'bg-[#10b981]',
                                        'registered' => 'bg-[#ef4444]',
                                        'trial_running' => 'bg-[#a855f7]',
                                        'under_construction' => 'bg-[#eab308]',
                                        default => 'bg-[#10b981]'
                                    };
                                    $statusLabel = match ($school->status) {
                                        'on_going' => 'On Going',
                                        'registered' => 'Registered',
                                        'trial_running' => 'Trial Running',
                                        'under_construction' => 'Under Construction',
                                        default => 'On Going'
                                    };
                                @endphp

                                <div class="card-status-dark">
                                    <div class="flex items-start gap-3">
                                        <span
                                            class="w-3.5 h-3.5 rounded-full {{ $dotColor }} shrink-0 mt-0.5 shadow-sm dot-blink"></span>
                                        <div class="flex-1 min-w-0">
                                            <h3
                                                class="text-xs sm:text-sm font-semibold uppercase tracking-wide text-white leading-snug line-clamp-2">
                                                {{ $school->name }}
                                            </h3>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="border-t border-dashed border-indigo-300/30 my-2.5"></div>
                                        <div class="flex items-center justify-between text-xs text-indigo-100 font-light tracking-wide">
                                            <span>{{ $statusLabel }}</span>
                                            <span class="text-[10px] text-indigo-300/60 uppercase font-mono">
                                                {{ $school->suic_code ?? $school->code }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- ==================== REGISTER YOUR CAMPUS CTA SECTION ==================== -->
        <div class="pt-10 pb-6 text-center max-w-2xl mx-auto space-y-6">
            <!-- Section Italic Heading -->
            <h2 class="text-3xl sm:text-4xl section-italic-title">
                Register Your Campus
            </h2>

            <p class="text-gray-500 text-sm sm:text-base leading-relaxed">
                Submit your institution's registration request to join India's unified educational accreditation and status
                tracking portal.
            </p>

            <div>
                <a href="{{ route('register') }}"
                    class="btn-purple-action inline-flex items-center gap-2 text-base px-10 py-4 shadow-xl">
                    <i class="fa-solid fa-circle-plus"></i>
                    <span>Register Your Campus</span>
                </a>
            </div>
        </div>

    </div>

@endsection