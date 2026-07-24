@extends('layouts.app')

@section('title', 'Admin Sign In - YES INDIA SCHOOLS ERP')

@section('styles')
    <style>
        body {
            background-color: #f8fafc !important;
        }

        .hero-split-left {
            background: linear-gradient(135deg, #1b134f 0%, #271e6d 50%, #3b2e9e 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-bg-pattern {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.12) 1px, transparent 1px);
            background-size: 24px 24px;
            opacity: 0.6;
        }

        .glass-pill-badge {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .form-input-pill {
            width: 100%;
            background-color: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            padding: 12px 16px 12px 42px;
            font-size: 0.875rem;
            color: #0f172a;
            outline: none;
            transition: all 0.2s ease-in-out;
        }

        .form-input-pill:focus {
            background-color: #ffffff;
            border-color: #271e6d;
            box-shadow: 0 0 0 4px rgba(39, 30, 109, 0.12);
        }

        .btn-login-primary {
            background: linear-gradient(135deg, #271e6d 0%, #1f1659 100%);
            color: #ffffff;
            border-radius: 14px;
            padding: 13px 24px;
            font-weight: 700;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            box-shadow: 0 10px 25px -5px rgba(39, 30, 109, 0.4);
            transition: all 0.2s ease;
        }

        .btn-login-primary:hover {
            background: linear-gradient(135deg, #1f1659 0%, #171045 100%);
            transform: translateY(-1px);
            box-shadow: 0 14px 28px -4px rgba(39, 30, 109, 0.5);
        }

        .btn-login-primary:active {
            transform: translateY(0);
        }
    </style>
@endsection

@section('content')
    <div class="min-h-screen flex flex-col lg:flex-row bg-slate-50">

        <!-- LEFT PART: Branding & Feature Hero -->
        <div
            class="hero-split-left lg:w-1/2 min-h-[360px] lg:min-h-screen p-8 lg:p-16 flex flex-col justify-between text-white relative">
            <div class="hero-bg-pattern"></div>

            <!-- Glowing decorative background blurs -->
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl pointer-events-none">
            </div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none">
            </div>

            <!-- Top branding logo (Clean logo without box background) -->
            <div class="relative z-10 flex items-center gap-3.5">
                <img src="{{ asset('logo1.png') }}" alt="YES INDIA FOUNDATION"
                    class="h-12 w-auto object-contain drop-shadow-md">
            </div>

            <!-- Hero Content Body -->
            <div class="relative z-10 my-auto py-10 max-w-xl">
                <div
                    class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full glass-pill-badge text-xs font-semibold text-purple-100 mb-6">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Executive Admin Portal
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight tracking-tight mb-4">
                    Manage & Monitor <br />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-200 via-indigo-200 to-pink-200">
                        School Networks
                    </span>
                </h1>

                <p class="text-purple-100/90 text-sm sm:text-base leading-relaxed mb-8">
                    Empowering administrators with real-time school directory tracking, verified status management, and
                    complete operational governance across all zones.
                </p>

                <!-- Feature Highlights -->
                <div class="space-y-4">
                    <div class="flex items-start gap-3.5">
                        <div
                            class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center shrink-0 text-purple-200 border border-white/10">
                            <i class="fa-solid fa-shield-halved text-sm"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-white">Centralized Management</h4>
                            <p class="text-xs text-purple-200/80">Manage institutional profiles, status verification, and
                                contact details seamlessly.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5">
                        <div
                            class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center shrink-0 text-purple-200 border border-white/10">
                            <i class="fa-solid fa-chart-pie text-sm"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-white">Real-Time Analytics & Reports</h4>
                            <p class="text-xs text-purple-200/80">Filter schools by zone, district, or category with instant
                                dynamic stats.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hero Footer -->
            <div
                class="relative z-10 pt-6 border-t border-white/10 flex flex-wrap items-center justify-between gap-4 text-xs text-purple-200/70">
                <span>&copy; {{ date('Y') }} YES INDIA FOUNDATION. All rights reserved.</span>
                <div class="flex items-center gap-4">
                    <span class="hover:text-white transition-colors cursor-pointer">Security</span>
                    <span class="hover:text-white transition-colors cursor-pointer">Support</span>
                </div>
            </div>
        </div>

        <!-- RIGHT PART: Login Form Panel -->
        <div class="lg:w-1/2 flex items-center justify-center p-6 sm:p-12 lg:p-16">
            <div
                class="w-full max-w-md space-y-8 bg-white p-8 sm:p-10 rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100">

                <!-- Header section inside form panel -->
                <div class="space-y-4 text-center sm:text-left">
                    <!-- Clean logo display without box background -->
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Welcome</h2>
                        <p class="text-sm text-slate-500 mt-1.5">Enter your credentials to access the executive dashboard
                        </p>
                    </div>
                </div>

                <!-- Validation Errors -->
                @if($errors->any())
                    <div
                        class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm flex items-start gap-3">
                        <i class="fa-solid fa-circle-exclamation text-rose-500 text-base shrink-0 mt-0.5"></i>
                        <div class="space-y-1">
                            <p class="font-bold">Authentication Failed</p>
                            <p>{{ $errors->first() }}</p>
                        </div>
                    </div>
                @endif

                <!-- Sign In Form -->
                <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5"
                    x-data="{ showPassword: false }">
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Email Address
                        </label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-envelope text-sm"></i>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                class="form-input-pill" placeholder="admin@domain.com" autocomplete="email">
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                Password
                            </label>
                        </div>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-lock text-sm"></i>
                            </div>
                            <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required
                                class="form-input-pill pr-10" placeholder="••••••••" autocomplete="current-password">
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                <i class="fa-solid text-xs" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center gap-2.5 text-slate-600 font-medium cursor-pointer select-none">
                            <input type="checkbox" name="remember"
                                class="w-4 h-4 rounded border-slate-300 text-[#271e6d] focus:ring-[#271e6d] transition">
                            <span>Keep me logged in</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-login-primary w-full flex items-center justify-center gap-2.5 group">
                        <span>Sign In</span>
                        <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>

                <!-- Bottom Navigation Link -->
                <div class="pt-6 border-t border-slate-100 text-center">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-[#271e6d] transition-colors">
                        <i class="fa-solid fa-arrow-left text-[11px]"></i> Back to Public Directory
                    </a>
                </div>

            </div>
        </div>

    </div>
@endsection