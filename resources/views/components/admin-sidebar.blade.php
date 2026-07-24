@props(['active' => 'dashboard'])

<!-- Mobile Navigation Header & Sidebar -->
<div x-data="{ open: false }" @open-sidebar.window="open = true" class="relative z-50">

    <!-- Mobile Backdrop -->
    <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="open = false"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm lg:hidden">
    </div>

    <!-- Mobile Top Header Bar -->
    <div class="lg:hidden sticky top-0 z-40 bg-[#1b134f] border-b border-indigo-950/60 px-4 py-3 flex items-center justify-between shadow-md">
        <div class="flex items-center gap-3">
            <button @click="open = !open"
                class="p-2 rounded-xl bg-white/10 text-white hover:bg-white/20 transition-colors">
                <i class="fa-solid fa-bars text-sm"></i>
            </button>
            <img src="{{ asset('logo1.png') }}" alt="YES INDIA ERP" class="h-9 w-auto object-contain">
        </div>

        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-[11px] font-semibold">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
            Admin Portal
        </span>
    </div>

    <!-- Sidebar Main Aside Container -->
    <aside :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed top-0 left-0 bottom-0 w-64 bg-gradient-to-b from-[#1b134f] via-[#211860] to-[#160e42] text-white z-50 transition-transform duration-300 ease-in-out flex flex-col shadow-2xl border-r border-indigo-900/40">

        <!-- Top Section: Logo Header -->
        <div class="p-5 border-b border-indigo-800/40 space-y-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('logo1.png') }}" alt="YES INDIA ERP"
                        class="h-10 w-auto object-contain drop-shadow-md">
                </div>
                <button @click="open = false" class="lg:hidden text-slate-400 hover:text-white p-1">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Navigation Links Container -->
        <div class="flex-grow overflow-y-auto p-4 space-y-6">

            <!-- Group 1: Core Navigation -->
            <div>
                <div class="px-3 mb-2.5 text-[10px] uppercase tracking-widest text-indigo-300/70 font-extrabold flex items-center gap-2">
                    <span>Navigation</span>
                    <span class="flex-grow h-px bg-indigo-900/50"></span>
                </div>

                <div class="space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" class="group relative flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 text-xs font-semibold
                              {{ $active == 'dashboard'
    ? 'bg-gradient-to-r from-purple-600 to-indigo-600 text-white shadow-lg shadow-purple-900/40 border border-purple-400/30'
    : 'text-indigo-100/80 hover:bg-white/10 hover:text-white' }}">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 transition-colors
                                    {{ $active == 'dashboard' ? 'bg-white/20 text-white' : 'text-purple-300 group-hover:text-white' }}">
                            <i class="fa-solid fa-chart-line text-sm"></i>
                        </div>
                        <span>Executive Dashboard</span>
                        @if($active == 'dashboard')
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                        @endif
                    </a>

                    <!-- School Directory -->
                    <a href="{{ route('admin.schools.index') }}" class="group relative flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 text-xs font-semibold
                              {{ $active == 'schools'
    ? 'bg-gradient-to-r from-purple-600 to-indigo-600 text-white shadow-lg shadow-purple-900/40 border border-purple-400/30'
    : 'text-indigo-100/80 hover:bg-white/10 hover:text-white' }}">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 transition-colors
                                    {{ $active == 'schools' ? 'bg-white/20 text-white' : 'text-purple-300 group-hover:text-white' }}">
                            <i class="fa-solid fa-building-columns text-sm"></i>
                        </div>
                        <span>School Directory</span>
                        @if($active == 'schools')
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Group 2: Quick Management Tools -->
            <div>
                <div class="px-3 mb-2.5 text-[10px] uppercase tracking-widest text-indigo-300/70 font-extrabold flex items-center gap-2">
                    <span>Quick Actions</span>
                    <span class="flex-grow h-px bg-indigo-900/50"></span>
                </div>

                <div class="space-y-1">
                    <a href="{{ route('register') }}" target="_blank"
                        class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-medium text-indigo-100/80 hover:bg-white/10 hover:text-white transition-all duration-200">
                        <div class="w-7 h-7 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white flex items-center justify-center shrink-0 transition-colors">
                            <i class="fa-solid fa-circle-plus text-xs"></i>
                        </div>
                        <span>Register New Campus</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-indigo-300/50 ml-auto group-hover:text-indigo-200"></i>
                    </a>

                    <a href="{{ route('admin.schools.export.csv') }}"
                        class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-medium text-indigo-100/80 hover:bg-white/10 hover:text-white transition-all duration-200">
                        <div class="w-7 h-7 rounded-lg bg-amber-500/10 border border-amber-500/20 text-amber-400 group-hover:bg-amber-500 group-hover:text-white flex items-center justify-center shrink-0 transition-colors">
                            <i class="fa-solid fa-file-export text-xs"></i>
                        </div>
                        <span>Export CSV Records</span>
                    </a>

                    <a href="{{ route('home') }}" target="_blank"
                        class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-medium text-indigo-100/80 hover:bg-white/10 hover:text-white transition-all duration-200">
                        <div class="w-7 h-7 rounded-lg bg-blue-500/10 border border-blue-500/20 text-blue-400 group-hover:bg-blue-500 group-hover:text-white flex items-center justify-center shrink-0 transition-colors">
                            <i class="fa-solid fa-compass text-xs"></i>
                        </div>
                        <span>View Public Portal</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-indigo-300/50 ml-auto group-hover:text-indigo-200"></i>
                    </a>
                </div>
            </div>

        </div>

        <!-- Sidebar Footer: Sign Out & System Badge -->
        <div class="p-4 border-t border-indigo-800/40 bg-black/10 space-y-3">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2.5 px-4 py-2.5 rounded-xl bg-rose-500/10 hover:bg-rose-600 text-rose-300 hover:text-white border border-rose-500/20 hover:border-rose-600 text-xs font-bold transition-all duration-200 shadow-sm group">
                    <i class="fa-solid fa-right-from-bracket text-xs group-hover:-translate-x-0.5 transition-transform"></i>
                    <span>Sign Out Console</span>
                </button>
            </form>

            <div class="flex items-center justify-between px-1 text-[10px] text-indigo-300/60 font-mono">
                <span>Schools ERP System</span>
                <span class="px-1.5 py-0.5 rounded bg-indigo-900/60 border border-indigo-700/50">v2.4.0</span>
            </div>
        </div>

    </aside>

</div>