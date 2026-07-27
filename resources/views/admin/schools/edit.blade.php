@extends('layouts.app')

@section('title', 'Edit ' . $school->name . ' - YES INDIA SCHOOLS ERP Admin')

@section('styles')
    <style>
        body {
            background-color: #ffffff !important;
            color: #0f172a !important;
            font-family: 'Figtree', 'Inter', sans-serif;
            font-weight: 400;
        }

        .admin-card-light {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }

        .form-label-custom {
            display: block;
            font-size: 0.725rem;
            font-weight: 700;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
        }

        .form-input-custom {
            width: 100%;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 0.875rem;
            color: #0f172a;
            font-weight: 400;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-input-custom:focus {
            background-color: #ffffff;
            border-color: #271e6d;
            box-shadow: 0 0 0 3px rgba(39, 30, 109, 0.1);
        }

        .form-input-custom.is-invalid {
            border-color: #ef4444 !important;
            background-color: #fef2f2 !important;
        }

        .form-select-custom {
            width: 100%;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 36px 10px 14px;
            font-size: 0.8125rem;
            color: #0f172a;
            font-weight: 400;
            outline: none;
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23271e6d'%3E%3Cpath d='M12 15l-5-5h10l-5 5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 18px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .form-select-custom:focus {
            background-color: #ffffff;
            border-color: #271e6d;
            box-shadow: 0 0 0 3px rgba(39, 30, 109, 0.1);
        }

        .form-select-custom.is-invalid {
            border-color: #ef4444 !important;
            background-color: #fef2f2 !important;
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

        .spinner-loader {
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 2px solid #ffffff;
            width: 16px;
            height: 16px;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
@endsection

@section('content')

    <!-- Sidebar Component -->
    <x-admin-sidebar active="schools" />

    <!-- Main Content Area -->
    <div class="lg:pl-64 min-h-screen flex flex-col justify-between bg-white"
         x-data="schoolEditForm()"
         x-init="initData()">

        <!-- Toast Alert Banner -->
        <div x-show="toast.show"
             x-cloak
             x-transition
             :class="toast.type === 'success' ? 'bg-emerald-600 border-emerald-700' : 'bg-red-600 border-red-700'"
             class="fixed top-5 right-5 z-50 flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-xl text-white font-semibold text-sm border max-w-md">
            <i class="fa-solid" :class="toast.type === 'success' ? 'fa-circle-check text-lg' : 'fa-triangle-exclamation text-lg'"></i>
            <div class="flex-1">
                <p x-text="toast.message" class="leading-snug"></p>
            </div>
            <button type="button" @click="toast.show = false" class="text-white/80 hover:text-white ml-2">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <!-- Page Content Container -->
        <div class="p-4 sm:p-6 lg:p-8 space-y-6 max-w-7xl w-full mx-auto font-sans font-normal">

            <!-- Back Navigation Bar -->
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.schools.index') }}"
                    class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white border border-[#e2e1f0] text-[#1f1659] hover:bg-[#f3f2fa] font-semibold text-xs transition-all shadow-sm">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Back to School Directory</span>
                </a>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.schools.show', $school->id) }}"
                        class="px-4 py-2 rounded-xl bg-white border border-[#e2e1f0] text-[#1f1659] hover:bg-[#f3f2fa] font-semibold text-xs transition-all shadow-sm inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-eye"></i> View Profile Details
                    </a>
                </div>
            </div>

            <!-- HERO PROFILE HEADER BANNER (EDIT MODE) -->
            <div class="bg-[#1f1659] rounded-2xl p-6 sm:p-8 text-white relative overflow-hidden shadow-sm font-sans font-normal">
                <div class="relative z-10 space-y-6">

                    <!-- Top Meta Tags -->
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-mono text-xs font-semibold bg-white/10 text-white px-3 py-1 rounded-xl border border-white/15">
                                SUIC: {{ $school->suic_code ?? $school->code }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider badge-{{ $school->status }}"
                                  x-text="statusLabel(formData.status)">
                                {{ str_replace('_', ' ', $school->status) }}
                            </span>
                            <span class="text-xs font-normal text-indigo-100 bg-white/10 px-3 py-1 rounded-xl border border-white/15">
                                {{ $school->category->name ?? 'School Category' }}
                            </span>
                        </div>

                        <div class="text-xs text-indigo-200/80 font-mono">
                            Edit Profile Mode
                        </div>
                    </div>

                    <!-- School Name & Location -->
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight" x-text="formData.name || '{{ addslashes($school->name) }}'">
                            {{ $school->name }}
                        </h1>
                        <p class="text-xs sm:text-sm text-indigo-200/90 font-normal flex items-center gap-2 mt-1">
                            <span><i class="fa-solid fa-pen-to-square text-[#3af0a4]"></i> Institutional Registration &amp; Accreditation Management</span>
                        </p>
                    </div>

                    <!-- KPI Metrics Summary Strip inside Hero -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-4 border-t border-white/10">
                        <!-- Total Students -->
                        <div class="bg-white/10 backdrop-blur p-3.5 rounded-xl border border-white/10">
                            <span class="text-[11px] text-indigo-200/80 block uppercase font-semibold tracking-wider">Total Students</span>
                            <span class="text-xl sm:text-2xl font-bold font-mono mt-0.5 block text-white"
                                  x-text="(parseInt(formData.male_students || 0) + parseInt(formData.female_students || 0)).toLocaleString()">
                                {{ number_format(($school->male_students ?? 0) + ($school->female_students ?? 0)) }}
                            </span>
                        </div>
                        <!-- Teaching Faculty -->
                        <div class="bg-white/10 backdrop-blur p-3.5 rounded-xl border border-white/10">
                            <span class="text-[11px] text-indigo-200/80 block uppercase font-semibold tracking-wider">Teaching Staff</span>
                            <span class="text-xl sm:text-2xl font-bold font-mono mt-0.5 block text-white"
                                  x-text="(parseInt(formData.teaching_male_staff || 0) + parseInt(formData.teaching_female_staff || 0)).toLocaleString()">
                                {{ number_format(($school->teaching_male_staff ?? 0) + ($school->teaching_female_staff ?? 0)) }}
                            </span>
                        </div>
                        <!-- Non-Teaching Staff -->
                        <div class="bg-white/10 backdrop-blur p-3.5 rounded-xl border border-white/10">
                            <span class="text-[11px] text-indigo-200/80 block uppercase font-semibold tracking-wider">Non-Teaching</span>
                            <span class="text-xl sm:text-2xl font-bold font-mono mt-0.5 block text-white"
                                  x-text="(parseInt(formData.non_teaching_male_staff || 0) + parseInt(formData.non_teaching_female_staff || 0)).toLocaleString()">
                                {{ number_format(($school->non_teaching_male_staff ?? 0) + ($school->non_teaching_female_staff ?? 0)) }}
                            </span>
                        </div>
                        <!-- Grand Total Staff -->
                        <div class="bg-white/10 backdrop-blur p-3.5 rounded-xl border border-white/10">
                            <span class="text-[11px] text-indigo-200/80 block uppercase font-semibold tracking-wider">Total Staff</span>
                            <span class="text-xl sm:text-2xl font-bold font-mono mt-0.5 block text-white"
                                  x-text="(parseInt(formData.teaching_male_staff || 0) + parseInt(formData.teaching_female_staff || 0) + parseInt(formData.non_teaching_male_staff || 0) + parseInt(formData.non_teaching_female_staff || 0)).toLocaleString()">
                                {{ number_format(($school->teaching_male_staff ?? 0) + ($school->teaching_female_staff ?? 0) + ($school->non_teaching_male_staff ?? 0) + ($school->non_teaching_female_staff ?? 0)) }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Main Edit Form -->
            <form id="schoolEditForm"
                  action="{{ route('admin.schools.update', $school->id) }}"
                  method="POST"
                  @submit.prevent="submitForm()"
                  class="space-y-6">
                @csrf
                @method('PUT')

                <!-- 1. Accreditation & Placement Card -->
                <div class="admin-card-light p-6 space-y-5">
                    <div class="pb-3 border-b border-[#e2e1f0]">
                        <h3 class="text-sm font-bold text-[#271e6d] uppercase tracking-wider">
                            Accreditation &amp; Location
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                        <!-- SUIC Code -->
                        <div>
                            <label for="suic_code" class="form-label-custom">
                                SUIC Code <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="suic_code"
                                   name="suic_code"
                                   x-model="formData.suic_code"
                                   @input="formData.suic_code = $event.target.value.toUpperCase().replace(/[^A-Z]/g, '').slice(0,6)"
                                   maxlength="6"
                                   required
                                   class="form-input-custom font-mono uppercase tracking-widest font-bold text-[#271e6d]"
                                   :class="errors.suic_code ? 'is-invalid' : ''"
                                   placeholder="XXXXXX">
                            <template x-if="errors.suic_code">
                                <p class="text-xs text-red-500 font-semibold mt-1" x-text="errors.suic_code[0]"></p>
                            </template>
                        </div>

                        <!-- Accreditation Status -->
                        <div>
                            <label for="status" class="form-label-custom">
                                ERP Status <span class="text-red-500">*</span>
                            </label>
                            <select id="status"
                                    name="status"
                                    x-model="formData.status"
                                    required
                                    class="form-select-custom font-semibold"
                                    :class="errors.status ? 'is-invalid' : ''">
                                <option value="registered">Registered</option>
                                <option value="under_construction">Under Construction</option>
                                <option value="trial_running">Trial Running</option>
                                <option value="on_going">On Going</option>
                            </select>
                            <template x-if="errors.status">
                                <p class="text-xs text-red-500 font-semibold mt-1" x-text="errors.status[0]"></p>
                            </template>
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="form-label-custom">
                                School Category <span class="text-red-500">*</span>
                            </label>
                            <select id="category_id"
                                    name="category_id"
                                    x-model="formData.category_id"
                                    required
                                    class="form-select-custom font-semibold"
                                    :class="errors.category_id ? 'is-invalid' : ''">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <template x-if="errors.category_id">
                                <p class="text-xs text-red-500 font-semibold mt-1" x-text="errors.category_id[0]"></p>
                            </template>
                        </div>

                        <!-- State Dropdown -->
                        <div>
                            <label for="state_id" class="form-label-custom">
                                State <span class="text-red-500">*</span>
                            </label>
                            <select id="state_id"
                                    name="state_id"
                                    x-model="formData.state_id"
                                    @change="onStateChange()"
                                    required
                                    class="form-select-custom font-semibold"
                                    :class="errors.state_id ? 'is-invalid' : ''">
                                <option value="">Select State</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                            <template x-if="errors.state_id">
                                <p class="text-xs text-red-500 font-semibold mt-1" x-text="errors.state_id[0]"></p>
                            </template>
                        </div>

                        <!-- Zone Dropdown -->
                        <div class="md:col-span-2">
                            <label for="zone_id" class="form-label-custom">
                                Zone / Region <span class="text-red-500">*</span>
                            </label>
                            <select id="zone_id"
                                    name="zone_id"
                                    x-model="formData.zone_id"
                                    :disabled="loadingZones || zones.length === 0"
                                    required
                                    class="form-select-custom font-semibold"
                                    :class="errors.zone_id ? 'is-invalid' : ''">
                                <option value="">Select Zone</option>
                                <template x-for="zone in zones" :key="zone.id">
                                    <option :value="zone.id"
                                            :selected="zone.id == formData.zone_id"
                                            x-text="zone.name + (zone.code ? ' (' + zone.code + ')' : '')">
                                    </option>
                                </template>
                            </select>
                            <template x-if="errors.zone_id">
                                <p class="text-xs text-red-500 font-semibold mt-1" x-text="errors.zone_id[0]"></p>
                            </template>
                        </div>

                    </div>
                </div>

                <!-- 2. School & Contact Details Card -->
                <div class="admin-card-light p-6 space-y-5">
                    <div class="pb-3 border-b border-[#e2e1f0]">
                        <h3 class="text-sm font-bold text-[#271e6d] uppercase tracking-wider">
                            Campus Identity &amp; Contact Details
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <!-- School Name -->
                        <div class="md:col-span-2">
                            <label for="name" class="form-label-custom">
                                Full Institution Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   x-model="formData.name"
                                   required
                                   class="form-input-custom font-bold text-[#271e6d] text-base"
                                   :class="errors.name ? 'is-invalid' : ''"
                                   placeholder="e.g. YES INDIA ACADEMY HIGH SCHOOL">
                            <template x-if="errors.name">
                                <p class="text-xs text-red-500 font-semibold mt-1" x-text="errors.name[0]"></p>
                            </template>
                        </div>

                        <!-- Principal Name -->
                        <div>
                            <label for="principal_name" class="form-label-custom">
                                Principal / Head of School <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="principal_name"
                                   name="principal_name"
                                   x-model="formData.principal_name"
                                   required
                                   class="form-input-custom font-semibold"
                                   :class="errors.principal_name ? 'is-invalid' : ''"
                                   placeholder="e.g. DR. JOHN DOE">
                            <template x-if="errors.principal_name">
                                <p class="text-xs text-red-500 font-semibold mt-1" x-text="errors.principal_name[0]"></p>
                            </template>
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="phone" class="form-label-custom">
                                Official Contact Phone <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="phone"
                                   name="phone"
                                   x-model="formData.phone"
                                   required
                                   class="form-input-custom font-mono font-semibold"
                                   :class="errors.phone ? 'is-invalid' : ''"
                                   placeholder="+91 98765 43210">
                            <template x-if="errors.phone">
                                <p class="text-xs text-red-500 font-semibold mt-1" x-text="errors.phone[0]"></p>
                            </template>
                        </div>

                        <!-- Email Address -->
                        <div class="md:col-span-2">
                            <label for="email" class="form-label-custom">
                                Official Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   x-model="formData.email"
                                   required
                                   class="form-input-custom font-mono font-semibold"
                                   :class="errors.email ? 'is-invalid' : ''"
                                   placeholder="principal@school.edu.in">
                            <template x-if="errors.email">
                                <p class="text-xs text-red-500 font-semibold mt-1" x-text="errors.email[0]"></p>
                            </template>
                        </div>

                        <!-- Postal Address -->
                        <div class="md:col-span-2">
                            <label for="address" class="form-label-custom">
                                Full Postal Address <span class="text-red-500">*</span>
                            </label>
                            <textarea id="address"
                                      name="address"
                                      x-model="formData.address"
                                      rows="3"
                                      required
                                      class="form-input-custom font-medium uppercase text-xs"
                                      :class="errors.address ? 'is-invalid' : ''"
                                      placeholder="ENTER COMPLETE CAMPUS POSTAL ADDRESS..."></textarea>
                            <template x-if="errors.address">
                                <p class="text-xs text-red-500 font-semibold mt-1" x-text="errors.address[0]"></p>
                            </template>
                        </div>

                    </div>
                </div>

                <!-- 3. Web & Domain Settings -->
                <div class="admin-card-light p-6 space-y-5">
                    <div class="pb-3 border-b border-[#e2e1f0]">
                        <h3 class="text-sm font-bold text-[#271e6d] uppercase tracking-wider">
                            Web &amp; Domain Configurations
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <!-- Existing Domain -->
                        <div>
                            <label for="existing_domain" class="form-label-custom">
                                Existing Website Domain <span class="text-xs text-slate-400 font-normal">(Optional)</span>
                            </label>
                            <input type="text"
                                   id="existing_domain"
                                   name="existing_domain"
                                   x-model="formData.existing_domain"
                                   class="form-input-custom font-mono text-xs"
                                   :class="errors.existing_domain ? 'is-invalid' : ''"
                                   placeholder="https://myschool.edu.in">
                            <template x-if="errors.existing_domain">
                                <p class="text-xs text-red-500 font-semibold mt-1" x-text="errors.existing_domain[0]"></p>
                            </template>
                        </div>

                        <!-- Desired Domain -->
                        <div>
                            <label for="desired_domain" class="form-label-custom">
                                Desired ERP Domain / Subdomain <span class="text-xs text-slate-400 font-normal">(Optional)</span>
                            </label>
                            <input type="text"
                                   id="desired_domain"
                                   name="desired_domain"
                                   x-model="formData.desired_domain"
                                   class="form-input-custom font-mono text-xs"
                                   :class="errors.desired_domain ? 'is-invalid' : ''"
                                   placeholder="myschool.yeserp.in">
                            <template x-if="errors.desired_domain">
                                <p class="text-xs text-red-500 font-semibold mt-1" x-text="errors.desired_domain[0]"></p>
                            </template>
                        </div>

                    </div>
                </div>

                <!-- 4. Staff Census Breakdown -->
                <div class="admin-card-light p-6 space-y-5">
                    <div class="flex items-center justify-between pb-3 border-b border-[#e2e1f0]">
                        <h3 class="text-sm font-bold text-[#271e6d] uppercase tracking-wider">
                            Staff Census
                        </h3>
                        <div class="px-3 py-1 rounded-lg bg-[#271e6d] text-white flex items-center gap-2 font-mono text-xs font-bold">
                            <span class="text-slate-300 font-sans text-[11px] font-normal">Total Staff:</span>
                            <span x-text="totalStaff"></span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Teaching Staff -->
                        <div class="p-4 bg-[#f9f9fd] border border-[#e2e2ee] rounded-2xl space-y-3">
                            <div class="flex items-center justify-between pb-2 border-b border-[#e2e2ee]">
                                <span class="font-bold text-xs text-[#271e6d]">Teaching Faculty</span>
                                <span class="px-2 py-0.5 rounded bg-indigo-100 text-indigo-800 font-mono text-xs font-bold">
                                    Sub-total: <span x-text="teachingSubtotal"></span>
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="teaching_male_staff" class="text-[11px] font-semibold text-slate-600 block mb-1">Male Teachers</label>
                                    <input type="number"
                                           id="teaching_male_staff"
                                           name="teaching_male_staff"
                                           x-model.number="formData.teaching_male_staff"
                                           min="0"
                                           required
                                           class="form-input-custom font-mono font-bold text-center">
                                </div>

                                <div>
                                    <label for="teaching_female_staff" class="text-[11px] font-semibold text-slate-600 block mb-1">Female Teachers</label>
                                    <input type="number"
                                           id="teaching_female_staff"
                                           name="teaching_female_staff"
                                           x-model.number="formData.teaching_female_staff"
                                           min="0"
                                           required
                                           class="form-input-custom font-mono font-bold text-center">
                                </div>
                            </div>
                        </div>

                        <!-- Non-Teaching Staff -->
                        <div class="p-4 bg-[#f9f9fd] border border-[#e2e2ee] rounded-2xl space-y-3">
                            <div class="flex items-center justify-between pb-2 border-b border-[#e2e2ee]">
                                <span class="font-bold text-xs text-[#271e6d]">Non-Teaching Staff</span>
                                <span class="px-2 py-0.5 rounded bg-purple-100 text-purple-800 font-mono text-xs font-bold">
                                    Sub-total: <span x-text="nonTeachingSubtotal"></span>
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="non_teaching_male_staff" class="text-[11px] font-semibold text-slate-600 block mb-1">Male Non-Teaching</label>
                                    <input type="number"
                                           id="non_teaching_male_staff"
                                           name="non_teaching_male_staff"
                                           x-model.number="formData.non_teaching_male_staff"
                                           min="0"
                                           required
                                           class="form-input-custom font-mono font-bold text-center">
                                </div>

                                <div>
                                    <label for="non_teaching_female_staff" class="text-[11px] font-semibold text-slate-600 block mb-1">Female Non-Teaching</label>
                                    <input type="number"
                                           id="non_teaching_female_staff"
                                           name="non_teaching_female_staff"
                                           x-model.number="formData.non_teaching_female_staff"
                                           min="0"
                                           required
                                           class="form-input-custom font-mono font-bold text-center">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- 5. Student Census Breakdown -->
                <div class="admin-card-light p-6 space-y-5">
                    <div class="flex items-center justify-between pb-3 border-b border-[#e2e1f0]">
                        <h3 class="text-sm font-bold text-[#271e6d] uppercase tracking-wider">
                            Student Census
                        </h3>
                        <div class="px-3 py-1 rounded-lg bg-indigo-50 border border-indigo-200 text-[#271e6d] flex items-center gap-2 font-mono text-xs font-bold">
                            <span class="text-slate-500 font-sans text-[11px] font-normal">Total Students:</span>
                            <span class="text-base" x-text="totalStudents"></span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="male_students" class="form-label-custom">Male Students Enrolled <span class="text-red-500">*</span></label>
                            <input type="number"
                                   id="male_students"
                                   name="male_students"
                                   x-model.number="formData.male_students"
                                   min="0"
                                   required
                                   class="form-input-custom font-mono font-bold text-center text-base text-[#271e6d]">
                        </div>

                        <div>
                            <label for="female_students" class="form-label-custom">Female Students Enrolled <span class="text-red-500">*</span></label>
                            <input type="number"
                                   id="female_students"
                                   name="female_students"
                                   x-model.number="formData.female_students"
                                   min="0"
                                   required
                                   class="form-input-custom font-mono font-bold text-center text-base text-[#271e6d]">
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="sticky bottom-4 z-40 bg-white/95 backdrop-blur border border-[#e2e1f0] p-4 rounded-2xl shadow-xl flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.schools.show', $school->id) }}"
                           class="px-5 py-2 rounded-xl border border-slate-200 text-slate-600 font-semibold text-xs hover:bg-slate-50 transition-all">
                            Cancel
                        </a>
                        <button type="button"
                                @click="resetForm()"
                                class="px-4 py-2 rounded-xl text-slate-500 hover:text-slate-700 font-medium text-xs transition-all">
                            Reset Form
                        </button>
                    </div>

                    <div>
                        <button type="submit"
                                :disabled="submitting"
                                class="btn-purple-action flex items-center gap-2 text-xs px-6 py-2.5">
                            <template x-if="submitting">
                                <span class="spinner-loader"></span>
                            </template>
                            <span x-text="submitting ? 'Saving Changes...' : 'Save School Changes'"></span>
                        </button>
                    </div>
                </div>

            </form>

        </div>

        <!-- Admin Footer Component -->
        <x-admin-footer />

    </div>

@endsection

@section('scripts')
    <script>
        function schoolEditForm() {
            return {
                formData: {
                    suic_code: '{{ old("suic_code", $school->suic_code ?? $school->code) }}',
                    status: '{{ old("status", $school->status) }}',
                    category_id: '{{ old("category_id", $school->category_id) }}',
                    state_id: '{{ old("state_id", $school->state_id) }}',
                    zone_id: '{{ old("zone_id", $school->zone_id) }}',
                    name: '{{ old("name", addslashes($school->name)) }}',
                    principal_name: '{{ old("principal_name", addslashes($school->principal_name)) }}',
                    phone: '{{ old("phone", $school->phone) }}',
                    email: '{{ old("email", $school->email) }}',
                    address: '{{ old("address", addslashes($school->address)) }}',
                    existing_domain: '{{ old("existing_domain", $school->existing_domain) }}',
                    desired_domain: '{{ old("desired_domain", $school->desired_domain) }}',
                    teaching_male_staff: {{ old('teaching_male_staff', $school->teaching_male_staff ?? 0) }},
                    teaching_female_staff: {{ old('teaching_female_staff', $school->teaching_female_staff ?? 0) }},
                    non_teaching_male_staff: {{ old('non_teaching_male_staff', $school->non_teaching_male_staff ?? 0) }},
                    non_teaching_female_staff: {{ old('non_teaching_female_staff', $school->non_teaching_female_staff ?? 0) }},
                    male_students: {{ old('male_students', $school->male_students ?? 0) }},
                    female_students: {{ old('female_students', $school->female_students ?? 0) }}
                },
                zones: @json($zones),
                loadingZones: false,
                submitting: false,
                errors: {},
                toast: {
                    show: false,
                    type: 'success',
                    message: ''
                },

                initData() {
                    if (this.formData.state_id && (!this.zones || this.zones.length === 0)) {
                        this.fetchZones(this.formData.state_id);
                    }
                },

                get teachingSubtotal() {
                    return (parseInt(this.formData.teaching_male_staff) || 0) + (parseInt(this.formData.teaching_female_staff) || 0);
                },

                get nonTeachingSubtotal() {
                    return (parseInt(this.formData.non_teaching_male_staff) || 0) + (parseInt(this.formData.non_teaching_female_staff) || 0);
                },

                get totalStaff() {
                    return this.teachingSubtotal + this.nonTeachingSubtotal;
                },

                get totalStudents() {
                    return (parseInt(this.formData.male_students) || 0) + (parseInt(this.formData.female_students) || 0);
                },

                statusLabel(status) {
                    if (!status) return '';
                    return status.replace(/_/g, ' ').toUpperCase();
                },

                async onStateChange() {
                    const stateId = this.formData.state_id;
                    this.formData.zone_id = '';
                    this.zones = [];
                    if (stateId) {
                        await this.fetchZones(stateId);
                    }
                },

                async fetchZones(stateId) {
                    this.loadingZones = true;
                    try {
                        const response = await fetch(`{{ route('public.zones') }}?state_id=${stateId}`);
                        if (response.ok) {
                            this.zones = await response.json();
                        } else {
                            this.zones = [];
                        }
                    } catch (e) {
                        console.error('Error fetching zones:', e);
                        this.zones = [];
                    } finally {
                        this.loadingZones = false;
                    }
                },

                resetForm() {
                    if (confirm('Reset form fields to original values?')) {
                        location.reload();
                    }
                },

                showToast(type, message) {
                    this.toast.type = type;
                    this.toast.message = message;
                    this.toast.show = true;
                    setTimeout(() => {
                        this.toast.show = false;
                    }, 5000);
                },

                async submitForm() {
                    this.submitting = true;
                    this.errors = {};

                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                    try {
                        const response = await fetch('{{ route("admin.schools.update", $school->id) }}', {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify(this.formData)
                        });

                        const data = await response.json();

                        if (response.ok && data.success) {
                            this.showToast('success', data.message || 'School details updated successfully!');
                            setTimeout(() => {
                                window.location.href = '{{ route("admin.schools.show", $school->id) }}';
                            }, 1200);
                        } else if (response.status === 422) {
                            this.errors = data.errors || {};
                            this.showToast('error', data.message || 'Please fix validation errors.');
                        } else {
                            this.showToast('error', data.message || 'Failed to update school record.');
                        }
                    } catch (err) {
                        console.error('Submit error:', err);
                        this.showToast('error', 'Network error occurred. Please try again.');
                    } finally {
                        this.submitting = false;
                    }
                }
            }
        }
    </script>
@endsection
