@props(['active' => 'dashboard'])

<!-- Mobile Navigation Header & Sidebar -->
<div x-data="{ open: false }" @open-sidebar.window="open = true" class="relative z-50">

    <!-- Mobile Backdrop -->
    <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="open = false"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm lg:hidden">
    </div>

    <!-- Mobile Header -->
    <div
        class="lg:hidden sticky top-0 z-40 bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <button @click="open = !open" class="p-2 rounded-lg bg-slate-100 hover:bg-slate-200">
                <i class="fa-solid fa-bars text-slate-700"></i>
            </button>

            <img src="{{ asset('logo1.png') }}" alt="Logo" class="h-10 w-auto object-contain">

        </div>

        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-[11px] font-semibold">
            Admin
        </span>
    </div>

    <!-- Sidebar -->
    <aside :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed top-0 left-0 bottom-0 w-64 bg-blue-700 text-white z-50 transition-transform duration-300 ease-in-out flex flex-col shadow-2xl">

        <!-- Top -->
        <div class="flex flex-col flex-grow overflow-y-auto">

            <!-- Logo -->
            <div class="p-6 border-b border-blue-600">

                <div class="relative flex justify-center items-center">

                    <img src="{{ asset('logo1.png') }}" alt="Logo" class="h-20 w-auto object-contain">

                    <button @click="open = false" class="lg:hidden absolute right-0 text-white hover:text-gray-200">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>

                </div>

            </div>

            <!-- Navigation -->
            <nav class="p-4 flex-grow">

                <!-- Navigation -->
                <div class="mb-8">

                    <div class="px-3 mb-3 text-[11px] uppercase tracking-widest text-blue-200 font-bold">
                        Menu Navigation
                    </div>

                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl mb-2 transition-all duration-200
                        {{ $active == 'dashboard'
    ? 'bg-white text-blue-700 font-bold shadow-lg'
    : 'text-blue-100 hover:bg-blue-600 hover:text-white' }}">

                        <i class="fa-solid fa-chart-pie text-base"></i>

                        <span class="text-sm">
                            Dashboard
                        </span>

                    </a>

                    <!-- Schools -->
                    <a href="{{ route('admin.schools.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                        {{ $active == 'schools'
    ? 'bg-white text-blue-700 font-bold shadow-lg'
    : 'text-blue-100 hover:bg-blue-600 hover:text-white' }}">

                        <i class="fa-solid fa-school text-base"></i>

                        <span class="text-sm">
                            School Directory
                        </span>

                    </a>

                </div>

                <!-- Quick Actions -->
                <div>

                    <div class="px-3 mb-3 text-[11px] uppercase tracking-widest text-blue-200 font-bold">
                        Quick Actions
                    </div>

                    <a href="{{ route('register') }}" target="_blank"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl mb-2 text-blue-100 hover:bg-blue-600 transition">

                        <i class="fa-solid fa-circle-plus text-emerald-300"></i>

                        <span class="text-sm">
                            Register New Campus
                        </span>

                    </a>

                    <a href="{{ route('admin.schools.export.csv') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl mb-2 text-blue-100 hover:bg-blue-600 transition">

                        <i class="fa-solid fa-file-csv text-emerald-300"></i>

                        <span class="text-sm">
                            Export CSV Records
                        </span>

                    </a>

                    <a href="{{ route('home') }}" target="_blank"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-blue-100 hover:bg-blue-600 transition">

                        <i class="fa-solid fa-globe text-blue-200"></i>

                        <span class="text-sm">
                            View Public Site
                        </span>

                    </a>

                </div>

            </nav>

        </div>

        <!-- Footer -->
        <div class="p-4 border-t border-blue-600">

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf

                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-white text-blue-700 hover:bg-blue-100 rounded-xl py-3 font-semibold transition">

                    <i class="fa-solid fa-right-from-bracket"></i>

                    <span>
                        Sign Out
                    </span>

                </button>

            </form>

            <div class="mt-4 text-center text-[11px] text-blue-200">
                Schools ERP v2.4.0
            </div>

        </div>

    </aside>

</div>