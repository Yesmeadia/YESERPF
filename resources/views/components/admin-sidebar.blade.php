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
        <div class="p-6 flex justify-center items-center bg-white">
            <img src="{{ asset('logo.png') }}" alt="YES INDIA ERP" class="h-10 w-auto object-contain">
            <button @click="open = false"
                class="absolute right-4 lg:hidden text-slate-400 hover:text-slate-700 p-1.5 rounded-lg hover:bg-slate-100 transition-colors">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        <div class="flex-grow overflow-y-auto py-2 px-0 space-y-6">

            <!-- Group: Main -->
            <div>
                <p class="px-6 mb-3 text-[10px] font-bold uppercase tracking-widest text-slate-400">Main Navigation</p>
                <div class="space-y-1">

                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 pr-4 py-2.5 text-sm font-semibold transition-all duration-200 {{ $active == 'dashboard' ? 'bg-[#e5edff] text-[#111c2d] border-l-4 border-[#00030d] rounded-r-2xl' : 'text-[#505f76] hover:bg-slate-50 hover:text-[#111c2d] border-l-4 border-transparent' }}">
                        <div class="w-8 flex justify-center ml-2">
                            <i class="fa-solid fa-table-cells-large text-[15px]"></i>
                        </div>
                        <span>Dashboard</span>
                    </a>

                    <!-- School Directory -->
                    <a href="{{ route('admin.schools.index') }}"
                        class="flex items-center gap-3 pr-4 py-2.5 text-sm font-medium transition-all duration-200 {{ $active == 'schools' ? 'bg-[#e5edff] text-[#111c2d] border-l-4 border-[#00030d] rounded-r-2xl' : 'text-[#505f76] hover:bg-slate-50 hover:text-[#111c2d] border-l-4 border-transparent' }}">
                        <div class="w-8 flex justify-center ml-2">
                            <i class="fa-solid fa-graduation-cap text-[15px]"></i>
                        </div>
                        <span>School Directory</span>
                    </a>

                    <!-- Activity Log -->
                    <a href="{{ route('admin.activity-logs') }}"
                        class="flex items-center gap-3 pr-4 py-2.5 text-sm font-medium transition-all duration-200 {{ $active == 'activity-logs' ? 'bg-[#e5edff] text-[#111c2d] border-l-4 border-[#00030d] rounded-r-2xl' : 'text-[#505f76] hover:bg-slate-50 hover:text-[#111c2d] border-l-4 border-transparent' }}">
                        <div class="w-8 flex justify-center ml-2">
                            <i class="fa-solid fa-clock-rotate-left text-[15px]"></i>
                        </div>
                        <span>Activity Log</span>
                    </a>

                    <!-- Settings -->
                    <a href="{{ route('admin.settings') }}"
                        class="flex items-center gap-3 pr-4 py-2.5 text-sm font-medium transition-all duration-200 {{ $active == 'settings' ? 'bg-[#e5edff] text-[#111c2d] border-l-4 border-[#00030d] rounded-r-2xl' : 'text-[#505f76] hover:bg-slate-50 hover:text-[#111c2d] border-l-4 border-transparent' }}">
                        <div class="w-8 flex justify-center ml-2">
                            <i class="fa-solid fa-gear text-[15px]"></i>
                        </div>
                        <span>Settings</span>
                    </a>

                    <!-- Profile -->
                    <a href="{{ route('admin.profile') }}"
                        class="flex items-center gap-3 pr-4 py-2.5 text-sm font-medium transition-all duration-200 {{ $active == 'profile' ? 'bg-[#e5edff] text-[#111c2d] border-l-4 border-[#00030d] rounded-r-2xl' : 'text-[#505f76] hover:bg-slate-50 hover:text-[#111c2d] border-l-4 border-transparent' }}">
                        <div class="w-8 flex justify-center ml-2">
                            <i class="fa-regular fa-user text-[15px]"></i>
                        </div>
                        <span>Profile</span>
                    </a>

                    <!-- Reports -->
                    <a href="{{ route('admin.reports') }}"
                        class="flex items-center gap-3 pr-4 py-2.5 text-sm font-medium transition-all duration-200 {{ $active == 'reports' ? 'bg-[#e5edff] text-[#111c2d] border-l-4 border-[#00030d] rounded-r-2xl' : 'text-[#505f76] hover:bg-slate-50 hover:text-[#111c2d] border-l-4 border-transparent' }}">
                        <div class="w-8 flex justify-center ml-2">
                            <i class="fa-solid fa-chart-simple text-[15px]"></i>
                        </div>
                        <span>Reports</span>
                    </a>

                </div>
            </div>

            <!-- Group: Quick Actions -->
            <div class="px-6 space-y-3">
                <p class="mb-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">Quick Actions</p>

                <a href="{{ route('register') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#111c2d] bg-white border border-slate-200 hover:border-[#10b981] hover:shadow-sm transition-all duration-200">
                    <i class="fa-solid fa-circle-plus text-[#10b981]"></i>
                    Register New Campus
                </a>

                <a href="{{ route('admin.schools.export.csv') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#111c2d] bg-white border border-slate-200 hover:border-[#f59e0b] hover:shadow-sm transition-all duration-200">
                    <i class="fa-regular fa-file-lines text-[#f59e0b]"></i>
                    Export CSV Records
                </a>

                <a href="{{ route('home') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#111c2d] bg-white border border-slate-200 hover:border-[#6366f1] hover:shadow-sm transition-all duration-200">
                    <i class="fa-regular fa-eye text-[#6366f1]"></i>
                    View Public Status
                </a>
            </div>

        </div>

        <!-- Sidebar Footer -->
        <div class="p-4 bg-white mt-auto border-t border-slate-100">
            <!-- User Card -->
            <div class="flex items-center gap-3 p-3 mb-3 border border-slate-200 rounded-xl bg-white shadow-sm">
                <div class="relative">
                    <div class="w-10 h-10 rounded-full bg-slate-200 overflow-hidden flex items-center justify-center">
                        <!-- Placeholder image or initial -->
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin User') }}&background=e2e8f0&color=475569" alt="User" class="w-full h-full object-cover">
                    </div>
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-white rounded-full"></span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->name ?? 'Admin User' }}</p>
                    <p class="text-[10px] text-slate-500 truncate">{{ ucfirst(str_replace('_', ' ', auth()->user()->role ?? 'Super Admin')) }}</p>
                </div>
                <button class="text-slate-400 hover:text-slate-700 transition-colors">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
            </div>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2.5 px-4 py-3 rounded-xl text-xs font-bold bg-[#00030d] text-white hover:bg-slate-800 transition-all duration-200">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    SIGN OUT
                </button>
            </form>
        </div>

    </aside>

</div>