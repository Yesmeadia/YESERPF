<footer class="bg-white border-t border-slate-200 text-slate-500 py-4 mt-8 text-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-3 text-[11px]">
        <div>
            &copy; {{ date('Y') }} YES INDIA FOUNDATION. All rights reserved.
        </div>
        <div class="flex items-center gap-3">
            <span class="font-mono text-slate-400">v2.4.0</span>
            <span class="text-slate-300">&bull;</span>
            <a href="{{ route('home') }}" target="_blank" class="text-[#271e6d] font-semibold hover:underline flex items-center gap-1">
                <i class="fa-solid fa-globe text-[10px]"></i> Public Site
            </a>
        </div>
    </div>
</footer>