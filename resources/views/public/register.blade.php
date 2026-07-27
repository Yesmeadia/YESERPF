@extends('layouts.app')

@section('title', 'Register Your Campus - YES INDIA SCHOOLS ERP')

@section('content')

    {{-- ── Success Overlay (hidden until submit) ────────────────────────────── --}}
    <div id="successOverlay"
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm hidden"
        aria-live="polite" role="dialog" aria-modal="true">
        <div class="bg-white rounded-3xl shadow-2xl p-10 max-w-md w-full mx-4 text-center space-y-5 animate-bounce-in">
            <div class="w-20 h-20 rounded-full bg-emerald-100 flex items-center justify-center mx-auto">
                <i class="fa-solid fa-circle-check text-emerald-500 text-4xl"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-[#271e6d]">Registration Successful!</h2>
            <p id="successMsg" class="text-gray-600 text-sm leading-relaxed"></p>
            <div id="successCode"
                class="inline-block px-5 py-2.5 bg-[#f3f2fa] rounded-xl border border-[#e2e1f0] font-mono text-[#271e6d] text-sm font-bold hidden">
            </div>
            <div class="pt-2 space-y-1">
                <p class="text-xs text-gray-400">Redirecting to home page…</p>
                <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                    <div id="redirectBar" class="h-full bg-emerald-500 rounded-full transition-none" style="width:100%;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto space-y-8 font-sans font-normal text-slate-800">

        <!-- ==================== HEADER BAR ==================== -->
        <div class="flex items-center justify-between pt-2 pb-1">
            <h1 class="text-base sm:text-lg font-bold text-[#1f1659] tracking-wider uppercase font-sans">
                YES INDIA SCHOOLS REGISTRATION PORTAL
            </h1>
            <div
                class="flex items-center gap-2 text-[11px] sm:text-xs font-semibold text-slate-500 uppercase tracking-widest font-sans">
                <span
                    class="w-2 h-2 rounded-full {{ $registration_enabled === '1' ? 'bg-emerald-500 dot-blink' : 'bg-rose-500' }}"></span>
                <span>{{ $registration_enabled === '1' ? 'LIVE MONITORING' : 'REGISTRATIONS PAUSED' }}</span>
            </div>
        </div>

        @php
            $isLive = $registration_enabled === '1';
            $bannerBg = $isLive ? 'bg-[#3af0a4]' : 'bg-rose-600';
            $textColor = $isLive ? 'text-[#044e37]' : 'text-white';
            $subtextColor = $isLive ? 'text-[#065f46]' : 'text-rose-100';
            $iconBg = $isLive ? 'bg-[#044e37]' : 'bg-rose-950/40';
            $iconColor = $isLive ? 'text-[#3af0a4]' : 'text-rose-200';
            $statusText = $isLive ? 'ONLINE' : 'OFFLINE';
            $statusColor = $isLive ? 'text-[#044e37]' : 'text-white';
            $statusLabel = $isLive ? 'STATUS PORTAL' : 'REGISTRATION STATUS';
        @endphp

        <!-- ==================== HERO TOPIC BANNER (REGISTRATION) ==================== -->
        <div
            class="{{ $bannerBg }} rounded-2xl p-6 sm:p-7 {{ $textColor }} flex flex-col sm:flex-row sm:items-center justify-between gap-5 shadow-sm transition-all duration-300">
            <div class="flex items-center gap-4">
                <div
                    class="w-10 h-10 rounded-full {{ $iconBg }} {{ $iconColor }} flex items-center justify-center text-lg font-bold shrink-0">
                    <i class="fa-solid {{ $isLive ? 'fa-id-card' : 'fa-ban' }}"></i>
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold tracking-tight leading-tight">
                        Institutional Accreditation &amp; Registration Portal
                    </h2>
                    <p class="text-xs sm:text-sm font-normal {{ $subtextColor }} mt-0.5">
                        @if($isLive)
                            Submit institutional credentials for ERP status tracking, domain verification, &amp; zone
                            allocation.
                        @else
                            {{ $registration_disabled_notice }}
                        @endif
                    </p>
                </div>
            </div>
            <div class="text-left sm:text-right shrink-0">
                <div class="text-[10px] font-bold uppercase tracking-widest {{ $subtextColor }}">
                    {{ $statusLabel }}
                </div>
                <div class="text-xl sm:text-2xl font-normal font-mono {{ $statusColor }} mt-0.5">
                    {{ $statusText }}
                </div>
            </div>
        </div>

        <!-- Campus Registration Form Container -->
        <div class="relative max-w-5xl mx-auto space-y-6">

            <div class="{{ !$isLive ? 'pointer-events-none select-none filter blur-[3px] opacity-40' : '' }}">

                <!-- Step Indicator Pills -->
                <div class="flex items-center justify-center gap-3 text-xs font-semibold pt-2">
                    <span id="badgeStep1"
                        class="px-4 py-2 rounded-full bg-[#1f1659] text-white shadow-sm flex items-center gap-2 transition-all">
                        <span
                            class="w-5 h-5 rounded-full bg-white text-[#1f1659] text-xs flex items-center justify-center font-bold">1</span>
                        <span>School Information</span>
                    </span>
                    <i class="fa-solid fa-chevron-right text-slate-300 text-xs"></i>
                    <span id="badgeStep2"
                        class="px-4 py-2 rounded-full bg-slate-100 text-slate-400 flex items-center gap-2 transition-all">
                        <span
                            class="w-5 h-5 rounded-full bg-slate-200 text-slate-600 text-xs flex items-center justify-center font-bold">2</span>
                        <span>Staff &amp; Students Data</span>
                    </span>
                </div>

                <!-- Alert Notification Box -->
                <div id="alertBox" class="hidden"></div>

                <form id="registrationForm" action="{{ route('register.submit') }}" method="POST" class="space-y-12">
                    @csrf

                    <!-- ================= STEP 1: School Information ================= -->
                    <div id="step-1" class="space-y-6">
                        <!-- Section Header with Green Dot -->
                        <div class="flex items-center gap-3">
                            <span class="dot-indicator-green dot-blink"></span>
                            <h3 class="text-base sm:text-lg font-semibold text-[#271e6d]">
                                School Information
                            </h3>
                        </div>

                        <!-- Row 1: 3 Select Pills -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <select id="stateSelect" name="state_id" required class="form-pill-select">
                                    <option value="">Select Your State</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-red-500 text-xs mt-1 block" id="err-state_id"></span>
                            </div>

                            <div>
                                <select id="zoneSelect" name="zone_id" required disabled
                                    class="form-pill-select opacity-70">
                                    <option value="">Select Your Zone</option>
                                </select>
                                <span id="zoneLoading" class="text-xs text-indigo-600 mt-1 hidden">
                                    <i class="fa-solid fa-spinner fa-spin mr-1"></i> Loading zones...
                                </span>
                                <span class="text-red-500 text-xs mt-1 block" id="err-zone_id"></span>
                            </div>

                            <div>
                                <select name="category_id" required class="form-pill-select">
                                    <option value="">Select Your School Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-red-500 text-xs mt-1 block" id="err-category_id"></span>
                            </div>
                        </div>

                        <!-- Row 2: Name of School -->
                        <div>
                            <label class="block text-xs sm:text-sm font-semibold text-[#271e6d] mb-1.5">
                                Name of School (As per Official Records) with place
                            </label>
                            <input type="text" name="name" id="inp-name" required
                                placeholder="e.g. YASEEN ENGLISH SCHOOL - MALOORA" class="form-pill-input input-uppercase"
                                oninput="this.value=this.value.toUpperCase()">
                            <span class="text-[11px] text-gray-400 mt-1 block">
                                <i class="fa-solid fa-circle-info mr-1 text-indigo-400"></i>Reference: YASEEN ENGLISH SCHOOL
                                -
                                MALOORA
                            </span>
                            <span class="text-red-500 text-xs mt-1 block" id="err-name"></span>
                        </div>

                        <!-- Row 3: Contact & Email -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-[#271e6d] mb-1.5">
                                    School Contact Number
                                </label>
                                <input type="tel" name="phone" id="inp-phone" required placeholder="e.g. +91 9876543210"
                                    class="form-pill-input" maxlength="15" oninput="validateIndianPhone(this)">
                                <span class="text-[10px] text-gray-400 mt-1 block">
                                    <i class="fa-solid fa-circle-info mr-1 text-indigo-400"></i>Valid Indian mobile number
                                    only
                                    (10 digits, starts with 6-9)
                                </span>
                                <span class="text-red-500 text-xs mt-1 block" id="err-phone"></span>
                            </div>

                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-[#271e6d] mb-1.5">
                                    School Email ID
                                </label>
                                <input type="email" name="email" id="inp-email" required placeholder="principal@school.edu"
                                    class="form-pill-input" oninput="validateEmail(this)" onblur="validateEmailBlur(this)">
                                <span class="text-[10px] text-gray-400 mt-1 block">
                                    <i class="fa-solid fa-circle-info mr-1 text-indigo-400"></i>Enter a valid email address
                                    (e.g. name@domain.com)
                                </span>
                                <span class="text-red-500 text-xs mt-1 block" id="err-email"></span>
                            </div>
                        </div>

                        <!-- Row 4: Address of School -->
                        <div>
                            <label class="block text-xs sm:text-sm font-semibold text-[#271e6d] mb-1.5">
                                Address of School (As per Official Records)
                            </label>
                            <textarea name="address" id="inp-address" rows="3" required placeholder=""
                                class="form-pill-input input-uppercase"
                                oninput="this.value=this.value.toUpperCase()"></textarea>
                            <span class="text-red-500 text-xs mt-1 block" id="err-address"></span>
                        </div>

                        <!-- Row 5: SUIC -->
                        <div class="w-full sm:w-1/2">
                            <label class="block text-xs sm:text-sm font-semibold text-[#271e6d] mb-1.5">
                                School Unique Identification Code (SUIC)
                                <span class="text-[10px] font-normal text-gray-400 ml-1">(6 uppercase letters)</span>
                            </label>
                            <input type="text" name="suic_code" id="inp-suic_code" required maxlength="6" minlength="6"
                                pattern="[A-Z]{6}" placeholder="e.g. ABCDEF"
                                class="form-pill-input input-uppercase tracking-[0.35em] font-mono"
                                oninput="this.value=this.value.replace(/[^A-Za-z]/g,'').toUpperCase().slice(0,6);updateSuicCounter(this.value.length);">
                            <!-- 6-dot progress counter -->
                            <div id="suicCounter" class="flex gap-1 mt-2" aria-label="SUIC character progress">
                                <span
                                    class="suic-dot w-4 h-1.5 rounded-full bg-gray-200 transition-colors duration-150"></span>
                                <span
                                    class="suic-dot w-4 h-1.5 rounded-full bg-gray-200 transition-colors duration-150"></span>
                                <span
                                    class="suic-dot w-4 h-1.5 rounded-full bg-gray-200 transition-colors duration-150"></span>
                                <span
                                    class="suic-dot w-4 h-1.5 rounded-full bg-gray-200 transition-colors duration-150"></span>
                                <span
                                    class="suic-dot w-4 h-1.5 rounded-full bg-gray-200 transition-colors duration-150"></span>
                                <span
                                    class="suic-dot w-4 h-1.5 rounded-full bg-gray-200 transition-colors duration-150"></span>
                                <span class="text-[10px] text-gray-400 ml-1" id="suicLenLabel">0 / 6</span>
                            </div>
                            <div class="text-[11px] font-semibold text-[#271e6d]/80 mt-1">
                                <i class="fa-solid fa-circle-info mr-1 text-indigo-500"></i>Reference: RUIHSS, YESMRL
                            </div>
                            <span class="text-red-500 text-xs mt-1 block" id="err-suic_code"></span>
                        </div>

                        {{-- ── Domain Section ─────────────────────────────────────── --}}
                        <div id="domainSection"
                            class="rounded-2xl border border-[#e2e1f0] bg-gradient-to-br from-[#f5f4fc] to-[#eef0fb] p-5 space-y-4 shadow-sm">
                            <!-- Header -->
                            <div class="flex items-center gap-2.5">
                                <div
                                    class="w-8 h-8 rounded-full bg-[#271e6d]/10 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-globe text-[#271e6d] text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-[#271e6d]">Do you have your own domain?</p>
                                    <p class="text-[11px] text-gray-400">A domain is your school's website address (e.g.
                                        myschool.edu.in)</p>
                                </div>
                            </div>

                            <!-- YES / NO toggle for has_own_domain -->
                            <div class="flex gap-3">
                                <button type="button" id="ownDomainYes" class="domain-toggle-btn domain-btn-inactive"
                                    onclick="setOwnDomain('yes')">
                                    <i class="fa-solid fa-check mr-1.5"></i>YES
                                </button>
                                <button type="button" id="ownDomainNo" class="domain-toggle-btn domain-btn-inactive"
                                    onclick="setOwnDomain('no')">
                                    <i class="fa-solid fa-xmark mr-1.5"></i>NO
                                </button>
                            </div>
                            <!-- Hidden fields for form submission -->
                            <input type="hidden" name="has_own_domain" id="hdnHasOwnDomain" value="">
                            <input type="hidden" name="wants_new_domain" id="hdnWantsNewDomain" value="">
                            <input type="hidden" name="existing_domain" id="hdnExistingDomain" value="">
                            <input type="hidden" name="desired_domain" id="hdnDesiredDomain" value="">

                            <!-- IF YES: Enter existing domain -->
                            <div id="existingDomainPanel" class="domain-panel">
                                <label class="block text-xs font-semibold text-[#271e6d] mb-1.5">
                                    Enter your school's domain URL
                                </label>
                                <div class="flex gap-2 items-start">
                                    <div class="flex-1">
                                        <input type="text" id="inp-existing_domain"
                                            placeholder="e.g. https://myschool.edu.in" class="form-pill-input"
                                            oninput="onExistingDomainInput(this)" onblur="checkDomainLive()">
                                        <span class="text-red-500 text-xs mt-1 block" id="err-existing_domain"></span>
                                    </div>
                                    <button type="button" id="btnCheckLive" onclick="checkDomainLive()"
                                        class="domain-check-btn flex-shrink-0">
                                        <i class="fa-solid fa-satellite-dish mr-1.5"></i>Validate
                                    </button>
                                </div>
                                <!-- Status badge -->
                                <div id="domainLiveStatus" class="domain-status-badge hidden"></div>
                            </div>

                            <!-- IF NO: Do you want a new domain? -->
                            <div id="wantNewDomainPanel" class="domain-panel">
                                <div class="flex items-center gap-2 mb-3">
                                    <i class="fa-solid fa-circle-question text-[#271e6d]/60 text-sm"></i>
                                    <p class="text-sm font-semibold text-[#271e6d]">Do you want a new domain?</p>
                                </div>
                                <div class="flex gap-3">
                                    <button type="button" id="wantDomainYes" class="domain-toggle-btn domain-btn-inactive"
                                        onclick="setWantDomain('yes')">
                                        <i class="fa-solid fa-check mr-1.5"></i>YES
                                    </button>
                                    <button type="button" id="wantDomainNo" class="domain-toggle-btn domain-btn-inactive"
                                        onclick="setWantDomain('no')">
                                        <i class="fa-solid fa-xmark mr-1.5"></i>NO
                                    </button>
                                </div>

                                <!-- IF want new YES: domain availability checker -->
                                <div id="desiredDomainPanel" class="domain-panel mt-4">
                                    <label class="block text-xs font-semibold text-[#271e6d] mb-1.5">
                                        Enter your desired domain name
                                    </label>
                                    <div class="flex gap-2 items-start">
                                        <div class="flex-1">
                                            <input type="text" id="inp-desired_domain" placeholder="e.g. myschool.edu.in"
                                                class="form-pill-input" oninput="onDesiredDomainInput(this)"
                                                onblur="checkDomainAvailability()">
                                            <span class="text-red-500 text-xs mt-1 block" id="err-desired_domain"></span>
                                        </div>
                                        <button type="button" id="btnCheckAvail" onclick="checkDomainAvailability()"
                                            class="domain-check-btn flex-shrink-0">
                                            <i class="fa-solid fa-magnifying-glass mr-1.5"></i>Check
                                        </button>
                                    </div>
                                    <!-- Availability badge -->
                                    <div id="domainAvailStatus" class="domain-status-badge hidden"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Save & Next Button -->
                        <div class="sm:text-right">
                            <button type="button" id="btnNextStep" class="btn-purple-action">
                                Save &amp; Next <i class="fa-solid fa-arrow-right ml-1.5 text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- ================= STEP 2: Staff, Students & Principal Data (HIDDEN INITIALLY) ================= -->
                    <div id="step-2" class="space-y-10 pt-4 hidden">

                        <!-- 1. Staff Count -->
                        <div class="space-y-5">
                            <div class="flex items-center gap-3">
                                <span class="dot-indicator-green dot-blink"></span>
                                <h3 class="text-base sm:text-lg font-semibold text-[#271e6d]">
                                    Staff Count
                                </h3>
                            </div>

                            <!-- Teaching Staff Row -->
                            <div class="staff-card rounded-2xl border border-[#e2e1f0] bg-[#f9f9fd] p-4 space-y-3">
                                <!-- Toggle Header -->
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold text-[#271e6d] flex items-center gap-2">
                                        Teaching Staff
                                    </span>
                                    <label class="staff-toggle" title="Toggle Teaching Staff">
                                        <input type="checkbox" id="toggleTeaching" checked>
                                        <span class="staff-toggle-slider"></span>
                                    </label>
                                </div>
                                <!-- Count Inputs -->
                                <div id="teachingInputs" class="grid grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-[#271e6d] mb-1">Male</label>
                                        <input type="number" name="teaching_male_staff" id="inp-teaching_male" min="0"
                                            value="0" required class="form-pill-input text-center">
                                        <span class="text-red-500 text-xs mt-1 block" id="err-teaching_male_staff"></span>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-[#271e6d] mb-1">Female</label>
                                        <input type="number" name="teaching_female_staff" id="inp-teaching_female" min="0"
                                            value="0" required class="form-pill-input text-center">
                                        <span class="text-red-500 text-xs mt-1 block" id="err-teaching_female_staff"></span>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-[#271e6d] mb-1">Sub-Total</label>
                                        <input type="number" id="teachingStaffTotal" readonly value="0"
                                            class="form-pill-input text-center bg-emerald-50 font-bold text-emerald-700">
                                    </div>
                                </div>
                            </div>

                            <!-- Non-Teaching Staff Row -->
                            <div class="staff-card rounded-2xl border border-[#e2e1f0] bg-[#f9f9fd] p-4 space-y-3">
                                <!-- Toggle Header -->
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold text-[#271e6d] flex items-center gap-2">
                                        Non-Teaching Staff
                                    </span>
                                    <label class="staff-toggle" title="Toggle Non-Teaching Staff">
                                        <input type="checkbox" id="toggleNonTeaching" checked>
                                        <span class="staff-toggle-slider"></span>
                                    </label>
                                </div>
                                <!-- Count Inputs -->
                                <div id="nonTeachingInputs" class="grid grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-[#271e6d] mb-1">Male</label>
                                        <input type="number" name="non_teaching_male_staff" id="inp-nonteaching_male"
                                            min="0" value="0" required class="form-pill-input text-center">
                                        <span class="text-red-500 text-xs mt-1 block"
                                            id="err-non_teaching_male_staff"></span>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-[#271e6d] mb-1">Female</label>
                                        <input type="number" name="non_teaching_female_staff" id="inp-nonteaching_female"
                                            min="0" value="0" required class="form-pill-input text-center">
                                        <span class="text-red-500 text-xs mt-1 block"
                                            id="err-non_teaching_female_staff"></span>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-[#271e6d] mb-1">Sub-Total</label>
                                        <input type="number" id="nonTeachingStaffTotal" readonly value="0"
                                            class="form-pill-input text-center bg-emerald-50 font-bold text-emerald-700">
                                    </div>
                                </div>
                            </div>

                            <!-- Grand Total Staff -->
                            <div class="flex items-center justify-end gap-4">
                                <span class="text-sm font-bold text-[#271e6d]">Grand Total (All Staff)</span>
                                <input type="number" id="totalStaffDisplay" readonly value="0"
                                    class="form-pill-input text-center bg-[#271e6d] text-white font-black text-base w-28 rounded-xl">
                            </div>
                        </div>

                        <!-- 2. Students Count -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <span class="dot-indicator-green dot-blink"></span>
                                <h3 class="text-base sm:text-lg font-semibold text-[#271e6d]">
                                    Students Count
                                </h3>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-2xl">
                                <div>
                                    <label class="block text-xs font-semibold text-[#271e6d] mb-1">Male Students</label>
                                    <input type="number" name="male_students" min="0" value="0" required
                                        class="form-pill-input text-center">
                                    <span class="text-red-500 text-xs mt-1 block" id="err-male_students"></span>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-[#271e6d] mb-1">Female Students</label>
                                    <input type="number" name="female_students" min="0" value="0" required
                                        class="form-pill-input text-center">
                                    <span class="text-red-500 text-xs mt-1 block" id="err-female_students"></span>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-[#271e6d] mb-1">Total Students</label>
                                    <input type="number" id="totalStudentsDisplay" readonly value="0"
                                        class="form-pill-input text-center bg-indigo-50/50 font-bold">
                                </div>
                            </div>
                        </div>

                        <!-- 3. Principal's Data & Buttons -->
                        <div class="space-y-6">
                            <div class="flex items-center gap-3">
                                <span class="dot-indicator-green dot-blink"></span>
                                <h3 class="text-base sm:text-lg font-semibold text-[#271e6d]">
                                    Principal's Data
                                </h3>
                            </div>

                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-[#271e6d] mb-1.5">
                                    Name of Principal
                                </label>
                                <input type="text" name="principal_name" id="inp-principal_name" required placeholder=""
                                    class="form-pill-input input-uppercase" oninput="this.value=this.value.toUpperCase()">
                                <span class="text-red-500 text-xs mt-1 block" id="err-principal_name"></span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs sm:text-sm font-semibold text-[#271e6d] mb-1.5">
                                        Contact Number
                                    </label>
                                    <input type="tel" id="principalContact" name="principal_phone"
                                        placeholder="e.g. +91 9876543210" class="form-pill-input"
                                        oninput="validateIndianPhone(this)">
                                    <span class="text-[10px] text-gray-400 mt-1 block">
                                        <i class="fa-solid fa-circle-info mr-1 text-indigo-400"></i>Valid Indian mobile
                                        number
                                        only
                                    </span>
                                    <span class="text-red-500 text-xs mt-1 block" id="err-principalContact"></span>
                                </div>

                                <div>
                                    <label class="block text-xs sm:text-sm font-semibold text-[#271e6d] mb-1.5">
                                        Email ID
                                    </label>
                                    <input type="email" id="principalEmail" name="principal_email"
                                        placeholder="principal@school.edu" class="form-pill-input"
                                        oninput="validateEmail(this)" onblur="validateEmailBlur(this)">
                                    <span class="text-[10px] text-gray-400 mt-1 block">
                                        <i class="fa-solid fa-circle-info mr-1 text-indigo-400"></i>Enter a valid email
                                        address
                                    </span>
                                    <span class="text-red-500 text-xs mt-1 block" id="err-principalEmail"></span>
                                </div>
                            </div>

                            <!-- Action Buttons (Back & Submit) -->
                            <div class="flex items-center justify-between pt-4">
                                <button type="button" id="btnPrevStep"
                                    class="px-6 py-3 rounded-xl bg-gray-100 text-gray-700 font-semibold text-sm hover:bg-gray-200 transition-colors inline-flex items-center gap-2">
                                    <i class="fa-solid fa-arrow-left text-xs"></i> Back
                                </button>

                                <button type="submit" id="submitBtn" class="btn-purple-action text-lg px-12 py-3.5">
                                    Submit
                                </button>
                            </div>
                        </div>

                    </div>
                </form>

            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <style>
        /* Force visual uppercase while typing */
        .input-uppercase {
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }

        /* SUIC counter dots */
        .suic-dot.filled {
            background-color: #10b981;
        }

        .suic-dot.full {
            background-color: #271e6d;
        }

        /* ── Staff Toggle Switch ─────────────────────────────────────────────── */
        .staff-toggle {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .staff-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
            position: absolute;
        }

        .staff-toggle-slider {
            position: absolute;
            inset: 0;
            background-color: #d1d5db;
            border-radius: 9999px;
            transition: background-color 0.25s ease;
        }

        .staff-toggle-slider::before {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            left: 3px;
            top: 3px;
            background: #fff;
            border-radius: 50%;
            transition: transform 0.25s ease;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
        }

        .staff-toggle input:checked+.staff-toggle-slider {
            background-color: #271e6d;
        }

        .staff-toggle input:checked+.staff-toggle-slider::before {
            transform: translateX(20px);
        }

        /* ── Blinking status dot ─────────────────────────────────────────────── */
        @keyframes dotBlink {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.3;
                transform: scale(0.75);
            }
        }

        .dot-blink {
            animation: dotBlink 1.2s ease-in-out infinite;
        }

        /* ── Success overlay bounce animation ────────────────────────────────── */
        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.80);
            }

            60% {
                opacity: 1;
                transform: scale(1.04);
            }

            100% {
                transform: scale(1);
            }
        }

        .animate-bounce-in {
            animation: bounceIn 0.45s cubic-bezier(.22, .68, 0, 1.2) both;
        }

        /* ── Invalid field highlight ─────────────────────────────────────────── */
        .field-invalid {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.12) !important;
        }

        .field-valid {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.12) !important;
        }

        /* ── Domain Section ──────────────────────────────────────────────────── */
        .domain-toggle-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.45rem 1.1rem;
            border-radius: 9999px;
            font-size: 0.78rem;
            font-weight: 700;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all 0.2s ease;
            letter-spacing: 0.03em;
        }

        .domain-btn-inactive {
            background: #fff;
            border-color: #d1d5db;
            color: #6b7280;
        }

        .domain-btn-inactive:hover {
            border-color: #271e6d;
            color: #271e6d;
            background: #f5f4fc;
        }

        .domain-btn-yes-active {
            background: #271e6d;
            border-color: #271e6d;
            color: #fff;
            box-shadow: 0 2px 10px rgba(39, 30, 109, 0.22);
        }

        .domain-btn-no-active {
            background: #6b7280;
            border-color: #6b7280;
            color: #fff;
        }

        .domain-panel {
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transition: max-height 0.35s cubic-bezier(.4, 0, .2, 1), opacity 0.3s ease;
        }

        .domain-panel.open {
            max-height: 400px;
            opacity: 1;
        }

        .domain-check-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.55rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.78rem;
            font-weight: 700;
            background: #271e6d;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s;
            white-space: nowrap;
            margin-top: 0;
        }

        .domain-check-btn:hover {
            opacity: 0.88;
        }

        .domain-check-btn:disabled {
            opacity: 0.55;
            cursor: not-allowed;
        }

        .domain-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            margin-top: 0.5rem;
            padding: 0.35rem 0.85rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .domain-status-live {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .domain-status-dead {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .domain-status-available {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .domain-status-taken {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .domain-status-checking {
            background: #ede9fe;
            color: #4c1d95;
            border: 1px solid #c4b5fd;
        }
    </style>
    <script>
        /* ════════════════════════════════════════════════════════════════════════
           AUTO SCROLL TO TOP ON PAGE LOAD
        ════════════════════════════════════════════════════════════════════════ */
        window.addEventListener('load', function () {
            window.scrollTo({ top: 0, behavior: 'instant' });
        });
        // Also scroll immediately (before full load)
        if (history.scrollRestoration) {
            history.scrollRestoration = 'manual';
        }
        window.scrollTo(0, 0);

        /* ════════════════════════════════════════════════════════════════════════
           PHONE VALIDATION – Valid Indian mobile only
           Rules: 10 digits, starts with 6/7/8/9 (with optional +91 / 0 prefix)
        ════════════════════════════════════════════════════════════════════════ */
        function normalisePhone(raw) {
            // Strip spaces, dashes, parentheses
            let v = raw.replace(/[\s\-()]/g, '');
            // Remove country code prefix +91 or 0091 or leading 0
            v = v.replace(/^\+91/, '').replace(/^0091/, '').replace(/^0/, '');
            return v;
        }

        function isValidIndianMobile(raw) {
            const digits = normalisePhone(raw);
            return /^[6-9]\d{9}$/.test(digits);
        }

        function validateIndianPhone(input) {
            // Only allow digits, +, spaces, dashes
            input.value = input.value.replace(/[^0-9+\s\-()]/g, '');
            const errId = input.id === 'principalContact' ? 'err-principalContact' : 'err-phone';
            const errEl = document.getElementById(errId);
            if (!input.value.trim()) {
                input.classList.remove('field-invalid', 'field-valid');
                if (errEl) errEl.textContent = '';
                return;
            }
            if (isValidIndianMobile(input.value)) {
                input.classList.remove('field-invalid');
                input.classList.add('field-valid');
                input.setCustomValidity('');
                if (errEl) errEl.textContent = '';
            } else {
                input.classList.add('field-invalid');
                input.classList.remove('field-valid');
                input.setCustomValidity('Enter a valid Indian mobile number (10 digits, starts with 6-9).');
                if (errEl) errEl.textContent = 'Enter a valid Indian mobile number (10 digits, starts with 6–9).';
            }
        }

        /* ════════════════════════════════════════════════════════════════════════
           EMAIL VALIDATION
        ════════════════════════════════════════════════════════════════════════ */
        function isValidEmail(val) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(val.trim());
        }

        function validateEmail(input) {
            // Allow only email-safe characters while typing
            input.value = input.value.replace(/[^a-zA-Z0-9@._+\-]/g, '');
        }

        function validateEmailBlur(input) {
            const errId = input.id === 'principalEmail' ? 'err-principalEmail' : 'err-email';
            const errEl = document.getElementById(errId);
            if (!input.value.trim()) {
                input.classList.remove('field-invalid', 'field-valid');
                if (errEl) errEl.textContent = '';
                return;
            }
            if (isValidEmail(input.value)) {
                input.classList.remove('field-invalid');
                input.classList.add('field-valid');
                input.setCustomValidity('');
                if (errEl) errEl.textContent = '';
            } else {
                input.classList.add('field-invalid');
                input.classList.remove('field-valid');
                input.setCustomValidity('Enter a valid email address.');
                if (errEl) errEl.textContent = 'Enter a valid email address (e.g. name@domain.com).';
            }
        }

        /* ════════════════════════════════════════════════════════════════════════
           SUCCESS OVERLAY – show 4 s then redirect home
        ════════════════════════════════════════════════════════════════════════ */
        function showSuccessAndRedirect(message, code) {
            const overlay = document.getElementById('successOverlay');
            const msgEl = document.getElementById('successMsg');
            const codeEl = document.getElementById('successCode');
            const bar = document.getElementById('redirectBar');

            if (msgEl) msgEl.textContent = message;
            if (code && codeEl) {
                codeEl.textContent = 'SUIC Code: ' + code;
                codeEl.classList.remove('hidden');
            }

            // Show overlay (scroll to top first)
            window.scrollTo({ top: 0, behavior: 'smooth' });
            overlay.classList.remove('hidden');

            // Animated progress bar drains over 4 000 ms
            const duration = 4000;
            const start = performance.now();

            function animateBar(now) {
                const elapsed = now - start;
                const pct = Math.max(0, 100 - (elapsed / duration) * 100);
                bar.style.width = pct + '%';
                if (elapsed < duration) {
                    requestAnimationFrame(animateBar);
                } else {
                    window.location.href = '{{ route('home') }}';
                }
            }
            requestAnimationFrame(animateBar);
        }

        /* ── SUIC 6-dot character counter & AJAX check ─────────────────────── */
        function updateSuicCounter(len) {
            const dots = document.querySelectorAll('#suicCounter .suic-dot');
            const label = document.getElementById('suicLenLabel');
            const errSpan = document.getElementById('err-suic_code');
            const input = document.getElementById('inp-suic_code');

            dots.forEach((d, i) => {
                d.classList.remove('filled', 'full');
                if (i < len) {
                    d.classList.add(len === 6 ? 'full' : 'filled');
                }
            });
            if (label) label.textContent = `${len} / 6`;
            if (errSpan) {
                errSpan.className = 'text-red-500 text-xs mt-1 block';
                errSpan.textContent = '';
            }

            if (len === 6 && input) {
                const val = input.value;
                fetch(`{{ route('public.check-suic') }}?code=${val}`, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(res => res.json())
                    .then(data => {
                        if (!data.available) {
                            if (errSpan) {
                                errSpan.className = 'text-red-500 text-xs mt-1 block font-semibold';
                                errSpan.textContent = data.message;
                            }
                            input.setCustomValidity(data.message);
                        } else {
                            if (errSpan) {
                                errSpan.className = 'text-emerald-600 text-xs mt-1 block font-semibold';
                                errSpan.textContent = data.message;
                            }
                            input.setCustomValidity('');
                        }
                    })
                    .catch(() => { });
            } else if (input) {
                input.setCustomValidity('');
            }
        }

        /* initialise on page load */
        document.addEventListener('DOMContentLoaded', function () {
            // Scroll to very top on page load
            window.scrollTo({ top: 0, behavior: 'instant' });

            updateSuicCounter(0);

            const stateSelect = document.getElementById('stateSelect');
            const zoneSelect = document.getElementById('zoneSelect');
            const zoneLoading = document.getElementById('zoneLoading');

            stateSelect.addEventListener('change', function () {
                const stateId = this.value;
                zoneSelect.innerHTML = '<option value="">Select Your Zone</option>';
                zoneSelect.disabled = true;
                zoneSelect.classList.add('opacity-70');
                zoneLoading.classList.add('hidden');

                if (!stateId) return;

                zoneLoading.classList.remove('hidden');

                fetch(`{{ route('public.zones') }}?state_id=${stateId}`, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(res => res.json())
                    .then(zones => {
                        zoneLoading.classList.add('hidden');
                        zoneSelect.innerHTML = '<option value="">Select Your Zone</option>';
                        if (!Array.isArray(zones) || zones.length === 0) {
                            zoneSelect.innerHTML = '<option value="">No zones available</option>';
                            return;
                        }
                        zones.forEach(z => {
                            const o = document.createElement('option');
                            o.value = z.id;
                            o.textContent = z.name;
                            zoneSelect.appendChild(o);
                        });
                        zoneSelect.disabled = false;
                        zoneSelect.classList.remove('opacity-70');
                    })
                    .catch(err => {
                        zoneLoading.classList.add('hidden');
                        zoneSelect.innerHTML = '<option value="">Error loading zones</option>';
                    });
            });

            const teachMale = document.getElementById('inp-teaching_male');
            const teachFemale = document.getElementById('inp-teaching_female');
            const ntMale = document.getElementById('inp-nonteaching_male');
            const ntFemale = document.getElementById('inp-nonteaching_female');
            const teachTotal = document.getElementById('teachingStaffTotal');
            const ntTotal = document.getElementById('nonTeachingStaffTotal');
            const totalStaff = document.getElementById('totalStaffDisplay');

            const maleStud = document.querySelector('input[name="male_students"]');
            const femaleStud = document.querySelector('input[name="female_students"]');
            const totalStud = document.getElementById('totalStudentsDisplay');

            // Toggle switches
            const toggleTeaching = document.getElementById('toggleTeaching');
            const toggleNonTeaching = document.getElementById('toggleNonTeaching');
            const teachingInputs = document.getElementById('teachingInputs');
            const nonTeachingInputs = document.getElementById('nonTeachingInputs');

            function n(el) { return parseInt(el?.value || 0, 10) || 0; }

            function updateCalculations() {
                const teachOn = toggleTeaching?.checked;
                const ntOn = toggleNonTeaching?.checked;

                const tMale = teachOn ? n(teachMale) : 0;
                const tFemale = teachOn ? n(teachFemale) : 0;
                const nMale = ntOn ? n(ntMale) : 0;
                const nFemale = ntOn ? n(ntFemale) : 0;

                const teachSum = tMale + tFemale;
                const ntSum = nMale + nFemale;
                const grandTotal = teachSum + ntSum;

                if (teachTotal) teachTotal.value = teachSum;
                if (ntTotal) ntTotal.value = ntSum;
                if (totalStaff) totalStaff.value = grandTotal;

                const mStud = n(maleStud);
                const fStud = n(femaleStud);
                if (totalStud) totalStud.value = mStud + fStud;
            }

            // Wire toggle switches
            toggleTeaching?.addEventListener('change', function () {
                if (this.checked) {
                    teachingInputs.classList.remove('opacity-40', 'pointer-events-none');
                } else {
                    teachingInputs.classList.add('opacity-40', 'pointer-events-none');
                }
                updateCalculations();
            });

            toggleNonTeaching?.addEventListener('change', function () {
                if (this.checked) {
                    nonTeachingInputs.classList.remove('opacity-40', 'pointer-events-none');
                } else {
                    nonTeachingInputs.classList.add('opacity-40', 'pointer-events-none');
                }
                updateCalculations();
            });

            [teachMale, teachFemale, ntMale, ntFemale, maleStud, femaleStud].forEach(el => {
                el?.addEventListener('input', updateCalculations);
            });

            // ── Multi-Step Form Navigation (Save & Next / Back) ──────────────────────
            const step1 = document.getElementById('step-1');
            const step2 = document.getElementById('step-2');
            const btnNextStep = document.getElementById('btnNextStep');
            const btnPrevStep = document.getElementById('btnPrevStep');
            const badgeStep1 = document.getElementById('badgeStep1');
            const badgeStep2 = document.getElementById('badgeStep2');

            function showStep(stepNum) {
                if (stepNum === 2) {
                    step1.classList.add('hidden');
                    step2.classList.remove('hidden');
                    badgeStep1.className = 'px-4 py-2 rounded-full bg-gray-100 text-gray-400 flex items-center gap-2';
                    badgeStep1.querySelector('span').className = 'w-5 h-5 rounded-full bg-gray-200 text-gray-600 text-xs flex items-center justify-center font-bold';
                    badgeStep2.className = 'px-4 py-2 rounded-full bg-[#271e6d] text-white shadow-sm flex items-center gap-2';
                    badgeStep2.querySelector('span').className = 'w-5 h-5 rounded-full bg-white text-[#271e6d] text-xs flex items-center justify-center font-bold';
                } else {
                    step2.classList.add('hidden');
                    step1.classList.remove('hidden');
                    badgeStep2.className = 'px-4 py-2 rounded-full bg-gray-100 text-gray-400 flex items-center gap-2';
                    badgeStep2.querySelector('span').className = 'w-5 h-5 rounded-full bg-gray-200 text-gray-600 text-xs flex items-center justify-center font-bold';
                    badgeStep1.className = 'px-4 py-2 rounded-full bg-[#271e6d] text-white shadow-sm flex items-center gap-2';
                    badgeStep1.querySelector('span').className = 'w-5 h-5 rounded-full bg-white text-[#271e6d] text-xs flex items-center justify-center font-bold';
                }
                // Scroll to top of page on step change
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            btnNextStep?.addEventListener('click', function () {
                // Validate phone & email before going to step 2
                const phoneInput = document.getElementById('inp-phone');
                const emailInput = document.getElementById('inp-email');
                let valid = true;

                // Check required Step 1 inputs
                const step1Inputs = step1.querySelectorAll('input[required], select[required], textarea[required]');
                step1Inputs.forEach(i => {
                    if (!i.value.trim()) {
                        i.reportValidity();
                        valid = false;
                    }
                });

                // Extra phone validation
                if (phoneInput && phoneInput.value.trim() && !isValidIndianMobile(phoneInput.value)) {
                    document.getElementById('err-phone').textContent = 'Enter a valid Indian mobile number (10 digits, starts with 6–9).';
                    phoneInput.classList.add('field-invalid');
                    valid = false;
                }

                // Extra email validation
                if (emailInput && emailInput.value.trim() && !isValidEmail(emailInput.value)) {
                    document.getElementById('err-email').textContent = 'Enter a valid email address (e.g. name@domain.com).';
                    emailInput.classList.add('field-invalid');
                    valid = false;
                }

                // Domain validation gate
                const ownDomain = document.getElementById('hdnHasOwnDomain').value;
                const wantDomain = document.getElementById('hdnWantsNewDomain').value;
                if (ownDomain === 'yes' && !window._domainLiveValidated) {
                    document.getElementById('err-existing_domain').textContent =
                        'Please validate your domain URL before proceeding.';
                    document.getElementById('inp-existing_domain')?.classList.add('field-invalid');
                    valid = false;
                }
                if (ownDomain === 'no' && wantDomain === 'yes' && !window._domainAvailValidated) {
                    document.getElementById('err-desired_domain').textContent =
                        'Please check domain availability before proceeding.';
                    document.getElementById('inp-desired_domain')?.classList.add('field-invalid');
                    valid = false;
                }

                if (valid) {
                    showStep(2);
                }
            });

            btnPrevStep?.addEventListener('click', function () {
                showStep(1);
            });

            // ── Form Submit ────────────────────────────────────────────────────────────
            const form = document.getElementById('registrationForm');
            const submitBtn = document.getElementById('submitBtn');
            const alertBox = document.getElementById('alertBox');

            function showAlert(type, html) {
                alertBox.className = type === 'success'
                    ? 'mb-8 p-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm shadow-md'
                    : 'mb-8 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm';
                alertBox.innerHTML = html;
                alertBox.classList.remove('hidden');
                alertBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                document.querySelectorAll('[id^="err-"]').forEach(el => el.textContent = '');
                alertBox.classList.add('hidden');

                // Validate principal phone & email if filled
                const pPhone = document.getElementById('principalContact');
                const pEmail = document.getElementById('principalEmail');
                let preValid = true;

                if (pPhone && pPhone.value.trim() && !isValidIndianMobile(pPhone.value)) {
                    document.getElementById('err-principalContact').textContent = 'Enter a valid Indian mobile number.';
                    pPhone.classList.add('field-invalid');
                    preValid = false;
                }
                if (pEmail && pEmail.value.trim() && !isValidEmail(pEmail.value)) {
                    document.getElementById('err-principalEmail').textContent = 'Enter a valid email address.';
                    pEmail.classList.add('field-invalid');
                    preValid = false;
                }
                if (!preValid) return;

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Submitting...';

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: new FormData(form),
                })
                    .then(async res => {
                        const text = await res.text();
                        let data;
                        try {
                            data = JSON.parse(text);
                        } catch (_) {
                            if (res.status === 429) {
                                throw new Error('Too many requests. Please wait a moment and try submitting again.');
                            } else if (res.status === 419) {
                                throw new Error('Session expired. Please refresh the page and try submitting again.');
                            } else {
                                throw new Error(`Server response error (${res.status}). Please verify your input and try again.`);
                            }
                        }

                        if (!res.ok) {
                            if (res.status === 422 && data.errors) {
                                let hasStep1Error = false;
                                const step1Keys = ['state_id', 'zone_id', 'category_id', 'name', 'phone', 'email', 'address', 'suic_code', 'has_own_domain', 'wants_new_domain', 'existing_domain', 'desired_domain'];
                                Object.entries(data.errors).forEach(([key, msgs]) => {
                                    const el = document.getElementById(`err-${key}`);
                                    if (el) el.textContent = msgs[0];
                                    if (step1Keys.includes(key)) {
                                        hasStep1Error = true;
                                    }
                                });
                                if (hasStep1Error) {
                                    showStep(1);
                                }
                                throw new Error('Please fill in all required fields accurately.');
                            }
                            throw new Error(data.message || `Server error (${res.status}).`);
                        }
                        return data;
                    })
                    .then(data => {
                        // ── Success: show overlay → 4 s → home ──────────────────
                        form.reset();
                        updateCalculations();
                        zoneSelect.innerHTML = '<option value="">Select Your Zone</option>';
                        zoneSelect.disabled = true;
                        zoneSelect.classList.add('opacity-70');
                        // Reset domain section
                        resetDomainSection();
                        showStep(1);

                        showSuccessAndRedirect(
                            data.message || 'Your campus registration has been submitted successfully!',
                            data.code || null
                        );
                    })
                    .catch(err => {
                        if (!err.message.includes('required fields')) {
                            showAlert('error', `<i class="fa-solid fa-circle-exclamation mr-2"></i>${err.message}`);
                        }
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Submit';
                    });
            });
        });

        /* ════════════════════════════════════════════════════════════════════════
           DOMAIN SECTION LOGIC
        ════════════════════════════════════════════════════════════════════════ */

        // State flags
        window._domainLiveValidated = false;
        window._domainAvailValidated = false;
        let _domainLiveDebounce = null;
        let _domainAvailDebounce = null;

        function resetDomainSection() {
            // Reset all hidden fields
            document.getElementById('hdnHasOwnDomain').value = '';
            document.getElementById('hdnWantsNewDomain').value = '';
            document.getElementById('hdnExistingDomain').value = '';
            document.getElementById('hdnDesiredDomain').value = '';
            // Reset flags
            window._domainLiveValidated = false;
            window._domainAvailValidated = false;
            // Reset buttons
            ['ownDomainYes', 'ownDomainNo', 'wantDomainYes', 'wantDomainNo'].forEach(id => {
                const btn = document.getElementById(id);
                if (btn) btn.className = 'domain-toggle-btn domain-btn-inactive';
            });
            // Close all panels
            ['existingDomainPanel', 'wantNewDomainPanel', 'desiredDomainPanel'].forEach(id => {
                document.getElementById(id)?.classList.remove('open');
            });
            // Clear inputs & badges
            const inpE = document.getElementById('inp-existing_domain');
            const inpD = document.getElementById('inp-desired_domain');
            if (inpE) { inpE.value = ''; inpE.className = 'form-pill-input'; }
            if (inpD) { inpD.value = ''; inpD.className = 'form-pill-input'; }
            ['domainLiveStatus', 'domainAvailStatus'].forEach(id => {
                const el = document.getElementById(id);
                if (el) { el.className = 'domain-status-badge hidden'; el.innerHTML = ''; }
            });
            ['err-existing_domain', 'err-desired_domain'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.textContent = '';
            });
        }

        function setOwnDomain(choice) {
            document.getElementById('hdnHasOwnDomain').value = choice;
            document.getElementById('hdnWantsNewDomain').value = '';
            window._domainLiveValidated = false;
            window._domainAvailValidated = false;

            const yesBtn = document.getElementById('ownDomainYes');
            const noBtn = document.getElementById('ownDomainNo');

            if (choice === 'yes') {
                yesBtn.className = 'domain-toggle-btn domain-btn-yes-active';
                noBtn.className = 'domain-toggle-btn domain-btn-inactive';
                document.getElementById('existingDomainPanel').classList.add('open');
                document.getElementById('wantNewDomainPanel').classList.remove('open');
                document.getElementById('desiredDomainPanel').classList.remove('open');
                document.getElementById('hdnDesiredDomain').value = '';
                const inpD = document.getElementById('inp-desired_domain');
                if (inpD) inpD.value = '';
                setDomainAvailStatus('', '', false);
            } else {
                noBtn.className = 'domain-toggle-btn domain-btn-no-active';
                yesBtn.className = 'domain-toggle-btn domain-btn-inactive';
                document.getElementById('wantNewDomainPanel').classList.add('open');
                document.getElementById('existingDomainPanel').classList.remove('open');
                document.getElementById('hdnExistingDomain').value = '';
                const inpE = document.getElementById('inp-existing_domain');
                if (inpE) inpE.value = '';
                setDomainLiveStatus('', '', false);
                // Reset want domain buttons
                ['wantDomainYes', 'wantDomainNo'].forEach(id => {
                    const btn = document.getElementById(id);
                    if (btn) btn.className = 'domain-toggle-btn domain-btn-inactive';
                });
            }
        }

        function setWantDomain(choice) {
            document.getElementById('hdnWantsNewDomain').value = choice;
            window._domainAvailValidated = false;

            const yesBtn = document.getElementById('wantDomainYes');
            const noBtn = document.getElementById('wantDomainNo');

            if (choice === 'yes') {
                yesBtn.className = 'domain-toggle-btn domain-btn-yes-active';
                noBtn.className = 'domain-toggle-btn domain-btn-inactive';
                document.getElementById('desiredDomainPanel').classList.add('open');
            } else {
                noBtn.className = 'domain-toggle-btn domain-btn-no-active';
                yesBtn.className = 'domain-toggle-btn domain-btn-inactive';
                document.getElementById('desiredDomainPanel').classList.remove('open');
                document.getElementById('hdnDesiredDomain').value = '';
                const inpD = document.getElementById('inp-desired_domain');
                if (inpD) inpD.value = '';
                setDomainAvailStatus('', '', false);
            }
        }

        // ── Domain status helpers ────────────────────────────────────────────────
        function setDomainLiveStatus(message, type, show) {
            const badge = document.getElementById('domainLiveStatus');
            if (!badge) return;
            if (!show || !message) { badge.className = 'domain-status-badge hidden'; return; }
            badge.classList.remove('hidden');
            if (type === 'live') {
                badge.className = 'domain-status-badge domain-status-live';
                badge.innerHTML = `<i class="fa-solid fa-circle-check"></i> ${message}`;
            } else if (type === 'dead') {
                badge.className = 'domain-status-badge domain-status-dead';
                badge.innerHTML = `<i class="fa-solid fa-circle-xmark"></i> ${message}`;
            } else {
                badge.className = 'domain-status-badge domain-status-checking';
                badge.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> ${message}`;
            }
        }

        function setDomainAvailStatus(message, type, show) {
            const badge = document.getElementById('domainAvailStatus');
            if (!badge) return;
            if (!show || !message) { badge.className = 'domain-status-badge hidden'; return; }
            badge.classList.remove('hidden');
            if (type === 'available') {
                badge.className = 'domain-status-badge domain-status-available';
                badge.innerHTML = `<i class="fa-solid fa-circle-check"></i> ${message}`;
            } else if (type === 'taken') {
                badge.className = 'domain-status-badge domain-status-taken';
                badge.innerHTML = `<i class="fa-solid fa-circle-xmark"></i> ${message}`;
            } else {
                badge.className = 'domain-status-badge domain-status-checking';
                badge.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> ${message}`;
            }
        }

        // ── Check domain live ────────────────────────────────────────────────────
        function onExistingDomainInput(inp) {
            inp.value = inp.value.replace(/[^a-zA-Z0-9:/._\-?=&#%+]/g, '');
            window._domainLiveValidated = false;
            setDomainLiveStatus('', '', false);
            document.getElementById('err-existing_domain').textContent = '';
            inp.classList.remove('field-valid', 'field-invalid');
            clearTimeout(_domainLiveDebounce);
        }

        function checkDomainLive() {
            const inp = document.getElementById('inp-existing_domain');
            const btnEl = document.getElementById('btnCheckLive');
            const errEl = document.getElementById('err-existing_domain');
            if (!inp) return;

            let url = inp.value.trim();
            if (!url) return;

            // Auto-prefix https if missing
            if (!url.startsWith('http://') && !url.startsWith('https://')) {
                url = 'https://' + url;
                inp.value = url;
            }

            setDomainLiveStatus('Checking…', 'checking', true);
            if (btnEl) { btnEl.disabled = true; btnEl.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1.5"></i>Checking…'; }

            fetch(`{{ route('public.check-domain-live') }}?url=${encodeURIComponent(url)}`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(r => r.json())
                .then(data => {
                    if (data.live) {
                        window._domainLiveValidated = true;
                        document.getElementById('hdnExistingDomain').value = url;
                        inp.classList.add('field-valid');
                        inp.classList.remove('field-invalid');
                        setDomainLiveStatus(data.message, 'live', true);
                        if (errEl) errEl.textContent = '';
                    } else {
                        window._domainLiveValidated = false;
                        document.getElementById('hdnExistingDomain').value = '';
                        inp.classList.add('field-invalid');
                        inp.classList.remove('field-valid');
                        setDomainLiveStatus(data.message, 'dead', true);
                        if (errEl) errEl.textContent = data.message;
                    }
                })
                .catch(() => {
                    window._domainLiveValidated = false;
                    setDomainLiveStatus('Could not reach the server. Please try again.', 'dead', true);
                })
                .finally(() => {
                    if (btnEl) { btnEl.disabled = false; btnEl.innerHTML = '<i class="fa-solid fa-satellite-dish mr-1.5"></i>Validate'; }
                });
        }

        // ── Check domain availability ─────────────────────────────────────────────
        function onDesiredDomainInput(inp) {
            inp.value = inp.value.replace(/[^a-zA-Z0-9.\-]/g, '').toLowerCase();
            window._domainAvailValidated = false;
            setDomainAvailStatus('', '', false);
            document.getElementById('err-desired_domain').textContent = '';
            inp.classList.remove('field-valid', 'field-invalid');
            clearTimeout(_domainAvailDebounce);
        }

        function checkDomainAvailability() {
            const inp = document.getElementById('inp-desired_domain');
            const btnEl = document.getElementById('btnCheckAvail');
            const errEl = document.getElementById('err-desired_domain');
            if (!inp) return;

            const domain = inp.value.trim().toLowerCase();
            if (!domain) return;

            setDomainAvailStatus('Checking availability…', 'checking', true);
            if (btnEl) { btnEl.disabled = true; btnEl.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1.5"></i>Checking…'; }

            fetch(`{{ route('public.check-domain-availability') }}?domain=${encodeURIComponent(domain)}`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(r => r.json())
                .then(data => {
                    if (data.available) {
                        window._domainAvailValidated = true;
                        document.getElementById('hdnDesiredDomain').value = domain;
                        inp.classList.add('field-valid');
                        inp.classList.remove('field-invalid');
                        setDomainAvailStatus(data.message, 'available', true);
                        if (errEl) errEl.textContent = '';
                    } else {
                        window._domainAvailValidated = false;
                        document.getElementById('hdnDesiredDomain').value = '';
                        inp.classList.add('field-invalid');
                        inp.classList.remove('field-valid');
                        setDomainAvailStatus(data.message, 'taken', true);
                        if (errEl) errEl.textContent = data.message;
                    }
                })
                .catch(() => {
                    window._domainAvailValidated = false;
                    setDomainAvailStatus('Could not reach the server. Please try again.', 'taken', true);
                })
                .finally(() => {
                    if (btnEl) { btnEl.disabled = false; btnEl.innerHTML = '<i class="fa-solid fa-magnifying-glass mr-1.5"></i>Check'; }
                });
        }
    </script>
@endsection