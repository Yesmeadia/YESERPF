@props(['active' => 'dashboard'])

<!-- Mobile Navigation Header & Sidebar -->
<div x-data="{ open: false }" @open-sidebar.window="open = true" class="relative z-50 font-sans font-normal">

    <!-- Mobile Backdrop -->
    <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="open = false"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm lg:hidden">
    </div>

    <!-- Mobile Top Header Bar -->
    <div
        class="lg:hidden sticky top-0 z-40 px-4 py-3 flex items-center justify-between bg-white border-b border-slate-200/80 shadow-sm">
        <div class="flex items-center gap-3">
            <button @click="open = !open"
                class="p-2 rounded-xl text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                <i class="fa-solid fa-bars text-sm"></i>
            </button>
            <img src="{{ asset('logo.png') }}" alt="YES INDIA ERP" class="h-8 w-auto object-contain">
        </div>
        <span
            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
            Admin Console
        </span>
    </div>

    <!-- Sidebar Main Aside Container -->
    <aside :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed top-0 left-0 bottom-0 w-64 z-50 transition-transform duration-300 ease-in-out flex flex-col bg-white border-r border-slate-200/80 shadow-sm font-sans font-normal">

        <!-- Logo Header -->
        <div class="p-5 flex justify-between items-center border-b border-slate-100 bg-white">
            <div class="flex items-center gap-3">
                <img src="{{ asset('logo.png') }}" alt="YES INDIA ERP" class="h-9 w-auto object-contain">
            </div>
            <button @click="open = false"
                class="lg:hidden text-slate-400 hover:text-slate-700 p-1.5 rounded-lg hover:bg-slate-100 transition-colors">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <!-- Admin Avatar Strip -->
        <div class="px-3.5 py-3 mx-3 mt-3 rounded-2xl bg-slate-50 border border-slate-200/70">
            <div class="flex items-center gap-3">
                <div
                    class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-sm flex-shrink-0 bg-[#271e6d] text-white shadow-xs">
                    {{ strtoupper(substr(auth()->user()->name ?? 'AD', 0, 2)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-slate-800 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-[10px] text-slate-500 truncate font-normal">
                        {{ ucfirst(str_replace('_', ' ', auth()->user()->role ?? 'admin')) }}</p>
                </div>
                <a href="{{ route('admin.settings') }}"
                    class="ml-auto w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0 text-slate-400 hover:text-slate-700 hover:bg-slate-200/60 transition-colors"
                    title="Settings">
                    <i class="fa-solid fa-gear text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Navigation Links -->
        <div class="flex-grow overflow-y-auto py-4 px-3 space-y-5">

            <!-- Group: Main -->
            <div>
                <p class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Main Navigation</p>
                <div class="space-y-1">

                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-normal transition-all duration-200 {{ $active == 'dashboard' ? 'bg-[#271e6d] text-white font-semibold shadow-sm shadow-[#271e6d]/20' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900' }}">
                        <div
                            class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 transition-colors text-xs {{ $active == 'dashboard' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-slate-200 group-hover:text-slate-800' }}">
                            <i class="fa-solid fa-chart-pie"></i>
                        </div>
                        <span>Executive Dashboard</span>
                        @if($active == 'dashboard')
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        @endif
                    </a>

                    <!-- School Directory -->
                    <a href="{{ route('admin.schools.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-normal transition-all duration-200 {{ $active == 'schools' ? 'bg-[#271e6d] text-white font-semibold shadow-sm shadow-[#271e6d]/20' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900' }}">
                        <div
                            class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 transition-colors text-xs {{ $active == 'schools' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-slate-200 group-hover:text-slate-800' }}">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <span>School Directory</span>
                        @if($active == 'schools')
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        @endif
                    </a>

                    <!-- Settings -->
                    <a href="{{ route('admin.settings') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-normal transition-all duration-200 {{ $active == 'settings' ? 'bg-[#271e6d] text-white font-semibold shadow-sm shadow-[#271e6d]/20' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900' }}">
                        <div
                            class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 transition-colors text-xs {{ $active == 'settings' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-slate-200 group-hover:text-slate-800' }}">
                            <i class="fa-solid fa-gear"></i>
                        </div>
                        <span>Settings &amp; Profile</span>
                        @if($active == 'settings')
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        @endif
                    </a>

                </div>
            </div>

            <!-- Group: Quick Actions -->
            <div>
                <p class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Quick Actions</p>
                <div class="space-y-1">

                    <a href="{{ route('register') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-normal text-slate-600 hover:bg-slate-100/80 hover:text-slate-900 transition-all duration-200">
                        <div
                            class="w-7 h-7 rounded-lg text-xs flex items-center justify-center shrink-0 bg-emerald-50 text-emerald-600 border border-emerald-200/60 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-circle-plus"></i>
                        </div>
                        <span>Register New Campus</span>
                    </a>

                    <a href="{{ route('admin.schools.export.csv') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-normal text-slate-600 hover:bg-slate-100/80 hover:text-slate-900 transition-all duration-200">
                        <div
                            class="w-7 h-7 rounded-lg text-xs flex items-center justify-center shrink-0 bg-amber-50 text-amber-600 border border-amber-200/60 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-file-export"></i>
                        </div>
                        <span>Export CSV Records</span>
                    </a>

                    <a href="{{ route('home') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-normal text-slate-600 hover:bg-slate-100/80 hover:text-slate-900 transition-all duration-200">
                        <div
                            class="w-7 h-7 rounded-lg text-xs flex items-center justify-center shrink-0 bg-blue-50 text-blue-600 border border-blue-200/60 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-compass"></i>
                        </div>
                        <span>View Public Status</span>
                    </a>

                </div>
            </div>

        </div>

        <!-- Sidebar Footer -->
        <div class="p-3 border-t border-slate-100 bg-slate-50/50">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2.5 px-4 py-2.5 rounded-xl text-xs font-semibold bg-red-50 text-red-600 border border-red-200/80 hover:bg-red-600 hover:text-white hover:border-red-600 transition-all duration-200">
                    <i class="fa-solid fa-right-from-bracket text-xs"></i>
                    Sign Out Console
                </button>
            </form>
            <div class="flex items-center justify-between px-1 mt-2.5 text-[10px] text-slate-400 font-mono">
                <span>YES Schools ERP</span>
                <span
                    class="px-1.5 py-0.5 rounded bg-slate-200/70 text-slate-600 font-semibold border border-slate-300/40">v2.4.0</span>
            </div>
        </div>

    </aside>

</div>