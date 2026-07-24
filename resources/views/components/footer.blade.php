<footer class="relative bg-white text-gray-700 pt-14 pb-8 border-t border-gray-100 overflow-hidden">

    <!-- Watermark Text Backdrop -->
    <div
        class="absolute inset-0 flex items-end justify-center pointer-events-none select-none overflow-hidden opacity-[0.07] z-0 pb-2">
        <h1
            class="text-5xl sm:text-7xl md:text-[110px] lg:text-[150px] xl:text-[190px] font-black text-gray-400 tracking-tighter leading-none text-center whitespace-nowrap uppercase w-full">
            YES INDIA SCHOOLS
        </h1>
    </div>

    <!-- Foreground Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Main Brand Block -->
        <div class="flex flex-col items-center text-center gap-4 pb-10 border-b border-gray-100">
            <!-- Logo -->
            <img src="{{ asset('logo.png') }}" alt="YES INDIA FOUNDATION" class="h-14 w-auto object-contain">
            <!-- Description -->
            <p class="text-sm text-gray-500 leading-relaxed max-w-md">
                Empowering institutions through specialized ERP registration and accreditation systems across India.
                YES INDIA Make an Excellence India.
            </p>
        </div>

        <!-- Bottom Copyright Line -->
        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-400">
            <div>
                &copy; {{ date('Y') }} YES INDIA FOUNDATION. All rights reserved.
            </div>
            <div class="flex items-center gap-4">
                <a href="#" class="hover:text-gray-600 transition-colors">Privacy Policy</a>
                <span class="text-gray-300">&bull;</span>
                <a href="#" class="hover:text-gray-600 transition-colors">Terms of Service</a>
                <span class="text-gray-300">&bull;</span>
                <span class="inline-flex items-center gap-1.5 text-gray-500 font-medium">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    India
                </span>
            </div>
        </div>

    </div>
</footer>