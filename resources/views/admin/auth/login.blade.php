@extends('layouts.app')

@section('title', 'Admin Sign In - YES INDIA SCHOOLS ERP')

@section('styles')
<style>
    body {
        background-color: #f8fafc !important;
        color: #1e293b !important;
        font-family: 'Inter', sans-serif;
    }

    .login-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }

    .form-pill-input-login {
        width: 100%;
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 11px 16px 11px 40px;
        font-size: 0.875rem;
        color: #0f172a;
        outline: none;
        transition: all 0.2s ease;
    }

    .form-pill-input-login:focus {
        background-color: #ffffff;
        border-color: #271e6d;
        box-shadow: 0 0 0 3px rgba(39, 30, 109, 0.10);
    }

    .btn-purple-login {
        background-color: #271e6d;
        color: #ffffff;
        border-radius: 12px;
        padding: 12px;
        font-weight: 700;
        font-size: 0.9rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-purple-login:hover {
        background-color: #1f1659;
    }
</style>
@endsection

@section('content')
<div class="min-h-[85vh] flex items-center justify-center p-4 sm:p-6">

    <div class="w-full max-w-md login-card p-8 space-y-6">

        <!-- Logo & Title -->
        <div class="text-center space-y-3">
            <div class="w-14 h-14 rounded-2xl bg-[#f3f2fa] border border-[#e2e1f0] p-2.5 mx-auto flex items-center justify-center">
                <img src="{{ asset('logo.png') }}" alt="YES INDIA FOUNDATION" class="w-full h-full object-contain">
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-[#271e6d]">YES INDIA SCHOOLS ERP</h1>
                <p class="text-xs text-slate-500 mt-1">Admin Executive Console</p>
            </div>
        </div>

        <!-- Demo Credentials Box -->
        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700 space-y-1.5">
            <div class="font-bold text-[#271e6d] flex items-center gap-1.5">
                <i class="fa-solid fa-circle-info"></i> Demo Admin Account
            </div>
            <div class="flex items-center justify-between text-[11px] font-mono pt-1 border-t border-slate-200/60">
                <span>Email: <strong>admin@erp.com</strong></span>
                <span>Pass: <strong>password</strong></span>
            </div>
        </div>

        <!-- Validation Alerts -->
        @if($errors->any())
            <div class="p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation text-red-500 shrink-0"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-envelope text-xs"></i>
                    </div>
                    <input type="email" name="email" value="{{ old('email', 'admin@erp.com') }}" required
                           class="form-pill-input-login" placeholder="admin@erp.com">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-lock text-xs"></i>
                    </div>
                    <input type="password" name="password" value="password" required
                           class="form-pill-input-login" placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center gap-2 text-slate-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-[#271e6d] focus:ring-[#271e6d]">
                    <span>Remember me</span>
                </label>
            </div>

            <button type="submit" class="btn-purple-login w-full flex items-center justify-center gap-2">
                <i class="fa-solid fa-right-to-bracket text-xs"></i>
                <span>Sign In to Admin</span>
            </button>
        </form>

        <div class="pt-4 border-t border-slate-100 text-center">
            <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-[#271e6d] transition-colors inline-flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left text-[11px]"></i> Return to Public Directory
            </a>
        </div>

    </div>

</div>
@endsection
